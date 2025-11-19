<?php

namespace App\Swep\Services\HRU;

use App\Models\Employee;
use App\Models\HRU\Deductions;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DifferentialService
{
    public function recompute($payrollMasterSlug,$payMasterEmployeeSlug = null,$avoid = [])
    {
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


        dd($payrollMaster);
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

    public function clone(Request $request,$payrollMaster)
    {
        $clonePME = $payrollMaster->payrollMasterEmployees
            ->firstWhere('slug',$request->data)
            ->replicate([
                'diff_old_monthly_basic',
                'diff_new_monthly_basic',
                'diff_from',
                'diff_to',
                'diff_days',
                'diff_gross',
                'diff_net',
                'diff_other',
            ]);
        $clonePME->id = null;
        $clonePME->slug = Str::random();
        if($clonePME->save()){
            $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
            return [
                'slug' => $clonePME->slug,
                'employee_slug' => $clonePME->employee_slug,
                'view' => view('_payroll.payroll-preparation.DIFF.preview-row')->with([
                    'payrollMaster' => $payrollMaster,
                    'employee' => $clonePME,
                    'deductions' => $deductions,
                ])->render(),
            ];
        }
    }

    public function deleteEmployee(Request $request,$payrollMaster)
    {
        $pme = $payrollMaster->payrollMasterEmployees()->firstWhere('slug',$request->data);
        if($pme->delete()){
            $pme->employeePayrollDetails()->delete();
            return $pme->slug;
        }
        abort(503,'Error deleting item.');
    }

    public function update(Request $request,$payrollMaster)
    {


        if($request->has('clone')){
            if($request->type == 'clone'){
                return  $this->clone($request,$payrollMaster);
            }
            if($request->type == 'delete'){
                return  $this->deleteEmployee($request,$payrollMaster);
            }
        }

        $upsert = [];
        $deductions = [];
        $deductionsFromDb = Deductions::query()
            ->whereIn('deduction_code',['WTAX','GSIS'])
            ->get();
        $usedEmployees = 1;
        $hasBeenChanged = [];

        if(count($request['data']) > 0){
            foreach ($request['data'] as $slug => $datum) {
                if($datum['has_been_changed'] == 1){
                    $hasBeenChanged[] = $slug;
                }
                $daysInAMonth = Carbon::parse($payrollMaster->date)->daysInMonth;
                $workingDaysInAMonth = 22;
                $workingDaysCoveredInDiff = $datum['diff_days'];
                $daysCoveredInDiff = Carbon::parse($datum['diff_from'])->diffInDays(Carbon::parse($datum['diff_to'])) + 1;
                $oldMbs = Helper::sanitizeAutonum($datum['diff_old_monthly_basic']) * 1;
                $newMbs = Helper::sanitizeAutonum($datum['diff_new_monthly_basic']) * 1;
                $diffGross = ($newMbs - $oldMbs) * $workingDaysCoveredInDiff / $workingDaysInAMonth;
                $gsisPs = $diffGross  / $daysInAMonth * $daysCoveredInDiff * 0.09;
                $gsisGs = $diffGross  / $daysInAMonth * $daysCoveredInDiff * 0.12;
                $tax = ( $diffGross - $gsisPs) * Helper::taxRate($oldMbs);
                $diffNet = $diffGross - $gsisPs - $tax;



                //to employee list
                $upsert[] = [
                    'slug' => $slug,
                    'diff_old_monthly_basic' => $oldMbs,
                    'diff_new_monthly_basic' => $newMbs,
                    'diff_from' => $datum['diff_from'],
                    'diff_to' => $datum['diff_to'],
                    'diff_days' => $datum['diff_days'],
                    'diff_gross' => $diffGross,
                    'diff_net' => $diffNet,
                ];

                //deductions
                //TAX
                $deductions[] = [
                    'pay_master_employee_listing_slug' => $slug,
                    'slug' => Str::random(),
                    'type' => 'DEDUCTION',
                    'code' => 'WTAX',
                    'amount' => $tax,
                    'original_amount' => $tax,
                    'priority' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->n_priority,
                    'account_code' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->account_code,
                    'govt_share' => null,
                ];
                //GSIS
                $deductions[] = [
                    'pay_master_employee_listing_slug' => $slug,
                    'slug' => Str::random(),
                    'type' => 'DEDUCTION',
                    'code' => 'GSIS',
                    'amount' => $gsisPs,
                    'original_amount' => $gsisPs,
                    'priority' => $deductionsFromDb->where('deduction_code','GSIS')?->first()?->n_priority,
                    'account_code' => $deductionsFromDb->where('deduction_code','GSIS')?->first()?->account_code,
                    'govt_share' => $gsisGs,
                ];
            }

        }


        $emp = PayrollMasterEmployees::query()->upsert(
            $upsert,
            ['slug'],
            [
                'diff_old_monthly_basic',
                'diff_new_monthly_basic',
                'diff_from',
                'diff_to',
                'diff_days',
                'diff_gross',
                'diff_net',
            ]);


        PayrollMasterDetails::query()
            ->upsert(
                $deductions,
                ['pay_master_employee_listing_slug','type','code'],
                [
                    'slug',
                    'type',
                    'code',
                    'amount',
                    'original_amount',
                    'priority',
                    'account_code',
                    'govt_share',
                ]
            );


        //refresh again
        $payMasterEmployeeSlug = null;
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($hasBeenChanged) {
                if(count($hasBeenChanged) > 0){
                    $e->whereIn('slug',$hasBeenChanged);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
        ]);
        $views = [];
        $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();

        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $views[$payrollMasterEmployee->slug] = view('_payroll.payroll-preparation.DIFF.preview-row')->with([
                'payrollMaster' => $payrollMaster,
                'employee' => $payrollMasterEmployee,
                'deductions' => $deductions,
            ])->render();
        }
        return $views;
    }

    public function fetchMbs($payrollMaster)
    {
        $employees = $payrollMaster->payrollMasterEmployees->pluck('employee_slug');
        $employeesWithOldMbs = [];
        $employeesFromDb = Employee::query()
            ->with([
                'employeeServiceRecord' => function ($sr) {
                    $sr->orderBy('sequence_no','desc');
                }
            ])
            ->whereIn('slug',$employees)
            ->get();

        foreach ($employeesFromDb as $employeeFromDb){

            if(request('type') == 'old' ){
                $sr = $employeeFromDb->employeeServiceRecord?->skip(1)?->first();
            }
            if(request('type') == 'new'){
                $sr = $employeeFromDb->employeeServiceRecord?->first();
            }
            $amount = Helper::sanitizeAutonum($sr?->monthly_basic ?? null);
            $employeesWithOldMbs[$employeeFromDb->slug] = $amount == null ? null : $amount * 1;
        }
        return $employeesWithOldMbs;
    }
}