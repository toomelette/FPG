<?php

namespace App\Swep\Services\HRU;

use App\Http\Requests\Hru\PayrollUpdateFormRequest;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\PayrollTree;
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class DiffMonetizationService
{
    private $factor;
    public function __construct(

    )
    {
        $this->factor =  0.0481927;
    }

    public function edit($payrollMaster,$slug,$request)
    {
        if($request->has('employee')){
            return  $this->showEmployee($slug,$request);
        }
        if($request->has('recompute') && $request->recompute == true){
            return $this->recompute($slug);
        }
        if($request->has('fetchMbs')){
            return $this->fetchMbs($payrollMaster,$request);
        }

        return view('_payroll.payroll-preparation.DIFF-MON.edit')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    private function fetchMbs(PayrollMaster $payrollMaster,$request){
        $payrollMaster->load('payrollMasterEmployees');
        $employeeNos = $payrollMaster->payrollMasterEmployees->pluck('saved_employee_data.employee_no');
        $tempSsl = DB::table('temp_new_salary')->get();

        $salaries = [];
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $salaries[$payrollMasterEmployee->slug] =  ( $tempSsl->where('emp_no',$payrollMasterEmployee->saved_employee_data['employee_no'])->first()?->{$request->type.'_mbs'} * 1 ) ?? null ;
        }
        return $salaries;
    }

    public function update(PayrollUpdateFormRequest $request,PayrollMaster $payrollMaster)
    {

        if ($payrollMaster->is_locked) {
            abort(503, 'This Payroll is locked. Unlock it first to perform action.');
        }
        if($request->has('clone')){
            if($request->type == 'clone'){
                return  $this->clone($request,$payrollMaster);
            }
            if($request->type == 'delete'){
                return  $this->deleteEmployee($request,$payrollMaster);
            }
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
        return $this->recompute($payrollMaster->slug);
    }

    public function deleteEmployee(\Illuminate\Http\Request $request, $payrollMaster)
    {
        $pme = $payrollMaster->payrollMasterEmployees()->firstWhere('slug',$request->data);
        if($pme->delete()){
            $pme->employeePayrollDetails()->delete();
            return $pme->slug;
        }
        abort(503,'Error deleting item.');
    }
    private function recompute($payrollMasterSlug,$payMasterEmployeeSlug = null,$avoid = [])
    {
        $request = Request::capture();

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

        $incentiveToInsert = 'DIFFLMON';
        $incentiveArray = [];
        $incentiveFromDb = Incentives::query()->where('incentive_code','=',$incentiveToInsert)->first();

        $upsert = [];
        $hasBeenChanged = [];
        $deductions = [];
        if(count($request['data']) > 0){
            foreach ($request['data'] as $slug => $datum) {
                if($datum['has_been_changed'] == 1){
                    $hasBeenChanged[] = $slug;
                }
                $oldMbs = Helper::sanitizeAutonum($datum['diff_old_monthly_basic']) * 1;
                $newMbs = Helper::sanitizeAutonum($datum['diff_new_monthly_basic']) * 1;
                $diffGross =  $newMbs - $oldMbs ;
                $diffMonNet = $diffGross * $this->factor * floatval($datum['diff_days']);

                //to employee list
                $upsert[] = [
                    'slug' => $slug,
                    'diff_old_monthly_basic' => $oldMbs,
                    'diff_new_monthly_basic' => $newMbs,
                    'diff_gross' => $diffGross,
                    'diff_days' => $datum['diff_days'],
                    'pay15' => $diffMonNet,
                ];
                //incentives
                $deductions[] = [
                    'pay_master_employee_listing_slug' => $slug,
                    'slug' => Str::random(),
                    'type' => 'INCENTIVE',
                    'code' => $incentiveFromDb?->incentive_code,
                    'amount' => $diffMonNet,
                    'original_amount' => $diffMonNet,
                    'priority' => $incentiveFromDb?->priority,
                    'account_code' => $incentiveFromDb?->account_code,
                ];

                //deductions
                //TAX
                /*
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
                */

            }

        }

        $emp = PayrollMasterEmployees::query()->upsert(
            $upsert,
            ['slug'],
            [
                'diff_old_monthly_basic',
                'diff_new_monthly_basic',
                'diff_gross',
                'diff_days',
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
                ]
            );

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
            $views[$payrollMasterEmployee->slug] = view('_payroll.payroll-preparation.DIFF-MON.preview-row')->with([
                'payrollMaster' => $payrollMaster,
                'employee' => $payrollMasterEmployee,
                'deductions' => $deductions,
                'incentives' => $incentives,
            ])->render();
        }
        return $views;
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


        return Pdf::view('printables.hru.payroll_preparation.DIFF-MON.payroll',[
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
        ]);
        */

    }
}