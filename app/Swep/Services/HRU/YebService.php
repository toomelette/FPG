<?php

namespace App\Swep\Services\HRU;

use App\Http\Requests\Hru\PayrollUpdateFormRequest;
use App\Models\HRU\Deductions;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\PayrollTree;
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class YebService
{
    protected $maxNonTax;
    public function __construct(
        protected PayrollService $payrollService
    )
    {
        $this->maxNonTax = 90000;
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

    public function printPayroll($payrollMasterSlug)
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
                'payrollMasterEmployees.employee.plantilla',
                'payrollMasterEmployees.employeePayrollDetails',
                'hmtDetails' => function ($hmtDetails) use($request){
                    //Payroll Groups
                    if($request->has('payrollGroupsSelected') && count($request->payrollGroupsSelected) > 0){
                        $hmtDetails->intermediateGroup($request->payrollGroupsSelected);
                    }

                },
                'hmtDetails.chartOfAccount',
            ])
            ->findOrFail($payrollMasterSlug);
        if($payrollMaster->payrollMasterEmployees->count() < 1){
            abort(504,'No employee found under the payroll group you have selected.');
        }
        $usedRc = [];
        $employees = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->slug => $data,
            ];
        });
        $rcsGroupedByRcCode = PPURespCodes::query()->get()->mapWithKeys(function ($data){return [$data->rc_code => $data];});
        foreach ($employees as $employee){
            $respCenter = $employee->saved_employee_data['resp_center'];
            $usedRc[$rcsGroupedByRcCode[$respCenter]->rc.$rcsGroupedByRcCode[$respCenter]->div.$rcsGroupedByRcCode[$respCenter]->sec] = $rcsGroupedByRcCode[$respCenter]->rc.$rcsGroupedByRcCode[$respCenter]->div.$rcsGroupedByRcCode[$respCenter]->sec;
            $usedRc[$rcsGroupedByRcCode[$respCenter]->rc.$rcsGroupedByRcCode[$respCenter]->div.'0'] = $rcsGroupedByRcCode[$respCenter]->rc.$rcsGroupedByRcCode[$respCenter]->div.'0';
            $usedRc[$rcsGroupedByRcCode[$respCenter]->rc.'0'.'0'] = $rcsGroupedByRcCode[$respCenter]->rc.'0'.'0';
        }

        $tree = PayrollTree::query()
            ->with('responsibilityCenter')
            ->whereIn('resp_center',array_flatten($usedRc))
            ->orderBy('sort','asc')
            ->get()
            ->groupBy(['group','resp_center']);

        $t = $payrollMaster->payrollMasterEmployees->groupBy(function ($data){
            return $data->employee->resp_center;
        })->toArray();
        ksort($t);
        $t = array_keys($t);
        $dbRcs = collect($tree)->flatten()->mapWithKeys(function ($data){
            return [
                $data->resp_center => $data,
            ];
        })->toArray();
        ksort($dbRcs);
        $dbRcs = array_keys($dbRcs);
        $diff = array_diff($t,$dbRcs);
        if(count($diff) > 0){
            abort(503,'There are some RCs not found on the hierarchy of RCs. Contact database administrator. ---------------------------- '.print_r($diff,true));
        }
        ksort($usedRc);



        return Pdf::view('printables.hru.payroll_preparation.YEB.payroll',[
                'pdfPrint' => true,
                'payrollMaster' => $payrollMaster,
                'tree' => $tree,
                'payrollEmployeesGroupedByRespCenter' => $payrollMaster->payrollMasterEmployees->groupBy(function ($data){
                    return $data->employee->resp_center;
                }),
                'payrollEmployeesBySlug' => $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
                    return [
                        $data->employee->slug => $data,
                    ];
                }),
                'usedRc' => $usedRc,
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

        /*
        return view('printables.hru.payroll_preparation.YEB.payroll')->with([
            'payrollMaster' => $payrollMaster,
            'tree' => $tree,
            'payrollEmployeesGroupedByRespCenter' => $payrollMaster->payrollMasterEmployees->groupBy(function ($data){
                return $data->employee->resp_center;
            }),
            'payrollEmployeesBySlug' => $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
                return [
                    $data->employee->slug => $data,
                ];
            }),
            'usedRc' => $usedRc,
        ]);
        */

    }
    public function deductionRegister($payrollMasterSlug)
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
                'payrollMasterEmployees.employeePayrollDetails',
                'hmtDetails' => function ($hmtDetails) use($request){
                    if($request->has('payrollGroupsSelected') && $request->payrollGroupsSelected != ''){
                        $hmtDetails->intermediateGroup($request->payrollGroupsSelected);
                    }
                },
                'hmtDetails.chartOfAccount',
                'hmtDetails.deduction',
                'hmtDetails.employeePayroll'
            ])
            ->findOrFail($payrollMasterSlug);



        return Pdf::view('printables.hru.payroll_preparation.YEB.deduction-register',[
            'payrollMaster' => $payrollMaster,
            'pdfPrint' => true,
        ])
            ->format('a4')
            ->margins(8,8, 15, 8)
            ->headers(['title' => 'aaaaa'])
            ->footerView('printables.hru.payroll_preparation.footer-view')
            ->name('Deduction Register.pdf')
            ->withBrowsershot(function (Browsershot $browsershot){
                if(app()->environment('production')){
                    $browsershot->setNodeBinary(env('NODE_BINARY'))
                        ->setNpmBinary(env('NODE_BINARY'));
                }
            });

        return view('printables.hru.payroll_preparation.YEB.deduction-register')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function abstract($payrollMasterSlug)
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
                'payrollMasterEmployees.employeePayrollDetails',
                'hmtDetails' => function ($hmtDetails) use($request){
                    if($request->has('payrollGroupsSelected') && $request->payrollGroupsSelected != ''){
                        $hmtDetails->intermediateGroup($request->payrollGroupsSelected);
                    }

                },
                'hmtDetails.chartOfAccount',
            ])
            ->findOrFail($payrollMasterSlug);

        $rataPayrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees',
            ])
            ->where('type','=','RATA')
            ->where('date','=', $payrollMaster->date)
            ->first();

        $employeesWithRata = $rataPayrollMaster?->payrollMasterEmployees->mapWithKeys(function ($data){
            return[
                $data->employee_slug => $data,
            ];
        });

        return view('printables.hru.payroll_preparation.GLOBAL.abstract')->with([
            'payrollMaster' => $payrollMaster,
            'employeesWithRata' => $employeesWithRata,
        ]);
    }
}