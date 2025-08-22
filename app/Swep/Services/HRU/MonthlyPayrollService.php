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
use App\Models\PPU\PPURespCodes;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

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

    public function recompute($payrollMasterSlug,$payMasterEmployeeSlug = null,$avoid = []){

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
                'payrollMasterEmployees.employee',
            ])
            ->find($payrollMasterSlug);
        if($payrollMaster->is_locked ){
            abort(503,'This Payroll is locked. Unlock it first to perform action.');
        }

//        $payrollMaster->hmtDetails()->delete();

        $this->updateEmployeesData($payrollMaster,$payMasterEmployeeSlug);

        //1. Update basic pay based on employee master file
        $toBeUpserted = [];
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            $employee = $employeeFromList->employee;
            array_push($toBeUpserted,[
                'employee_slug' => $employee->slug,
                'incentive_code' => 'MONTHLY',
                'priority' => 1,
                'amount' => $employeeFromList->saved_employee_data['monthly_basic'],
            ]);

        }



        //Push updates to Payroll Template
        TemplateIncentives::query()
            ->upsert(
                $toBeUpserted,
                ['employee_slug','incentive_code'],
                ['amount']
            );

        //Update GSIS Deductions
        $this->updateGsis($payrollMaster);
        //Update Philhealth Deductions
        if(!in_array('PHIC',$avoid)){
            $this->updatePhilhealth($payrollMaster);
        }
        //Update HDMF
        $this->updateHdmfGovtShare($payrollMaster);

        //2. START OF FETCH DATA FROM TEMPLATE TO DETAILS
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
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
        $allDeductions = Deductions::query()->get()->pluck('deduction_code');

        //GET DEDUCTIONS From Payroll Template Deductions to be put to Payroll Details
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){

            if(!empty($employeeFromList->employee->templateDeductions)){
                $unusedDeductionCodes = $allDeductions;
                //push incentives
                foreach ($employeeFromList->employee->templateIncentives as $templateIncentive){
                    array_push($detailsArr,[
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'INCENTIVE',
                        'code' => $templateIncentive->incentive_code,
                        'amount' => $templateIncentive->amount,
                        'non_taxable_amount' => null,
                        'priority' => $templateIncentive->incentive->n_priority,
                        'sundry_account' => null,
                        'account_code' => $templateIncentive->incentive->account_code,
                        'govt_share' => null,
                        'ec_share' => null,
                    ]);
                }



                $salaryThreshold = 5000;
                $monthlyIncentive = $employeeFromList->employee->templateIncentives->sum('amount');
                $employeeDeductionsFromTemplate = $employeeFromList->employee->templateDeductions
                    ->sortBy(function($data){
                        if($data->priority == null){
                            return 100000;
                        }else{
                            return $data->priority;
                        }
                    });
                /* DEDUCTIONS */
                $stop = 0;


                foreach ($employeeDeductionsFromTemplate as $templateDeduction){

                    $monthlyIncentive = $monthlyIncentive - $templateDeduction->amount;
                    $deductionAmount  = $templateDeduction->amount;
                    $nonTaxableAmount = null;
                    if($templateDeduction->deduction_code == 'HDMF'){
                        $nonTaxableAmount = 200;
                    }
                    if($stop == 0){
                        if($monthlyIncentive < $salaryThreshold){
                            $amountToBeDeducted = $deductionAmount + ($monthlyIncentive - $salaryThreshold);
                            $deductionAmount = $amountToBeDeducted;
                            $stop = 1;
                        }
                    }else{
                        $deductionAmount = 0;
                    }
                    if($templateDeduction->deduction_code == 'WTAX'){

                    }
                    $detailsArr[] = [
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $templateDeduction->deduction_code,
                        'amount' => $templateDeduction->amount,
                        'non_taxable_amount' => $nonTaxableAmount ?? $deductionAmount,
                        'priority' => $templateDeduction->deduction->n_priority,
                        'sundry_account' => $templateDeduction->deduction->sundry_account,
                        'account_code' => $templateDeduction->deduction->account_code,
                        'govt_share' => $templateDeduction->govt_share,
                        'ec_share' => $templateDeduction->ec_share,
                    ];

                }

                $unusedCodesButExistsInDetails = $employeeFromList->employeePayrollDetails->where('type','DEDUCTION')->pluck('code')->diff($employeeFromList->employee->templateDeductions->pluck('deduction_code'));
                foreach ($unusedCodesButExistsInDetails as $unusedCodesButExistsInDetail) {
                    $detailsArr[] = [
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $unusedCodesButExistsInDetail,
                        'amount' => 0,
                        'non_taxable_amount' => null,
                        'priority' => $templateDeduction->deduction->n_priority,
                        'sundry_account' => $templateDeduction->deduction->sundry_account,
                        'account_code' => $templateDeduction->deduction->account_code,
                        'govt_share' => $templateDeduction->govt_share,
                        'ec_share' => $templateDeduction->ec_share,
                    ];
                }



            }

        }


        PayrollMasterDetails::query()
            ->upsert(
                $detailsArr,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','non_taxable_amount','priority','sundry_account','account_code','govt_share','ec_share']
            );

        //remove ZERO amounts
        $payrollMaster->hmtDetails()
            ->where('amount','=',null)
            ->orWhere('amount','=',0)
            ->delete();


        //3. Compute Tax

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                }
                ,
                'payrollMasterEmployees.employeePayrollDetailsIncentives' => function ($g) {
                    $g->whereHas('incentive',function ($gg){
                        $gg->isMonthly();
                    });
                },
                'payrollMasterEmployees.employeePayrollDetailsDeductions' => function ($f) {
                    $f->whereHas('deduction',function ($ff){
                        $ff->preTaxDeduction();
                    });
                }
            ])
            ->find($payrollMasterSlug);

       /*
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
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
       */

        $taxesArr = [];
        $code = 'WTAX';
        $taxPriority = Deductions::query()->where('deduction_code','=',$code)->first()->n_priority ?? null;
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){

            //if tax has already been edited, do not proceed to compute, use the user input values instead.
            if(array_search($code,$employeeFromList->has_been_edited ?? []) === false){
                $employee = $employeeFromList->employee;
                $totalPreTaxDeduction = $employeeFromList->employeePayrollDetailsDeductions->sum('non_taxable_amount');


                $tax = Helper::computeTax(
                    $employee->templateIncentives->where('incentive_code','MONTHLY')->first()->amount ?? 0,
                    $totalPreTaxDeduction
                );

                $taxesArr[] = [
                    'employee_slug' => $employee->slug,
                    'deduction_code' => 'WTAX',
                    'amount' => $tax,
                    'priority' => $taxPriority,
                ];
            }
        }

        //Push updates to Payroll Template
        TemplateDeductions::query()
            ->upsert(
                $taxesArr,
                ['employee_slug','deduction_code'],
                ['amount','priority']
            );


        //4. Repeat step 2
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
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
                        'non_taxable_amount' => null,
                        'priority' => $templateIncentive->incentive->n_priority,
                        'sundry_account' => null,
                        'account_code' => $templateIncentive->incentive->account_code,
                        'govt_share' => null,
                        'ec_share' => null,
                    ]);
                }


                $salaryThreshold = 5000;
                $monthlyIncentive = $employeeFromList->employee->templateIncentives->sum('amount');



                $employeeDeductionsFromTemplate = $employeeFromList->employee->templateDeductions
                    ->sortBy(function($data){
                        if($data->priority == null){
                            return 100000;
                        }else{
                            return $data->priority;
                        }
                    });

                /* DEDUCTIONS */
                $stop = 0;
                foreach ($employeeDeductionsFromTemplate as $templateDeduction){
                    $monthlyIncentive = $monthlyIncentive - $templateDeduction->amount;
                    $deductionAmount  = $templateDeduction->amount;
                    $nonTaxableAmount = null; //1 before
                    if($templateDeduction->deduction_code == 'HDMF'){
                        $nonTaxableAmount = 200;
                    }
                    if($stop == 0){
                        if($monthlyIncentive < $salaryThreshold){
                            $amountToBeDeducted = $deductionAmount + ($monthlyIncentive - $salaryThreshold);
                            $deductionAmount = $amountToBeDeducted;
                            $stop = 1;
                        }
                    }else{
                        $deductionAmount = 0;
                    }

                    $detailsArr[] = [
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $templateDeduction->deduction_code,
                        'amount' => $deductionAmount,
                        'non_taxable_amount' => $nonTaxableAmount ?? $deductionAmount,
                        'priority' => $templateDeduction->deduction->n_priority,
                        'sundry_account' => $templateDeduction->deduction->sundry_account,
                        'account_code' => $templateDeduction->deduction->account_code,
                        'govt_share' => $templateDeduction->govt_share,
                        'ec_share' => $templateDeduction->ec_share,
                    ];
                }

            }

        }


        PayrollMasterDetails::query()
            ->upsert(
                $detailsArr,
                ['pay_master_employee_listing_slug','type','code'],
                ['amount','non_taxable_amount','priority','sundry_account','account_code','govt_share','ec_share']
            );

        //remove ZERO amounts
        $payrollMaster->hmtDetails()
            ->where('amount','=',null)
            ->orWhere('amount','=',0)
            ->delete();

        //5. recompute 15th and 30th
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => function ($e) use ($payMasterEmployeeSlug) {
                    if($payMasterEmployeeSlug != null){
                        $e->where('slug','=',$payMasterEmployeeSlug);
                    }
                },
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
            $takeHomePay = Helper::absolute($totalIncentives - $totalDeductions);
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


        $groupedIncentives= $payrollMaster->hmtDetails
            ->where('type','INCENTIVE')
            ->sortBy(function($data){
                if($data->priority == null){
                    return 100000;
                }else{
                    return $data->priority;
                }
            })
            ->groupBy('code');

        $groupedDeductions = $payrollMaster->hmtDetails
            ->where('type','DEDUCTION')
            ->sortBy(function($data){
                if($data->priority == null){
                    return 100000;
                }else{
                    return $data->priority;
                }
            })
            ->groupBy('code');

        if($payMasterEmployeeSlug != null){
            return view('_payroll.payroll-preparation.MONTHLY.preview-row')->with([
                'employee' => $payrollMaster->payrollMasterEmployees->first(),
                'groupedIncentives' => $groupedIncentives,
                'groupedDeductions' => $groupedDeductions,
            ]);
        }


        return view('_payroll.payroll-preparation.MONTHLY.preview')->with([
            'payrollMaster' => $payrollMaster,
            'groupedIncentives' => $groupedIncentives,
            'groupedDeductions' => $groupedDeductions,
        ]);
    }

    public function updatePhilhealth(PayrollMaster $payrollMaster)
    {

        $upsertValues = [];
        $deductionCode = 'PHIC';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');
        $max = 5000;

        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            $philhealthDeduction = $employee->saved_employee_data['monthly_basic'] * $deduction->factor;
            if($philhealthDeduction > $max){
                $philhealthDeduction = $max;
            }
            $phicEShare = Helper::absolute(bcdiv($philhealthDeduction / 2,1,2));
            $phicGovtShare = $philhealthDeduction - $phicEShare;


            array_push($upsertValues,[
                'employee_slug' => $employee->employee_slug,
                'deduction_code' => $deduction->deduction_code,
                'priority' => $deduction->n_priority,
                'amount' => $phicEShare,
                'govt_share' => $phicGovtShare,
            ]);

        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount','govt_share']
        );
    }

    public function updateGsis(PayrollMaster $payrollMaster)
    {
        $upsertValues = [];
        $deductionCode = 'GSIS';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');

        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            $personnelShare = $employee->saved_employee_data['monthly_basic'] * $deduction->factor;
            $govtShare  = $employee->saved_employee_data['monthly_basic'] * $deduction->govt_share_factor;

            array_push($upsertValues,[
                'employee_slug' => $employee->employee_slug,
                'deduction_code' => $deduction->deduction_code,
                'priority' => $deduction->n_priority,
                'amount' => $personnelShare,
                'govt_share' => $govtShare,
                'ec_share' => 100,
            ]);

        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount','govt_share','ec_share']
        );

    }

    public function updateGsisGovtShare(PayrollMaster $payrollMaster)
    {
        $upsertValues = [];
        $deductionCode = 'GSIS';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');

        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            $personnelShare = $employee->saved_employee_data['monthly_basic'] * $deduction->factor;
            $govtShare  = $employee->saved_employee_data['monthly_basic'] * $deduction->govt_share_factor;
            array_push($upsertValues,[
                'employee_slug' => $employee->employee_slug,
                'deduction_code' => $deduction->deduction_code,
                'priority' => $deduction->n_priority,
                'amount' => $personnelShare,
                'govt_share' => $govtShare,
                'ec_share' => 100,
            ]);

        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount','govt_share','ec_share']
        );
    }

    public function updateHdmfGovtShare(PayrollMaster $payrollMaster)
    {
        $upsertValues = [];
        $deductionCode = 'HDMF';
        $deduction = Deductions::query()->where('deduction_code','=',$deductionCode)->first();
            $deduction ?? abort(503,'Deduction not found.');

        foreach ($payrollMaster->payrollMasterEmployees as $employee){
            $govtShare  = 200;
            array_push($upsertValues,[
                'employee_slug' => $employee->employee_slug,
                'deduction_code' => $deduction->deduction_code,
                'priority' => $deduction->n_priority,
                'govt_share' => $govtShare,
            ]);

        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','govt_share']
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

    public function showEmployee($payMasterSlug,Request $request)
    {

        $employeePayrollList = PayrollMasterEmployees::query()
            ->with([
                'employeePayrollDetails',
            ])
            ->where('slug','=',$request->employeePayrollListSlug)
            ->first();
        return view('_payroll.payroll-preparation.MONTHLY.show-employee')->with([
            'employeePayrollListSlug' => $request->employeePayrollListSlug,
            'employeePayrollList' => $employeePayrollList,
            'payMasterSlug' => $payMasterSlug,
        ]);
    }

    public function gsisUpload(PayrollMaster $payrollMaster,Request $request)
    {


        $excel = Excel::toArray(new GSISImport(),$request->file('file'));

        $data = $excel[0];
        $headers = $data[0];


        $headersFlipped = collect($headers)
            ->filter(function ($value, $key){
                return $value != null;
            })
            ->flip();
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

                    if($excelHeader == 'PS'){
                        $upsertValues[] = [
                            'employee_slug' => $employeesGsisToSlug[$row[0]],
                            'deduction_code' => $deduction->deduction_code,
                            'priority' => $deduction->n_priority,
                            'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                            'govt_share' => $row[$headersFlipped['GS']] ?? 0,
                            'ec_share' => $row[$headersFlipped['EC']] ?? 0,
                        ];
                    }else{
                        $upsertValues[] = [
                            'employee_slug' => $employeesGsisToSlug[$row[0]],
                            'deduction_code' => $deduction->deduction_code,
                            'priority' => $deduction->n_priority,
                            'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                            'govt_share' => null,
                            'ec_share' => null,
                        ];
                    }
                }
            }
        }
        TemplateDeductions::query()->upsert($upsertValues,
            ['employee_slug','deduction_code'],
            ['priority','amount','govt_share','ec_share']
        );

    }

    public function printPayroll($payrollMasterSlug )
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



        return Pdf::view('printables.hru.payroll_preparation.MONTHLY.monthly_payroll',[
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
        return view('printables.hru.payroll_preparation.MONTHLY.monthly_payroll')->with([
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

    public function bulkUpdate(PayrollMaster $payrollMaster, Request $request)
    {

        $upsertValues = [];
        $deductionCode = $request->deduction_code;
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



        //IF UPDATE DEDUCTION
        if($request->has('updateDeduction')){
            return  $this->updateDeduction($request);
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

        //IF BULK
        if($request->has('bulk')){
            $payrollMaster = $payrollMaster->load(['payrollMasterEmployees.employee']);
            return $this->bulkUpdate($payrollMaster, $request);
        }
        if($request->has('updateEmployeesData')){

            return $this->updateEmployeesData($payrollMaster);
        }
    }

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
                'monthly_basic' => $jobGrades[$payrollMasterEmployee->employee->salary_grade][$payrollMasterEmployee->employee->step_inc] ?? null,
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

    public function printPayslips($slug,Request $request){

        $request = Request::capture();
        $payrollMaster = PayrollMaster::query();


        $with = [
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

        return view('printables.hru.payroll_preparation.MONTHLY.payslip_all')->with([
            'payrollMaster' => $payrollMaster,
            'employeesWithRata' => $employeesWithRata,
        ]);
    }

    public function abstractMid($payrollMasterSlug)
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

        return view('printables.hru.payroll_preparation.MONTHLY.abstract-mid')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function abstractEnd($payrollMasterSlug)
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

        return view('printables.hru.payroll_preparation.MONTHLY.abstract-end')->with([
            'payrollMaster' => $payrollMaster,
            'employeesWithRata' => $employeesWithRata,
        ]);
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

        return Pdf::view('printables.hru.payroll_preparation.MONTHLY.deduction-register',[
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
        return view('printables.hru.payroll_preparation.MONTHLY.deduction-register')->with([
            'payrollMaster' => $payrollMaster,
        ]);

    }

    public function tree($payrollMaster)
    {
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
        return $tree;
    }

    public function distributionSheet($payrollMasterSlug)
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
                'hmtDetails.employeePayroll',
                'payrollMasterEmployees.employee.plantilla'
            ])
            ->findOrFail($payrollMasterSlug);


//        return Pdf::view('printables.hru.payroll_preparation.MONTHLY.deduction-register',[
//            'payrollMaster' => $payrollMaster,
//            'pdfPrint' => true,
//        ])
//            ->format('a4')
//            ->margins(8,8, 15, 8)
//            ->headers(['title' => 'aaaaa'])
//            ->footerView('printables.hru.payroll_preparation.footer-view')
//            ->name('Deduction Register.pdf')
//            ->withBrowsershot(function (Browsershot $browsershot){
//                if(app()->environment('production')){
//                    $browsershot->setNodeBinary(env('NODE_BINARY'))
//                        ->setNpmBinary(env('NODE_BINARY'));
//                }
//            });

        return view('printables.hru.payroll_preparation.MONTHLY.distribution-sheet')->with([
            'payrollMaster' => $payrollMaster,
            'tree' => $this->tree($payrollMaster),
        ]);

    }

    public function editDeduction(Request $request)
    {
        $payMasterDetail = PayrollMasterDetails::query()
            ->find($request->slug);
        $payMasterEmployee = PayrollMasterEmployees::query()
            ->find($request->employeeListSlug);
        return view('_payroll.payroll-preparation.MONTHLY.edit-deduction')->with([
            'payMasterDetail' => $payMasterDetail,
            'payMasterEmployee' => $payMasterEmployee,
            'deductionCode' => $request->deductionCode,
        ]);
    }
    public function updateDeduction(Request $request)
    {
        $deductionMaster = Deductions::query()->where('deduction_code','=',$request->code)->first();

        $upsert  = [];
        $upsert[] = [
            'employee_slug' => $request->employee_slug,
            'deduction_code' => $request->code,
            'priority' => $deductionMaster->n_priority,
            'amount' => Helper::sanitizeAutonum($request->amount)*1
        ];

        $td = TemplateDeductions::query()
            ->where('employee_slug',$request->employee_slug)
            ->where('deduction_code','=',$request->code)
            ->first();

        /*
                $check = false;
                if($td){
                    $td->amount = Helper::sanitizeAutonum($request->amount)*1;
                    if($td->save()){
                        $check = true;
                    }

                }else{
                    $td = new TemplateDeductions();
                    $td->amount = Helper::sanitizeAutonum($request->amount)*1;
                    if($td->save()){
                        $check = true;
                    }
                }

             */
        $updateOrCreate = TemplateDeductions::query()
            ->upsert(
                $upsert,
                ['employee_slug','deduction_code'],
                ['amount']
            );

        $payMasterEmployee = PayrollMasterEmployees::query()->find($request->pay_master_employee_listing_slug);
        $payMasterSlug = $payMasterEmployee->pay_master_slug;

        $hasBeenEdited = $payMasterEmployee->has_been_edited ?? [];
        if(array_search($request->code,$hasBeenEdited) === false){
            $hasBeenEdited[] = $request->code;
            $payMasterEmployee->has_been_edited = $hasBeenEdited;
            $payMasterEmployee->save();
        }


        return $this->recompute($payMasterSlug,$payMasterEmployee->slug,['PHIC']);
        if($updateOrCreate){
            return $this->recompute($payMasterSlug,$payMasterEmployee->slug,['PHIC']);
        }
        abort(503,'Error updating payroll template.');
    }
}