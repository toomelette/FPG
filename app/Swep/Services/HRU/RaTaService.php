<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class RaTaService
{
    public function __construct(
        public MonthlyPayrollService $monthlyPayrollService,
        public PayrollService $payrollService,
    )
    {

    }

    private function getFactor($actualDaysWorked)
    {
        if($actualDaysWorked <= 0){
            return 0;
        }
        if($actualDaysWorked >= 1 && $actualDaysWorked <= 5){
            return 0.25;
        }
        if($actualDaysWorked >= 6 && $actualDaysWorked <= 11){
            return 0.5;
        }
        if($actualDaysWorked >= 12 && $actualDaysWorked <= 16){
            return 0.75;
        }
        if($actualDaysWorked >= 17){
            return 1;
        }
    }
    public function recompute($payrollMasterSlug,$payMasterEmployeeSlug = null)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
                'payrollMasterEmployees.employee.payrollSettings'
            ])
            ->findOrFail($payrollMasterSlug);


        $this->payrollService->updateEmployeesData($payrollMaster,$payMasterEmployeeSlug);


        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $totalRata = $payrollMasterEmployee?->employee?->payrollSettings?->ra_rate + $payrollMasterEmployee?->employee?->payrollSettings?->ta_rate;
            $actualDaysWorked = $payrollMasterEmployee->rata_actual_days_worked ?? 22;
            $factor = $this->getFactor($actualDaysWorked);

            $modifiedRata = $totalRata * $factor;
            $upsert[] = [
                'saved_employee_data' => json_encode($payrollMasterEmployee->saved_employee_data),
                'slug' => $payrollMasterEmployee->slug,
                'rata_ra_rate' => $payrollMasterEmployee?->employee?->payrollSettings?->ra_rate,
                'rata_ta_rate' => $payrollMasterEmployee?->employee?->payrollSettings?->ta_rate,
                'rata_actual_days_worked' => $actualDaysWorked,
                'rata_total' => $modifiedRata,
                'rata_net_amount' => $modifiedRata - $payrollMasterEmployee->rata_deductions,
            ];
        }

        PayrollMasterEmployees::query()->upsert(
            $upsert,
            ['slug'],
            [
                'saved_employee_data',
                'rata_ra_rate',
                'rata_ta_rate',
                'rata_actual_days_worked',
                'rata_total',
                'rata_net_amount',
            ]);


        if($payMasterEmployeeSlug != null){
            $payrollMaster->load('payrollMasterEmployees');
            return view('_payroll.payroll-preparation.RATA.preview-row')->with([
                'employee' => $payrollMaster->payrollMasterEmployees->where('slug',$payMasterEmployeeSlug)->first(),
            ]);
        }
        $payrollMaster->load('payrollMasterEmployees');
        return view('_payroll.payroll-preparation.RATA.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function update(Request $request,$payrollMaster)
    {

        if($request->has('updateRataDays')){

            $employeeFromList = PayrollMasterEmployees::query()->findOrFail($request->employeeListSlug);
            $employeeFromList->rata_actual_days_worked = $request->rata_actual_days_worked;
            if($employeeFromList->save()){
                return $this->recompute($payrollMaster->slug,$request->employeeListSlug);
            }
        }
        if($request->has('updateRataDeductions')){
            $employeeFromList = PayrollMasterEmployees::query()->findOrFail($request->employeeListSlug);
            $employeeFromList->rata_deductions = Helper::sanitizeAutonum($request->rata_deductions);
            if($employeeFromList->save()){
                return $this->recompute($payrollMaster->slug,$request->employeeListSlug);
            }
        }

    }

    public function printPayroll($slug)
    {
        $request = Request::capture();
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($payrollMasterEmployees) use($request) {
                    //Payroll Groups
                    if($request->has('payrollGroupsSelected') && count($request->payrollGroupsSelected) > 0){
                        $payrollMasterEmployees->where(function ($filter) use ($request){
                            foreach ($request->payrollGroupsSelected as $payrollGroupSelected){
                                $filter->orWhere('employee_payroll_type',$payrollGroupSelected);
                            }
                        });
                    }
                },
            ])
            ->findOrFail($slug);
        $payrollMasterCopy = $payrollMaster;
        $usedRcs = $payrollMaster->payrollMasterEmployees->pluck('saved_employee_data.resp_center')->unique();


        $usedRcsDB = PPURespCodes::query()
            ->whereIn('rc_code',$usedRcs->values())
            ->with(['description','payrollTree'])
            ->get();

        $groupedByDept = $payrollMaster->payrollMasterEmployees
            ->sortBy(function ($data) use ($usedRcsDB){
                return $usedRcsDB->where('rc_code','=',$data->saved_employee_data['resp_center'])->first()->payrollTree->sort;
            })
            ->groupBy(function ($data) use ($usedRcsDB){
                return $usedRcsDB->where('rc_code','=',$data->saved_employee_data['resp_center'])->first()->rc;
            });


        return Pdf::view('printables.hru.payroll_preparation.RATA.monthly_payroll',[
            'pdfPrint' => true,
            'payrollMaster' => $payrollMasterCopy,
            'usedRcsDB' => $usedRcsDB,
            'groupedByDept' => $groupedByDept,
        ])
            ->paperSize('215.9','330.2')
            ->landscape()
            ->margins(8,8, 15, 8)
            ->headers(['title' => 'aaaaa'])
            ->footerView('printables.hru.payroll_preparation.footer-view')
            ->name('Payroll Summary.pdf')
            ->withBrowsershot(function (Browsershot $browsershot){
                if(app()->environment('production')){
                    $browsershot->setNodeBinary(env('NODE_BINARY'))
                        ->setNpmBinary(env('NODE_BINARY'));
                }
            });


        return view('printables.hru.payroll_preparation.RATA.monthly_payroll')->with([
            'payrollMaster' => $payrollMasterCopy,
            'usedRcsDB' => $usedRcsDB,
            'groupedByDept' => $groupedByDept,
        ]);
    }

}