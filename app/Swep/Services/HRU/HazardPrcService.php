<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterEmployees;
use Illuminate\Http\Request;

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
}