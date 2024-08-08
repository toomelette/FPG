<?php

namespace App\Swep\Services\HRU;

use App\Http\Requests\Hru\PayrollUpdateFormRequest;
use App\Imports\GSISImport;
use App\Models\HRU\Deductions;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\PayrollTree;
use App\Models\HRU\TemplateDeductions;
use App\Models\HRU\TemplateIncentives;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MonthlyPayrollService
{



    public function edit($payMasterSlug,Request $request)
    {
        if($request->has('recompute') && $request->recompute == true){
            return $this->recompute($payMasterSlug);
        }
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee',
                'payrollMasterEmployees.employeePayrollDetails',
            ])
            ->find($payMasterSlug);

            $payrollMaster ?? abort(404,'Payroll not found.');

        return view('_payroll.payroll-preparation.MONTHLY.edit')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function recompute($payrollMasterSlug){

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee',
            ])
            ->find($payrollMasterSlug);
        if($payrollMaster->is_locked ){
            abort(503,'This Payroll is locked. Unlock it first to perform action.');
        }

        //1. Update basic pay based on employee master file
        $jobGrades = Arrays::jobGrades();
        $toBeUpserted = [];
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            $employee = $employeeFromList->employee;
            if(isset($jobGrades[$employee->salary_grade][$employee->step_inc])){
                $monthlyBasicPay = $jobGrades[$employee->salary_grade][$employee->step_inc];
                array_push($toBeUpserted,[
                    'employee_slug' => $employee->slug,
                    'incentive_code' => 'MONTHLY',
                    'priority' => 1,
                    'amount' => $monthlyBasicPay,
                ]);
            }
        }

        //Push updates to Payroll Template
        TemplateIncentives::query()
            ->upsert(
                $toBeUpserted,
                ['employee_slug','incentive_code'],
                ['amount']
            );

        $this->updatePhilhealth($payrollMaster);


        //2. START OF FETCH DATA FROM TEMPLATE TO DETAILS
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives' => function ($q){
                    $q->whereHas('incentive',function ($query){
                        $query->isMonthly();
                    });
//                        ->nonZero()
                },
                'payrollMasterEmployees.employee.templateIncentives.incentive',
                'payrollMasterEmployees.employee.templateDeductions' => function($q){
//                    $q->nonZero();
                },
                'payrollMasterEmployees.employee.templateDeductions.deduction',
            ])
            ->find($payrollMasterSlug);
        $detailsArr = [];
        //GET DEDUCTIONS From Payroll Template Deductions to be put to Payroll Details
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            if(!empty($employeeFromList->employee->templateDeductions)){


                //push incentives
                foreach ($employeeFromList->employee->templateIncentives as $templateIncentive){
                    array_push($detailsArr,[
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'INCENTIVE',
                        'code' => $templateIncentive->incentive_code,
                        'amount' => $templateIncentive->amount,
                        'priority' => $templateIncentive->incentive->n_priority,
                        'sundry_account' => null,
                        'account_code' => $templateIncentive->incentive->account_code,
                    ]);
                }


                $salaryThreshold = 5000;
                $monthlyIncentive = $employeeFromList->employee->templateIncentives->sum('amount');
                $employeeDedectionsFromTemplate = $employeeFromList->employee->templateDeductions
                    ->sortBy(function($data){
                        if($data->priority == null){
                            return 100000;
                        }else{
                            return $data->priority;
                        }
                    });

                /* DEDUCTIONS */
                $stop = 0;
                foreach ($employeeDedectionsFromTemplate as $templateDeduction){
                    $monthlyIncentive = $monthlyIncentive - $templateDeduction->amount;
                    $deductionAmount  = $templateDeduction->amount;
                    if($stop == 0){
                        if($monthlyIncentive < $salaryThreshold){
                            $amountToBeDeducted = $deductionAmount + ($monthlyIncentive - $salaryThreshold);
                            $deductionAmount = $amountToBeDeducted;
                            $stop = 1;
                        }
                        array_push($detailsArr,[
                            'employee_slug' => $employeeFromList->employee->slug,
                            'pay_master_employee_listing_slug' => $employeeFromList->slug,
                            'slug' => Str::random(),
                            'type' => 'DEDUCTION',
                            'code' => $templateDeduction->deduction_code,
                            'amount' => $deductionAmount,
                            'priority' => $templateDeduction->deduction->n_priority,
                            'sundry_account' => $templateDeduction->deduction->sundry_account,
                            'account_code' => $templateDeduction->deduction->account_code,
                        ]);
                    }
                }
            }
        }

        PayrollMasterDetails::query()
            ->upsert(
                $detailsArr,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','priority','sundry_account','account_code']
            );


//        dd($detailsArr);
//        $toDelete = $payrollMaster->hmtDetails();
//        $toDelete->delete();

        //remove ZERO amounts
        $payrollMaster->hmtDetails()->where('amount','=',null)->delete();


//        PayrollMasterDetails::query()->insert($detailsArr);

        //3. Compute Tax
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives' => function ($q){
                    $q->whereHas('incentive',function ($query){
                        $query->isMonthly();
                    })
                        ->nonZero();
                },
                'payrollMasterEmployees.employee.templateIncentives.incentive',
                'payrollMasterEmployees.employee.templateDeductions' => function($q){
                    $q->whereHas('deduction',function ($qq){
                        $qq->preTaxDeduction();
                    });
                },
                'payrollMasterEmployees.employee.templateDeductions.deduction',
            ])
            ->find($payrollMasterSlug);
        $taxesArr = [];
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            $employee = $employeeFromList->employee;

            $totalPreTaxDeduction = $employee->templateDeductions->sum('amount');
            $tax = Helper::computeTax(
                $employee->templateIncentives->where('incentive_code','MONTHLY')->first()->amount ?? 0,
                $totalPreTaxDeduction
            );

//            if($employee->slug == 'tyiLlrc3Nu4hSVz5'){
//                dd($tax);
//            }

            array_push($taxesArr,[
                'employee_slug' => $employee->slug,
                'deduction_code' => 'WTAX',
                'amount' => $tax,
            ]);

        }
        //Push updates to Payroll Template
        TemplateDeductions::query()
            ->upsert(
                $taxesArr,
                ['employee_slug','deduction_code'],
                ['amount']
            );


        //4. Repeat step 2
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives' => function ($q){
                    $q->whereHas('incentive',function ($query){
                        $query->isMonthly();
                    })
                        ->nonZero();
                },
                'payrollMasterEmployees.employee.templateIncentives.incentive',
                'payrollMasterEmployees.employee.templateDeductions' => function($q){
                    $q->nonZero();
                },
                'payrollMasterEmployees.employee.templateDeductions.deduction',
            ])
            ->find($payrollMasterSlug);
        $detailsArr = [];
        //GET DEDUCTIONS From Payroll Template Deductions to be put to Payroll Details
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            if(!empty($employeeFromList->employee->templateDeductions)){


                //push incentives
                foreach ($employeeFromList->employee->templateIncentives as $templateIncentive){
                    array_push($detailsArr,[
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'INCENTIVE',
                        'code' => $templateIncentive->incentive_code,
                        'amount' => $templateIncentive->amount,
                        'priority' => $templateIncentive->incentive->n_priority,
                        'sundry_account' => null,
                        'account_code' => $templateIncentive->incentive->account_code,
                    ]);
                }


                $salaryThreshold = 5000;
                $monthlyIncentive = $employeeFromList->employee->templateIncentives->sum('amount');
                $employeeDedectionsFromTemplate = $employeeFromList->employee->templateDeductions
                    ->sortBy(function($data){
                        if($data->priority == null){
                            return 100000;
                        }else{
                            return $data->priority;
                        }
                    });

                /* DEDUCTIONS */
                $stop = 0;
                foreach ($employeeDedectionsFromTemplate as $templateDeduction){
                    $monthlyIncentive = $monthlyIncentive - $templateDeduction->amount;
                    $deductionAmount  = $templateDeduction->amount;
                    if($stop == 0){
                        if($monthlyIncentive < $salaryThreshold){
                            $amountToBeDeducted = $deductionAmount + ($monthlyIncentive - $salaryThreshold);
                            $deductionAmount = $amountToBeDeducted;
                            $stop = 1;
                        }
                        array_push($detailsArr,[
                            'employee_slug' => $employeeFromList->employee->slug,
                            'pay_master_employee_listing_slug' => $employeeFromList->slug,
                            'slug' => Str::random(),
                            'type' => 'DEDUCTION',
                            'code' => $templateDeduction->deduction_code,
                            'amount' => $deductionAmount,
                            'priority' => $templateDeduction->deduction->n_priority,
                            'sundry_account' => $templateDeduction->deduction->sundry_account,
                            'account_code' => $templateDeduction->deduction->account_code,
                        ]);
                    }
                }
            }
        }


//        $toDelete = $payrollMaster->hmtDetails();
//        $toDelete->delete();
//        PayrollMasterDetails::query()->insert($detailsArr);
        PayrollMasterDetails::query()
            ->upsert(
                $detailsArr,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','priority','sundry_account','account_code']
            );

        //5. recompute 15th and 30th
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives' => function ($q){
                    $q->whereHas('incentive',function ($query){
                        $query->isMonthly();
                    })
                        ->nonZero();
                },
                'payrollMasterEmployees.employee.templateIncentives.incentive',
                'payrollMasterEmployees.employee.templateDeductions' => function($q){
                    $q->nonZero();
                },
                'payrollMasterEmployees.employee.templateDeductions.deduction',
            ])
            ->find($payrollMasterSlug);
        $upsertValues = [];

        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            $totalIncentives = $employeeFromList->employeePayrollDetails->where('type','INCENTIVE')->sum('amount');
            $totalDeductions = $employeeFromList->employeePayrollDetails->where('type','DEDUCTION')->sum('amount');
            $takeHomePay = $totalIncentives - $totalDeductions;
            $decimalPart = $takeHomePay - floor($takeHomePay);
            $pay15 = round($takeHomePay/2) + $decimalPart;
            $pay30 = $takeHomePay - $pay15;

            array_push($upsertValues,[
                'slug' => $employeeFromList->slug,
                'pay15' => $pay15,
                'pay30' => $pay30,
            ]);
        }

        PayrollMasterEmployees::query()->upsert($upsertValues,
            ['slug'],
            ['pay15','pay30']
        );

        return view('_payroll.payroll-preparation.MONTHLY.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function updatePhilhealth(PayrollMaster $payrollMaster)
    {
        $upsertValues = [];
        $deductionCode = 'PHIC';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');
        $jobGrades = Arrays::jobGrades();
        $max = 2500;
        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            if(isset($jobGrades[$employee->employee->salary_grade][$employee->employee->step_inc])){
                $philhealthDeduction = ($jobGrades[$employee->employee->salary_grade][$employee->employee->step_inc]) * 0.025;
                $philhealthDeduction = bcdiv($philhealthDeduction,1,2);
                if($philhealthDeduction > $max){
                    $philhealthDeduction = $max;
                }
                array_push($upsertValues,[
                    'employee_slug' => $employee->employee_slug,
                    'deduction_code' => $deduction->deduction_code,
                    'priority' => $deduction->n_priority,
                    'amount' => $philhealthDeduction,
                ]);
            }

        }

        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount']
        );
    }

    public function hdmfUpload(PayrollMaster $payrollMaster,Request $request)
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
                if(isset($employeesExcelToSlug[$row[0]]) && isset($row[$headersFlipped[$excelHeader]]) && $row[$headersFlipped[$excelHeader]] != 0){
                    array_push($upsertValues,[
                        'employee_slug' => $employeesExcelToSlug[$row[0]],
                        'deduction_code' => $deduction->deduction_code,
                        'priority' => $deduction->n_priority,
                        'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                    ]);
                }

            }
        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount']
        );
    }

    public function gsisUpload(PayrollMaster $payrollMaster,Request $request)
    {
        $excel = Excel::toArray(new GSISImport(),$request->file('file'));
        $data = $excel[0];
        $headers = $data[0];
        $headersFlipped = collect($headers)->flip();
        array_forget($data,0);
        $deductions = Arrays::deductionsExcelHeader('GSIS');
        $employeesGsisToSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->gsis => $data->employee->slug,
            ];
        });
        $upsertValues = [];
        foreach ($data as $row){
            foreach ($deductions as $excelHeader => $deduction){
                if(isset($employeesGsisToSlug[$row[0]]) && isset($row[$headersFlipped[$excelHeader]]) && $row[$headersFlipped[$excelHeader]] != 0){
                    array_push($upsertValues,[
                        'employee_slug' => $employeesGsisToSlug[$row[0]],
                        'deduction_code' => $deduction->deduction_code,
                        'priority' => $deduction->n_priority,
                        'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                    ]);
                }
            }
        }

        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount']
        );

    }

    public function printPayroll($payrollMasterSlug)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => [
                    'employee.plantilla',
                    'employeePayrollDetails',
                ],
                'hmtDetails.chartOfAccount',
            ])
            ->findOrFail($payrollMasterSlug);
        $usedRc = [];
        $employees = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->slug => $data,
            ];
        });
        foreach ($employees as $employee){
            if(!empty($employee->employee->responsibilityCenter)){
                $usedRc[$employee->employee->responsibilityCenter->rc.$employee->employee->responsibilityCenter->div.$employee->employee->responsibilityCenter->sec] = $employee->employee->responsibilityCenter->rc.$employee->employee->responsibilityCenter->div.$employee->employee->responsibilityCenter->sec;
                $usedRc[$employee->employee->responsibilityCenter->rc.$employee->employee->responsibilityCenter->div.'0'] = $employee->employee->responsibilityCenter->rc.$employee->employee->responsibilityCenter->div.'0';
                $usedRc[$employee->employee->responsibilityCenter->rc.'0'.'0'] = $employee->employee->responsibilityCenter->rc.'0'.'0';
            }
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
        return view('printables.hru.payroll_preparation.monthly_payroll')->with([
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
    }

    public function updateMap(PayrollMaster $payrollMaster, Request $request)
    {
        $upsertValues = [];
        $deductionCode = 'MUTUALFUND';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');


        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            $amt = Helper::sanitizeAutonum($request->amount);
            array_push($upsertValues,[
                'employee_slug' => $employee->employee_slug,
                'deduction_code' => $deduction->deduction_code,
                'priority' => $deduction->n_priority,
                'amount' =>  $amt == 0 ? null : $amt,
            ]);
        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount']
        );
    }

    public function update(PayrollUpdateFormRequest $request,PayrollMaster $payrollMaster)
    {
        if($payrollMaster->is_locked ){
            abort(503,'This Payroll is locked. Unlock it first to perform action.');
        }

        //IF UPDATE SIGNATORIES
        if($request->ajax() && $request->has('signatories') && $request->signatories == true){
            $payrollMaster->a_name = $request->a_name;
            $payrollMaster->a_position = $request->a_position;
            $payrollMaster->b_name = $request->b_name;
            $payrollMaster->b_position = $request->b_position;
            $payrollMaster->c_name = $request->c_name;
            $payrollMaster->c_position = $request->c_position;
            $payrollMaster->d_name = $request->d_name;
            $payrollMaster->d_position = $request->d_position;
            if($payrollMaster->update()){
                return $payrollMaster->only('slug');
            }
            abort(503,'Error updating signatories');
        }
        //IF IMPORT EXCEL
        if($request->has('import') && $request->import == true){
            $payrollMaster = $payrollMaster->load(['payrollMasterEmployees.employee']);
            switch ($request->type){
                case 'GSIS':
                    return $this->gsisUpload($payrollMaster,$request);
                    break;
                case 'SURECCO' :
                case 'SUDEMUPCO' :
                case 'SUGAREAP' :
                case 'ACCTREC' :
                case 'HDMF' :
                case 'AR' :
                    return $this->hdmfUpload($payrollMaster,$request);
            }
        }

        //IF UPDATE PHILHEALTH
        if($request->has('philhealth') ){

            $payrollMaster = $payrollMaster->load(['payrollMasterEmployees.employee']);
            return $this->updatePhilhealth($payrollMaster);
        }

        //IF MAP
        if($request->has('map')){
            $payrollMaster = $payrollMaster->load(['payrollMasterEmployees.employee']);
            return $this->updateMap($payrollMaster, $request);
        }
    }

    public function printPayslips($slug,Request $request){

        $payrollMaster = PayrollMaster::query();
        $with = [
            'payrollMasterEmployees.employee.plantilla',
            'payrollMasterEmployees.employeePayrollDetails',
            'hmtDetails',
        ];

        //if requests for only 1 employee
        if($request->has('employeeList') && $request->employeeList != ''){
            $with['payrollMasterEmployees'] = function($q) use ($request){
                return $q->where('slug','=',$request->employeeList);
            };
        }

        $payrollMaster = $payrollMaster
            ->with($with)
            ->findOrFail($slug);

        return view('printables.hru.payroll_preparation.monthly_payslip_all')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }
}