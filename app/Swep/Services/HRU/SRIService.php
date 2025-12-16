<?php

namespace App\Swep\Services\HRU;

use App\Http\Requests\Hru\PayrollUpdateFormRequest;
use App\Models\HRU\Deductions;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SRIService
{
    public function __construct(
        private PayrollService $payrollService,
    )
    {
    }

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

        //$this->payrollService->updateEmployeesData($payrollMaster,$payMasterEmployeeSlug);

        //Insert incentives to payroll master details:
        $incentivesToInsert = ['SRI'];
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
        $taxFree90kCodes = Arrays::taxFree90k();
        $taxFree90kCodes[] = 'WTAX';
        $taxCode = ['WTAX'];

        //Compute tax:
        $deductionsFromDb = Deductions::query()->get();
        $taxDeductionToInsert = [];

        $details90k = PayrollMasterDetails::query()
            ->with(['employeePayroll.payrollMaster'])
            ->whereHas('employeePayroll.payrollMaster',function ($payrollMaster) use ($taxFree90kCodes){
                $payrollMaster->whereIn('type',$taxFree90kCodes);
            })
            ->whereIn('code',$taxFree90kCodes)
            ->get();

        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){

            $hasBeedEdited = $payrollMasterEmployee->has_been_edited;

            $computeTax = true;
            if($hasBeedEdited != null){
                if(array_search('WTAX',$hasBeedEdited) !== false){
                    $computeTax = false;
                }
            }

            if($computeTax ) {
                $totalIncentives = $details90k->where('employeePayroll.employee_slug',$payrollMasterEmployee->employee_slug)
                    ->where('type','INCENTIVE')
                    ->whereNotIn('employeePayroll.payrollMaster.type',$incentivesToInsert)
                    ->sum('amount');
                $totalDeductions = $details90k->where('employeePayroll.employee_slug',$payrollMasterEmployee->employee_slug)
                    ->where('type','DEDUCTION')
                    ->whereNotIn('employeePayroll.payrollMaster.type',$incentivesToInsert)
                    ->sum('amount');

                $totalCompensation = $totalIncentives - $totalDeductions;
                if($totalCompensation < 90000){
                    $remainingNonTax = 90000 - $totalCompensation ;
                }else{
                    $remainingNonTax = 0;
                }

                $taxableAmount = $payrollMasterEmployee->employeePayrollDetails->where('type','INCENTIVE')->where('taxable','=',1)->sum('amount') - $remainingNonTax;

                $taxRate = Helper::taxRate($payrollMasterEmployee->employee->monthly_basic);
                $tax = $taxableAmount * $taxRate;
                $taxDeductionToInsert[] = [
                    'employee_slug' => $payrollMasterEmployee->employee->slug,
                    'pay_master_employee_listing_slug' => $payrollMasterEmployee->slug,
                    'slug' => Str::random(),
                    'type' => 'DEDUCTION',
                    'code' => 'WTAX',
                    'amount' => $tax,
                    'original_amount' => $tax,
                    'priority' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->n_priority,
                    'account_code' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->account_code,
                ];
            }
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

            return view('_payroll.payroll-preparation.CNA.preview-row')->with([
                'employee' => $payrollMaster->payrollMasterEmployees->first(),
                'deductions' => $deductions,
                'incentives' => $incentives,
            ]);
        }
        return view('_payroll.payroll-preparation.SRI.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);

    }

    public function update(PayrollUpdateFormRequest $request,PayrollMaster $payrollMaster)
    {

        if ($payrollMaster->is_locked) {
            abort(503, 'This Payroll is locked. Unlock it first to perform action.');
        }

        //IF UPDATE DEDUCTION
        if ($request->has('updateDeduction')) {
            return $this->updateDeduction($request);
        }
        if($request->has('removeColumn')){
            return $this->payrollService->removeColumn($request,$payrollMaster);
        }
        //IF IMPORT EXCEL
        if ($request->has('import') && $request->import == true) {

            $payrollMaster = $payrollMaster->load(['payrollMasterEmployees.employee']);
            switch ($request->type) {
                case 'SURECCO' :
                case 'SUDEMUPCO' :
                case 'SUGAREAP' :
                case 'ACCTREC' :
                case 'AR' :
                    return $this->payrollService->excelUpload($payrollMaster, $request);
            }
        }
    }

    public function updateDeduction(Request $request)
    {
        if($request->type == 'INCENTIVE'){
            $incentiveMaster = Incentives::query()->where('incentive_code','=',$request->code)->first();
            $priority = $incentiveMaster->priority;
        }else{
            $deductionMaster = Deductions::query()->where('deduction_code','=',$request->code)->first();
            $priority = $deductionMaster->n_priority;
        }

        $deductionMaster = Deductions::query()->where('deduction_code','=',$request->code)->first();

        $toUpsert[] = [
            'pay_master_employee_listing_slug' => $request->pay_master_employee_listing_slug,
            'employee_slug' => $request->employee_slug,
            'slug' => Str::random(),
            'type' => $request->type,
            'code' => $request->code,
            'amount' => Helper::sanitizeAutonum($request->amount),
            'original_amount' => Helper::sanitizeAutonum($request->amount),
            'priority' => $priority,
        ];
        PayrollMasterDetails::query()
            ->upsert(
                $toUpsert,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','original_amount']
            );
        $payMasterEmployee = PayrollMasterEmployees::query()->find($request->pay_master_employee_listing_slug);
        $payMasterSlug = $payMasterEmployee->pay_master_slug;


        $hasBeenEdited = $payMasterEmployee->has_been_edited ?? [];
        if(array_search($request->code,$hasBeenEdited) === false){
            $hasBeenEdited[] = $request->code;
            $payMasterEmployee->has_been_edited = $hasBeenEdited;
            $payMasterEmployee->save();
        }
        return $this->recompute($payMasterSlug,$payMasterEmployee->slug);

    }
}