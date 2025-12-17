<?php

namespace App\Swep\Services\HRU;

use App\Models\Employee;
use App\Models\HRU\Deductions;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\PayrollTree;
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class DifferentialService
{

    public function __construct(
        protected PayrollService $payrollService
    )
    {

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
            $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
            return [
                'slug' => $clonePME->slug,
                'employee_slug' => $clonePME->employee_slug,
                'view' => view('_payroll.payroll-preparation.DIFF.preview-row')->with([
                    'payrollMaster' => $payrollMaster,
                    'employee' => $clonePME,
                    'deductions' => $deductions,
                    'incentives' => $incentives,
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


        $upsert = [];
        $deductions = [];
        $deductionsFromDb = Deductions::query()
            ->get();
        $incentivesFromDb = Incentives::query()
            ->where('incentive_code','=','DIFFL')
            ->first();

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
                $salaryDifference = $newMbs - $oldMbs;
                $diffGross = ($salaryDifference) * $workingDaysCoveredInDiff / $workingDaysInAMonth;
                $gsisPs = $salaryDifference  / $daysInAMonth * $daysCoveredInDiff * 0.09;
                $gsisGs = $salaryDifference  / $daysInAMonth * $daysCoveredInDiff * 0.12;
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
//                    'diff_gross' => $diffGross,
                    'pay15' => $diffNet,
                ];

                //incentives
                $deductions[] = [
                    'pay_master_employee_listing_slug' => $slug,
                    'slug' => Str::random(),
                    'type' => 'INCENTIVE',
                    'code' => $incentivesFromDb?->incentive_code,
                    'amount' => $diffGross,
                    'original_amount' => $diffGross,
                    'priority' => $incentivesFromDb?->priority,
                    'account_code' => $incentivesFromDb?->account_code,
                    'govt_share' => null,
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
//                'diff_gross',
                'pay15',
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

        //compute deductions
        //refresh again
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($hasBeenChanged) {
                if(count($hasBeenChanged) > 0){
                    $e->whereIn('slug',$hasBeenChanged);
                }
            },
            'payrollMasterEmployees.employeePayrollDetails',
        ]);
        $upsert = [];
        $updatedDeductions = [];
        $statutoryDeductions = ['WTAX','GSIS'];

        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $totalIncentives = $payrollMasterEmployee->employeePayrollDetails
                ->where('type','INCENTIVE')
                ->sum('amount');
            $totalStatutoryDeductions = $payrollMasterEmployee->employeePayrollDetails
                ->where('type','DEDUCTION')
                ->whereIn('code',$statutoryDeductions)
                ->sum('amount');
            $netAfterStatutory = $totalIncentives - $totalStatutoryDeductions;

            $toDeduct = $payrollMasterEmployee->employeePayrollDetails
                ->where('type','DEDUCTION')
                ->whereNotIn('code',$statutoryDeductions);

            if($toDeduct->count() > 0){
                $continue = true;
                foreach ($toDeduct as $deduct) {

                    if($continue){
                        $netAfterStatutory = $netAfterStatutory - $deduct->original_amount;
                        if($netAfterStatutory > 0){
                            $newDeductionAmount = $deduct->original_amount;
                        }else{
                            $newDeductionAmount = $deduct->original_amount + $netAfterStatutory;
                            $continue = false;
                        }

                        $updatedDeductions[] = [
                            'pay_master_employee_listing_slug' => $deduct->pay_master_employee_listing_slug,
                            'type' => $deduct->type,
                            'code' => $deduct->code,
                            'priority' => $deductionsFromDb->where('deduction_code',$deduct->code)?->first()?->n_priority,
                            'amount' => $newDeductionAmount,
                        ];
                    }

                }
            }


        }

        PayrollMasterDetails::query()
            ->upsert(
                $updatedDeductions,
                ['pay_master_employee_listing_slug','type','code'],
                [
                    'priority',
                    'amount',
                ]
            );

        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($hasBeenChanged) {
                if(count($hasBeenChanged) > 0){
                    $e->whereIn('slug',$hasBeenChanged);
                }
            },
            'payrollMasterEmployees.employeePayrollDetails',
        ]);


        $upsert = [];
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){

            $totalIncentives = $payrollMasterEmployee->employeePayrollDetails
                ->where('type' , 'INCENTIVE')
                ->sum('amount');
            $totalDeductions = $payrollMasterEmployee->employeePayrollDetails
                ->where('type' , 'DEDUCTION')
                ->sum('amount');
            $upsert[] = [
                'slug' => $payrollMasterEmployee->slug,
                'pay15' => $totalIncentives - $totalDeductions,
            ];

        }


        PayrollMasterEmployees::query()->upsert(
            $upsert,
            ['slug'],
            [
                'pay15',
            ]);

        //refresh again
        $payrollMaster->refresh()->load([
            'payrollMasterEmployees' => function ($e) use ($hasBeenChanged) {
                if(count($hasBeenChanged) > 0){
                    $e->whereIn('slug',$hasBeenChanged);
                }
            },
            'payrollMasterEmployees.employee.templateIncentives',
            'payrollMasterEmployees.employeePayrollDetails',
            'hmtDetails',
        ]);
        $views = [];
        $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
        $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $views[$payrollMasterEmployee->slug] = view('_payroll.payroll-preparation.DIFF.preview-row')->with([
                'payrollMaster' => $payrollMaster,
                'employee' => $payrollMasterEmployee,
                'deductions' => $deductions,
                'incentives' => $incentives,
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
                        })
                        ->orderBy('saved_employee_data->full_name');
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



        return Pdf::view('printables.hru.payroll_preparation.DIFF.payroll',[
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
        return view('printables.hru.payroll_preparation.DIFF.payroll')->with([
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
}