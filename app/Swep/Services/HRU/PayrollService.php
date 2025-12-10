<?php

namespace App\Swep\Services\HRU;

use App\Imports\GSISImport;
use App\Models\HRU\Deductions;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\PayrollTree;
use App\Models\HRU\TemplateDeductions;
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class PayrollService
{
    public function updateEmployeesData(PayrollMaster $payrollMaster,$payMasterEmployeeSlug)
    {
        $payrollMaster = $payrollMaster->load([
            'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                if($payMasterEmployeeSlug != null){
                    $e->where('slug','=',$payMasterEmployeeSlug);
                }
            },
            'payrollMasterEmployees.employee' =>[
                'plantilla',
                'responsibilityCenter.description',
            ]
        ]);


        $jobGrades = Arrays::jobGrades();
        $upsert = [];
        foreach ($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee){
            $payrollMasterEmployee->saved_employee_data = [
                'employee_no' => $payrollMasterEmployee->employee->employee_no,
                'full_name' => $payrollMasterEmployee->employee->full['LFEMi'] ?? '',
                'lastname' => $payrollMasterEmployee->employee->lastname,
                'firstname' => $payrollMasterEmployee->employee->firstname,
                'middlename' => $payrollMasterEmployee->employee->middlename,
                'name_ext' => $payrollMasterEmployee->employee->name_ext,
                'position' => $payrollMasterEmployee->employee->plantilla->position ?? $payrollMasterEmployee->employee->position,
                'item_no' => $payrollMasterEmployee->employee->item_no,
                'salary_grade' => $payrollMasterEmployee->employee->salary_grade,
                'step_inc' => $payrollMasterEmployee->employee->step_inc,
//                'monthly_basic' => $jobGrades[$payrollMasterEmployee->employee->salary_grade][$payrollMasterEmployee->employee->step_inc] ?? null,
                'monthly_basic' => $payrollMasterEmployee->employee->monthly_basic,
                'resp_center' => $payrollMasterEmployee->employee->resp_center,
                'department' => $payrollMasterEmployee->employee->responsibilityCenter->description->name ?? '',
            ];
            $upsert[] = [
                'saved_employee_data' => json_encode($payrollMasterEmployee->saved_employee_data),
                'slug' => $payrollMasterEmployee->slug
            ];

        }

        PayrollMasterEmployees::query()->upsert($upsert,['slug'],['saved_employee_data']);
        return true;
    }

    public function excelUpload(PayrollMaster $payrollMaster,Request $request)
    {

        $excel = Excel::toArray(new GSISImport(),$request->file('file'));
        $data = $excel[0];

        $headers = $data[0];
        //remove null values
        $headers = array_filter($headers,function ($value){ return !is_null($value) && $value != ''; });

        $headersFlipped = collect($headers)->flip();

        array_forget($data,0);

        $rowsExceptHeaders = $data;
        $deductionsToBeInserted = [];
        $deductions = Arrays::deductionsExcelHeader($request->type);

        $employeesExcelToSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->employee_no => $data->employee->slug,
            ];
        });

        $upsertValues = [];
        foreach ($data as $row){
            foreach ($deductions as $excelHeader => $deduction){
                if(isset($headersFlipped[$excelHeader]) && isset($employeesExcelToSlug[$row[0]]) && isset($row[$headersFlipped[$excelHeader]]) && $row[$headersFlipped[$excelHeader]] != 0){
                    if($payrollMaster->payrollMasterEmployees->where('employee_slug',$employeesExcelToSlug[$row[0]])->count() > 0){
                        $upsertValues[] = [
                            'employee_slug' => $employeesExcelToSlug[$row[0]],
                            'pay_master_employee_listing_slug' => $payrollMaster->payrollMasterEmployees->where('employee_slug',$employeesExcelToSlug[$row[0]])->first()->slug,
                            'slug' => Str::random(),
                            'type' => 'DEDUCTION',
                            'code' => $deduction->deduction_code,
                            'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                            'original_amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                            'priority' => $deduction->n_priority,
                            'account_code' => $deduction->account_code,
                        ];
                    }
                }

            }
        }

        PayrollMasterDetails::query()
            ->upsert(
                $upsertValues,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','original_amount','priority','account_code']
            );
        return true;
    }

    public function editDeduction(Request $request)
    {

        $payMasterDetail = PayrollMasterDetails::query()
            ->find($request->slug);
        $payMasterEmployee = PayrollMasterEmployees::query()
            ->find($request->employeeListSlug);
        return view('_payroll.payroll-preparation.global.edit-deduction')->with([
            'payMasterDetail' => $payMasterDetail,
            'payMasterEmployee' => $payMasterEmployee,
            'deductionCode' => $request->deductionCode,
        ]);
    }

    public function removeColumn($request,$payrollMaster)
    {
        $code = $request->code;
        if($payrollMaster->hmtDetails()->where('code','=',$code)->delete()){
            return true;
        }
        abort(503,'Error removing column.');
    }

    public function reports(Request $request)
    {
        if($request->has('generate')){
            return $this->reportGenerate($request);
        }
        return view('_payroll.payroll-preparation.reports');
    }

    public function reportGenerate(Request $request)
    {

        $usedRc = [];

        /*
        $employees = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->slug => $data,
            ];
        });
        */

        $payrollMasterEmployeesGrouped = PayrollMasterEmployees::query()
            ->with(['employee'])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->groupBy('employee_slug')
            ->get();
        $employees = PayrollMasterEmployees::query()
            ->whereIn('pay_master_slug',$request->payrolls)
            ->groupBy('employee_slug')
            ->get()
            ->mapWithKeys(function ($data){
                return [
                    $data->employee_slug => $data,
                ];
            });

        $payrollMasterEmployees = PayrollMasterEmployees::query()
            ->with(['employeePayrollDetails'])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->get();



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

        /*
        $t = $payrollMaster->payrollMasterEmployees->groupBy(function ($data){
            return $data->employee->resp_center;
        })->toArray();
        */
        $t = $payrollMasterEmployeesGrouped->groupBy(function ($data){
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


        $payrollMasters = PayrollMaster::query()
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
                'hmtDetails.employeePayroll',
                'hmtDetails.chartOfAccount',
            ])
            ->orderBy('date')
            ->whereIn('slug',$request->payrolls)
            ->get();

        $usedCodes = [];

        foreach ($payrollMasters as $payrollMaster){
            $keys = $payrollMaster->hmtDetails
                ->sortBy(function ($d){

                    if($d->type == 'INCENTIVE'){
                        return '1'.$d->priority;
                    }else{
                        return '2'.$d->priority;
                    }
                })
                ->groupBy('code')
                ->keys();
            foreach ($keys as $key){
                $usedCodes[] = $key;
            }
        }
        $usedCodes = array_unique($usedCodes);
        return view('printables.hru.payroll_preparation.DIFF.payroll-consolidated')->with([
            'payrollMasters' => $payrollMasters,
            'tree' => $tree,
            'payrollEmployeesGroupedByRespCenter' => $payrollMasterEmployeesGrouped->groupBy(function ($data){
                return $data->employee->resp_center;
            }),
            'payrollEmployeesBySlug' => $payrollMasterEmployeesGrouped->mapWithKeys(function ($data){
                return [
                    $data->employee->slug => $data,
                ];
            }),
            'usedRc' => $usedRc,
            'payrollMasterEmployees' => $payrollMasterEmployees,
            'usedCodes' => $usedCodes,
        ]);


        return Pdf::view('printables.hru.payroll_preparation.DIFF.payroll-consolidated',[
            'pdfPrint' => true,
            'payrollMasters' => $payrollMasters,
            'tree' => $tree,
            'payrollEmployeesGroupedByRespCenter' => $payrollMasterEmployeesGrouped->groupBy(function ($data){
                return $data->employee->resp_center;
            }),
            'payrollEmployeesBySlug' => $payrollMasterEmployeesGrouped->mapWithKeys(function ($data){
                return [
                    $data->employee->slug => $data,
                ];
            }),
            'usedRc' => $usedRc,
            'payrollMasterEmployees' => $payrollMasterEmployees,
            'usedCodes' => $usedCodes,
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
        return view('printables.hru.payroll_preparation.DIFF.payroll-consolidated')->with([
            'payrollMasters' => $payrollMasters,
            'tree' => $tree,
            'payrollEmployeesGroupedByRespCenter' => $payrollMasterEmployeesGrouped->groupBy(function ($data){
                return $data->employee->resp_center;
            }),
            'payrollEmployeesBySlug' => $payrollMasterEmployeesGrouped->mapWithKeys(function ($data){
                return [
                    $data->employee->slug => $data,
                ];
            }),
            'usedRc' => $usedRc,
            'payrollMasterEmployees' => $payrollMasterEmployees,
            'usedCodes' => $usedCodes,
        ]);
        */


    }


}