<?php

namespace App\Swep\Services\HRU;

use App\Imports\GSISImport;
use App\Models\Employee;
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


    public function printPayrollGlobal($payrollMasterSlug)
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



        return Pdf::view('printables.hru.payroll_preparation.GLOBAL.payroll',[
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

    public function printDeductionRegisterGlobal($payrollMasterSlug)
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



        return Pdf::view('printables.hru.payroll_preparation.GLOBAL.deduction-register',[
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

        return view('printables.hru.payroll_preparation.GLOBAL.deduction-register')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }


    public function printAbstractGlobal($payrollMasterSlug)
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

    public function printAlphalistGlobal($payrollMasterSlug)
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
        return Pdf::view('printables.hru.payroll_preparation.GLOBAL.alphalist',[
            'pdfPrint' => true,
            'payrollMaster' => $payrollMaster,
        ])
            ->paperSize('215.9','330.2')
            ->portrait()
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

        return view('printables.hru.payroll_preparation.GLOBAL.alphalist')->with([
            'payrollMaster' => $payrollMaster,
        ]);

    }
    public function reports(Request $request)
    {
        if($request->has('generate')){
            return $this->reportGenerate($request);
        }
        return view('_payroll.payroll-preparation.reports');
    }

    public function consolidatedMonthly(Request $request)
    {
        $usedRc = [];
        $payrollMasterEmployeesGrouped = PayrollMasterEmployees::query()
            ->with(['employee'])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
            ->groupBy('employee_slug')
            ->get();
        $employees = PayrollMasterEmployees::query()
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)

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
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)

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
            ->orderBy('type')
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

    public function consolidatedGsis(Request $request)
    {
        $usedRc = [];
        $payrollMasterEmployeesGrouped = PayrollMasterEmployees::query()
            ->with(['employee'])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
            ->groupBy('employee_slug')
            ->get();
        $employees = PayrollMasterEmployees::query()
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
            ->groupBy('employee_slug')
            ->get()
            ->mapWithKeys(function ($data){
                return [
                    $data->employee_slug => $data,
                ];
            });

        $payrollMasterEmployees = PayrollMasterEmployees::query()
            ->with([
                'employeePayrollDetails' => function ($employeePayrollDetails) {
                    $employeePayrollDetails->where('code','=','GSIS');
                }
            ])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
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
                'payrollMasterEmployees.employeePayrollDetails' => function ($employeePayrollDetails) {
                    $employeePayrollDetails->where('code','=','GSIS');
                },
                'hmtDetails' => function ($hmtDetails) use($request){
                    $hmtDetails->where('code','=','GSIS');
                    //Payroll Groups
                    if($request->has('payrollGroupsSelected') && count($request->payrollGroupsSelected) > 0){
                        $hmtDetails->intermediateGroup($request->payrollGroupsSelected);
                    }

                },
                'hmtDetails.employeePayroll',
                'hmtDetails.chartOfAccount',
            ])
            ->orderBy('date')
            ->orderBy('type')
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
        $flattenedDetails = $payrollMasters->flatMap->hmtDetails;
        $types = $payrollMasters->pluck('type')->unique();
        $flattenedDetailsArray = [];
        foreach ($types as $type){
            $flattenedDetailsArray[$type] = $flattenedDetails->where('employeePayroll.payrollMaster.type','=',$type);
        }

        return view('printables.hru.payroll_preparation.DIFF.payroll-gsis-consolidated')->with([
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
            'flattenedDetails' => $flattenedDetails,
            'flattenedDetailsArray' => $flattenedDetailsArray,
            'flattenedEmployees' => $payrollMasters->flatMap->payrollMasterEmployees,
        ]);
        return Pdf::view('printables.hru.payroll_preparation.DIFF.payroll-gsis-consolidated',[
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
            'flattenedDetails' => $flattenedDetails,
            'flattenedDetailsArray' => $flattenedDetailsArray,
            'flattenedEmployees' => $payrollMasters->flatMap->payrollMasterEmployees,
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
         return view('printables.hru.payroll_preparation.DIFF.payroll-main-consolidated')->with([
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
            'flattenedDetails' => $flattenedDetails,
            'flattenedDetailsArray' => $flattenedDetailsArray,
            'flattenedEmployees' => $payrollMasters->flatMap->payrollMasterEmployees,
        ]);

        */

    }

    public function consolidatedMain(Request $request)
    {
        $usedRc = [];
        $payrollMasterEmployeesGrouped = PayrollMasterEmployees::query()
            ->with(['employee'])
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)

            ->groupBy('employee_slug')
            ->get();
        $employees = PayrollMasterEmployees::query()
            ->whereIn('pay_master_slug',$request->payrolls)
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
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
            ->whereIn('employee_payroll_type',$request->payrollGroupsSelected)
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
            ->orderBy('type')
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
        $flattenedDetails = $payrollMasters->flatMap->hmtDetails;
        $types = $payrollMasters->pluck('type')->unique();
        $flattenedDetailsArray = [];
        foreach ($types as $type){
            $flattenedDetailsArray[$type] = $flattenedDetails->where('employeePayroll.payrollMaster.type','=',$type);
        }





        return Pdf::view('printables.hru.payroll_preparation.DIFF.payroll-main-consolidated',[
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
            'flattenedDetails' => $flattenedDetails,
            'flattenedDetailsArray' => $flattenedDetailsArray,
            'flattenedEmployees' => $payrollMasters->flatMap->payrollMasterEmployees,
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
         return view('printables.hru.payroll_preparation.DIFF.payroll-main-consolidated')->with([
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
            'flattenedDetails' => $flattenedDetails,
            'flattenedDetailsArray' => $flattenedDetailsArray,
            'flattenedEmployees' => $payrollMasters->flatMap->payrollMasterEmployees,
        ]);

        */

    }

    public function reportGenerate(Request $request)
    {
        if($request->has('type') && $request->type == 'per_month'){
            return $this->consolidatedMonthly($request);
        }
        if($request->has('type') && $request->type == 'main'){
            return $this->consolidatedMain($request);
        }
        if($request->has('type') && $request->type == 'gsis'){
            return $this->consolidatedGsis($request);
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
        return view('_payroll.payroll-preparation.global.show-employee')->with([
            'employeePayrollListSlug' => $request->employeePayrollListSlug,
            'employeePayrollList' => $employeePayrollList,
            'payMasterSlug' => $payMasterSlug,
        ]);
    }

    public function uploadTax(Request $request)
    {
        $excel = Excel::toArray(new GSISImport(),$request->file('file'));
        $data = $excel[0];

        $headers = $data[0];
        //remove null values
        $headers = array_filter($headers,function ($value){ return !is_null($value) && $value != ''; });
        $taxHeaderIndex = array_search('WTAX',$headers);


        $headersFlipped = collect($headers)->flip();

        array_forget($data,0);

        $rowsExceptHeaders = $data;
        $deductionsToBeInserted = [];
        $deductions = Arrays::deductionsExcelHeader($request->type);


        $excelCollection = collect($rowsExceptHeaders);
        $employeeNos = $excelCollection->pluck(0);
        $employees = Employee::query()
            ->whereIn('employee_no',$employeeNos)
            ->get();
        if($employeeNos->count() !== $employees->count()){
            abort(503,'Errorrrrrr');
        }

        $employeeSlugToTax = [];

        foreach ($excelCollection as $excelRow){
            $employeeSlug = $employees->where('employee_no','=',$excelRow[0])->first()->slug;
            $employeeSlugToTax[$employeeSlug] = $excelRow[$taxHeaderIndex] / count($request->payrolls);
        }



        $payrollSlugs = $request->payrolls;

        $details = PayrollMasterDetails::query()
            ->with(['employeePayroll'])
            ->whereHas('employeePayroll.payrollMaster',function ($payrollMaster) use ($payrollSlugs){
                $payrollMaster->whereIn('slug',$payrollSlugs);
            })
            ->where('code','WTAX')
            ->get();
        $deductionsFromDb = Deductions::query()
            ->get();
        $deductions = [];
        $upsertEmployees = [];
        $usedListingSlug = [];
        foreach ($details as $detail){
            $listing = $detail->employeePayroll;
            $usedListingSlug[] = $listing->slug;
            $newAmount = round( $employeeSlugToTax[$listing->employee_slug],2);

            $deductions[] = [
                'pay_master_employee_listing_slug' => $listing->slug,
                'slug' => Str::random(),
                'type' => 'DEDUCTION',
                'code' => 'WTAX',
                'amount' => $newAmount,
                'priority' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->n_priority,
                'account_code' => $deductionsFromDb->where('deduction_code','WTAX')?->first()?->account_code,
                'govt_share' => null,
            ];


            $hasBeenEdited = $listing->has_been_edited ?? [];
            if(array_search('WTAX',$hasBeenEdited) === false){
                $hasBeenEdited[] = 'WTAX';
            }
            $upsertEmployees[] = [
                'slug' => $listing->slug,
                'has_been_edited' => json_encode($hasBeenEdited),
            ];
        }

        $emp = PayrollMasterEmployees::query()->upsert(
            $upsertEmployees,
            ['slug'],
            [
                'has_been_edited',
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
                    'priority',
                    'account_code',
                    'govt_share',
                ]
            );

        dd($request->all());
    }

    public function deleteEmployee(Request $request, $payrollMaster)
    {
        $pme = $payrollMaster->payrollMasterEmployees()->firstWhere('slug',$request->data);
        if($pme->delete()){
            $pme->employeePayrollDetails()->delete();
            return $pme->slug;
        }
        abort(503,'Error deleting item.');
    }
}