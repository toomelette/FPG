<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\PPU\PPURespCodes;
use App\Models\PPU\RCDesc;
use App\Models\RC;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class HazardPrcService
{
    public function __construct(
        public MonthlyPayrollService $monthlyPayrollService,
    )
    {
        $this->daysInMonth = 22;
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
        $this->monthlyPayrollService->updateEmployeesData($payrollMaster,null);

        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $hazardPayGross = $payrollMasterEmployee->saved_employee_data["monthly_basic"] * 0.3;
            $eligibleDays = $this->daysInMonth - $payrollMasterEmployee->hazardprc_ineligible_days;
            $hazardPayLessIneligible = $eligibleDays / $this->daysInMonth * $hazardPayGross;
            $hazardPayTax =   $hazardPayLessIneligible * $payrollMasterEmployee->hazardprc_tax_rate;
            $hazardPayNet = $hazardPayLessIneligible - $hazardPayTax;
            $upsert[] = [
                'saved_employee_data' => json_encode($payrollMasterEmployee->saved_employee_data),
                'slug' => $payrollMasterEmployee->slug,
                'hazardprc_gross' => $hazardPayGross,
                'hazardprc_all_days' => $this->daysInMonth,
                'hazardprc_tax_rate' => $payrollMasterEmployee?->employee?->payrollSettings?->hazard_prc_tax_rate,
                'hazardprc_net_amount' => $hazardPayNet,
                'hazardprc_eligible_days' => $eligibleDays,
                'hazardprc_tax' => $hazardPayTax,
            ];
        }

        PayrollMasterEmployees::query()->upsert(
            $upsert,
            ['slug'],
            [
                'saved_employee_data',
                'hazardprc_gross',
                'hazardprc_all_days',
                'hazardprc_tax_rate',
                'hazardprc_net_amount',
                'hazardprc_eligible_days',
                'hazardprc_tax',
            ]);


        if($payMasterEmployeeSlug != null){
            $payrollMaster->load('payrollMasterEmployees');
            return view('_payroll.payroll-preparation.HAZARDPRC.preview-row')->with([
                'employee' => $payrollMaster->payrollMasterEmployees->where('slug',$payMasterEmployeeSlug)->first(),
            ]);
        }
        $payrollMaster->load('payrollMasterEmployees');
        return view('_payroll.payroll-preparation.HAZARDPRC.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function update(Request $request,$payrollMaster)
    {
        if($request->has('updateHazardDays') && $request->updateHazardDays == true){
            $employeeFromList = PayrollMasterEmployees::query()->findOrFail($request->employeeListSlug);
            $employeeFromList->hazardprc_ineligible_days = $request->ineligible_days;
            if($employeeFromList->save()){
                return $this->recompute($payrollMaster->slug,$request->employeeListSlug);
            }
        }

    }

    public function showEmployee($payMasterSlug,Request $request)
    {

        $employeePayrollList = PayrollMasterEmployees::query()
            ->with([
                'employeePayrollDetails',
            ])
            ->where('slug','=',$request->employeePayrollListSlug)
            ->first();
        return view('_payroll.payroll-preparation.HAZARDPRC.show-employee')->with([
            'employeePayrollListSlug' => $request->employeePayrollListSlug,
            'employeePayrollList' => $employeePayrollList,
            'payMasterSlug' => $payMasterSlug,
        ]);
    }


    public function printPayroll($slug)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees'
            ])
            ->findOrFail($slug);
        $payrollMasterCopy = $payrollMaster;
        $usedRcs = $payrollMaster->payrollMasterEmployees->pluck('saved_employee_data.resp_center')->unique();


        $usedRcsDB = PPURespCodes::query()
            ->whereIn('rc_code',$usedRcs->values())
            ->with(['description'])
            ->get();

        $groupedByDept = $payrollMaster->payrollMasterEmployees->groupBy(function ($data) use ($usedRcsDB){
            return $usedRcsDB->where('rc_code','=',$data->saved_employee_data['resp_center'])->first()->rc;
        });

        return Pdf::view('printables.hru.payroll_preparation.HAZARDPRC.monthly_payroll',[
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

        return view('printables.hru.payroll_preparation.HAZARDPRC.monthly_payroll')->with([
            'payrollMaster' => $payrollMasterCopy,
            'usedRcsDB' => $usedRcsDB,
            'groupedByDept' => $groupedByDept,
        ]);
    }

}