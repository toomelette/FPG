<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterEmployees;
use Illuminate\Http\Request;

class RaTaService
{
    public function __construct(
        public MonthlyPayrollService $monthlyPayrollService,
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

        $this->monthlyPayrollService->updateEmployeesData($payrollMaster,$payMasterEmployeeSlug);

        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $totalRata = $payrollMasterEmployee?->employee?->payrollSettings?->ra_rate + $payrollMasterEmployee?->employee?->payrollSettings?->ta_rate;
            $factor = $this->getFactor($payrollMasterEmployee->rata_actual_days_worked);
            $modifiedRata = $totalRata * $factor;
            $deductions = $totalRata - $modifiedRata;
            $upsert[] = [
                'saved_employee_data' => json_encode($payrollMasterEmployee->saved_employee_data),
                'slug' => $payrollMasterEmployee->slug,
                'rata_ra_rate' => $payrollMasterEmployee?->employee?->payrollSettings?->ra_rate,
                'rata_ta_rate' => $payrollMasterEmployee?->employee?->payrollSettings?->ta_rate,
                'rata_actual_days_worked' => $payrollMasterEmployee->rata_actual_days_worked ?? 22,
                'rata_deductions' => $deductions,
                'rata_net_amount' => $modifiedRata,
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
                'rata_deductions',
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
        if($request->has('updateRataDays') && $request->updateRataDays == true){
            $employeeFromList = PayrollMasterEmployees::query()->findOrFail($request->employeeListSlug);
            $employeeFromList->rata_actual_days_worked = $request->rata_actual_days_worked;
            if($employeeFromList->save()){
                return $this->recompute($payrollMaster->slug,$request->employeeListSlug);
            }
        }
    }


}