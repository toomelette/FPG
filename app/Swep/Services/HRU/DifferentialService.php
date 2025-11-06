<?php

namespace App\Swep\Services\HRU;

use Illuminate\Support\Str;

class DifferentialService
{
    public function recompute($payrollMasterSlug,$payMasterEmployeeSlug = null,$avoid = [])
    {
        dd(1);
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
                'payrollMasterEmployees.employee.templateIncentives',
                'payrollMasterEmployees.employeePayrollDetails',
            ])
            ->find($payrollMasterSlug);
        if($payrollMaster->is_locked ){
            abort(503,'This Payroll is locked. Unlock it first to perform action.');
        }

        //$this->payrollService->updateEmployeesData($payrollMaster,$payMasterEmployeeSlug);

        //Insert incentives to payroll master details:
        $incentivesToInsert = ['YEB','CASHGIFT'];
        $incentiveArray = [];
        $incentivesFromDb = Incentives::query()->whereIn('incentive_code',$incentivesToInsert)->get();


        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){

            foreach ($incentivesToInsert as $incentiveToInsert){

                $incentiveArray[] = [
                    'employee_slug' => $payrollMasterEmployee->employee->slug,
                    'pay_master_employee_listing_slug' => $payrollMasterEmployee->slug,
                    'slug' => Str::random(),
                    'type' => 'INCENTIVE',
                    'code' => $incentiveToInsert,
                    'amount' => $payrollMasterEmployee->employee?->templateIncentives?->where('incentive_code',$incentiveToInsert)?->first()?->amount,
//                    'amount' => $payrollMasterEmployee->saved_employee_data["monthly_basic"] ?? null,
                    'account_code' => $incentivesFromDb->where('incentive_code',$incentiveToInsert)?->first()?->account_code,
                    'priority' => $incentivesFromDb->where('incentive_code',$incentiveToInsert)?->first()?->priority,
                    'taxable' => $incentivesFromDb->where('incentive_code',$incentiveToInsert)?->first()?->taxable,
                ];
            }
        }

        PayrollMasterDetails::query()
            ->upsert(
                $incentiveArray,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','account_code','priority','taxable']
            );

        //refresh
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                if($payMasterEmployeeSlug != null){
                    $e->where('slug','=',$payMasterEmployeeSlug);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
        ]);

        //Compute tax:
        $deductionsFromDb = Deductions::query()->get();
        $taxDeductionToInsert = [];
        $payrollMasterMyb = PayrollMaster::query()
            ->with([
                'hmtDetails' => function ($hmtDetails) {
                    $hmtDetails->where('code','=','MYB');
                }
            ])
            ->where('type','=',"MYB")
            ->first();
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $mybAmount = $payrollMasterMyb?->hmtDetails?->where('employee_slug','=',$payrollMasterEmployee->employee_slug)?->first()?->amount ?? 0;
            $taxableAmount = $payrollMasterEmployee->employeePayrollDetails->where('type','INCENTIVE')->where('taxable','=',1)->sum('amount');
            //$mybAmount = $payrollMasterEmployee->employee?->templateIncentives?->where('incentive_code',$incentiveToInsert)?->first()?->amount;
            $taxable = $taxableAmount + $mybAmount - $this->maxNonTax;

            $taxRate = Helper::taxRate($payrollMasterEmployee->employee->monthly_basic);
            $computedTax = $taxable * $taxRate / 2;
            if($computedTax <= 0){
                $computedTax = null;
            }

            $taxDeductionToInsert[] = [
                'employee_slug' => $payrollMasterEmployee->employee->slug,
                'pay_master_employee_listing_slug' => $payrollMasterEmployee->slug,
                'slug' => Str::random(),
                'type' => 'DEDUCTION',
                'code' => 'WTAX',
                'amount' => $computedTax,
                'original_amount' => $computedTax,
                'priority' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->n_priority,
                'account_code' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->account_code,
            ];

        }

        PayrollMasterDetails::query()
            ->upsert(
                $taxDeductionToInsert,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','original_amount','priority','account_code']
            );

        //refresh again
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                if($payMasterEmployeeSlug != null){
                    $e->where('slug','=',$payMasterEmployeeSlug);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
        ]);

        //Recompute deductions and edit some to make net not lower than 0.00:
        $newDeductionArr = [];
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $continue = true;
            $deductions = $payrollMasterEmployee->employeePayrollDetails->where('type','DEDUCTION')->sortBy('priority');
            $incentives = $payrollMasterEmployee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount');
            $netAmount = $incentives;
            foreach ($deductions as $deduction){
                $newDeduction = $deduction->original_amount;
                if($continue){
                    $netAmount = $netAmount - $deduction->original_amount;
                    if($netAmount < 0){
                        $continue = false;
                        $newDeduction = $deduction->original_amount + $netAmount;
                    }
                }else{
                    $newDeduction = null;
                }
                $newDeductionArr[] = [
                    'employee_slug' => $deduction->employee_slug,
                    'pay_master_employee_listing_slug' => $deduction->pay_master_employee_listing_slug,
                    'slug' => $deduction->slug,
                    'type' => $deduction->type,
                    'code' => $deduction->code,
                    'amount' => $newDeduction,
                    'priority' => $deduction->priority,
                ];
            }
        }

        PayrollMasterDetails::query()
            ->upsert(
                $newDeductionArr,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','priority']
            );


        //refresh again
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                if($payMasterEmployeeSlug != null){
                    $e->where('slug','=',$payMasterEmployeeSlug);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
        ]);


        //Total Net amount to be received:
        $upsertValues = [];
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $totalIncentives = $payrollMasterEmployee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount');
            $totalDeductions = $payrollMasterEmployee->employeePayrollDetails->where('type','DEDUCTION')->sum('amount');
            $upsertValues[] = [
                'slug' => $payrollMasterEmployee->slug,
                'pay15' => $totalIncentives - $totalDeductions,
            ];
        }



        PayrollMasterEmployees::query()->upsert($upsertValues,
            ['slug'],
            ['pay15']
        );

        //refresh again
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                if($payMasterEmployeeSlug != null){
                    $e->where('slug','=',$payMasterEmployeeSlug);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
        ]);

        if($payMasterEmployeeSlug != null){
            $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
            $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();

            return view('_payroll.payroll-preparation.YEB.preview-row')->with([
                'employee' => $payrollMaster->payrollMasterEmployees->first(),
                'deductions' => $deductions,
                'incentives' => $incentives,
            ]);
        }

        return view('_payroll.payroll-preparation.YEB.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }
}