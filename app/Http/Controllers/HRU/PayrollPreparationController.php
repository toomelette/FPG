<?php

namespace App\Http\Controllers\HRU;

use App\Http\Requests\Hru\PayrollPreparationFormRequest;
use App\Imports\GSISImport;
use App\Models\Employee;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\TemplateDeductions;
use App\Models\HRU\TemplateIncentives;
use App\Models\PPU\PPURespCodes;
use App\Models\RCCodeTree;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use Spatie\Html\Elements\P;
use Yajra\DataTables\DataTables;

class PayrollPreparationController
{

    public function index(Request $request){
        if ($request->ajax() && $request->has('draw')){
            $pays = PayrollMaster::query()
                ->withCount('payrollMasterEmployees')
                ->withSum('payrollMasterEmployees','pay15')
                ->withSum('payrollMasterEmployees','pay30');
            return DataTables::of($pays)
                ->addColumn('action',function($data){
                    return view('dashboard.hru.payroll_preparation.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('total_amount',function($data){
                    $total15 = $data->payroll_master_employees_sum_pay15;
                    $total30 = $data->payroll_master_employees_sum_pay30;
                    return Helper::toNumber($total15 + $total30,2);
                })
                ->addColumn('details',function($data){
                    
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('dashboard.hru.payroll_preparation.index');
    }

    public function create(Request $request){

        if($request->update_table==true){
            if($request->type == ''){
                return  '';
            }
            return view('dashboard.hru.payroll_preparation.'.$request->type.'.emplyslist');
        };

        return view('dashboard.hru.payroll_preparation.create');
    }

    public function store(PayrollPreparationFormRequest $request){
        $payMaster = new PayrollMaster();
        $payMaster->slug = Str::random();
        $payMaster->date = $request->date;
        $payMaster->type = $request->type;
        $employeeArr = [];
        $upsertTemplateMonthlyBasic = [];
        $jobGrades = Arrays::jobGrades();
        $employeesBySlug = Arrays::employeesKeyedBySlug();
        if(count($request->employees) > 0){
            foreach ($request->employees as $employee){
                array_push($employeeArr,[
                    'slug' => Str::random(),
                    'pay_master_slug' => $payMaster->slug,
                    'employee_slug' => $employee,
                ]);
                array_push($upsertTemplateMonthlyBasic,[
                    'employee_slug' => $employee,
                    'incentive_code' => 'MONTHLY',
                    'priority' => 1,
                    'amount' => $jobGrades[$employeesBySlug[$employee]->salary_grade ?? 0][$employeesBySlug[$employee]->step_inc ?? 0] ?? null,
                ]);
                array_push($upsertTemplateMonthlyBasic,[
                    'employee_slug' => $employee,
                    'incentive_code' => 'PERA',
                    'priority' => 10,
                    'amount' => 2000,
                ]);
            }
        }
        if($payMaster->save()){
            PayrollMasterEmployees::query()->insert($employeeArr);
        }


        TemplateIncentives::query()->upsert($upsertTemplateMonthlyBasic,
            ['employee_slug','incentive_code'],
            ['priority','amount']
        );

        $this->{'recompute'.$request->type}($payMaster->slug);
        return $payMaster->only('slug');
    }

    private function recomputeRATA($payrollMasterSlug){

        $payrollMstrRata = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives.incentive',
            ])
            ->find($payrollMasterSlug);
        if($payrollMstrRata->is_locked ){
            abort(503,'This Payroll is locked. Unlock it first to perform action.');
        }
        $detailsRata = [];
        $incentiveCodes = ['RA', 'TA'];

        foreach($payrollMstrRata->payrollMasterEmployees as $emplyLst){
            if ($emplyLst->employee->templateIncentives) {
                foreach ($incentiveCodes as $code) {
                    $templateIncentive = $emplyLst->employee->templateIncentives->where('incentive_code', '=', $code)->first();

                    if (!empty($templateIncentive)) {
                        array_push($detailsRata, [
                            'employee_slug' => $emplyLst->employee_slug,
                            'pay_master_employee_listing_slug' => $emplyLst->slug,
                            'slug' => Str::random(),
                            'type' => 'INCENTIVE',
                            'code' => $templateIncentive->incentive_code,
                            'amount' => $templateIncentive->amount,
                            'priority' => $templateIncentive->incentive->n_priority,
                        ]);
                    }
                }
            }
        }
  
        // Delete existing HMT details related to the payroll master record
        $payrollMstrRata->hmtDetails()->delete();

        PayrollMasterDetails::query()->insert($detailsRata);
        
    }

    public function edit($slug,Request $request){

        $payrollMaster = PayrollMaster::query()
                ->with([
                    'payrollMasterEmployees.employee',
                    'payrollMasterEmployees.employeePayrollDetails',
                ])
                ->find($slug);

        $payrollMaster ?? abort(404,'Payroll not found.');

        switch($payrollMaster->type){
            case 'MONTHLY':
                if($request->has('recompute') && $request->recompute == true){
                    return $this->recomputeMONTHLY($slug);
                }
                $payrollMaster = PayrollMaster::query()
                    ->with([
                        'payrollMasterEmployees.employee',
                        'payrollMasterEmployees.employeePayrollDetails',
                    ])
                    ->find($slug);
        
                $payrollMaster ?? abort(404,'Payroll not found.');
        
                return view('dashboard.hru.payroll_preparation.MONTHLY.edit')->with([
                    'payrollMaster' => $payrollMaster,
                ]);
                break;
            case 'RATA':
                if($request->has('recompute') && $request->recompute == true){
                    $this->recomputeRATA($slug);
        
                    
                    return view('dashboard.hru.payroll_preparation.RATA.preview')->with([
                        'payrollMaster' => $payrollMaster,
                    ]);
                }
                $payrollMaster = PayrollMaster::query()
                    ->with([
                        'payrollMasterEmployees.employee',
                        'payrollMasterEmployees.employeePayrollDetails',
                    ])
                    ->find($slug);
        
                $payrollMaster ?? abort(404,'Payroll not found.');
        
                return view('dashboard.hru.payroll_preparation.RATA.edit_rata')->with([
                    'payrollMaster' => $payrollMaster,
                ]);
            break;
        }
        
    }

    public function recomputeMONTHLY($payrollMasterSlug){

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


        //2. START OF FETCH DATA FROM TEMPLATE TO DETAILS
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
                        ]);
                    }
                }
            }
        }


        $toDelete = $payrollMaster->hmtDetails();
        $toDelete->delete();


        PayrollMasterDetails::query()->insert($detailsArr);
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
                        ]);
                    }
                }
            }
        }


        $toDelete = $payrollMaster->hmtDetails();
        $toDelete->delete();


        PayrollMasterDetails::query()->insert($detailsArr);

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

        return view('dashboard.hru.payroll_preparation.MONTHLY.preview')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function update(Request $request,$payrollMasterSlug){

        if($request->has('import') && $request->import == true){
            $payrollMaster = PayrollMaster::query()
                ->with([
                    'payrollMasterEmployees.employee',
                ])
                ->find($payrollMasterSlug);
            if($payrollMaster->is_locked ){
                abort(503,'This Payroll is locked. Unlock it first to perform action.');
            }
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

    }

    public function updateRataDed(Request $request, $payrollMasterSlug)
    {
        // Validate incoming request
        $request->validate([
            'dayNo' => 'array',
            'dayNo.*' => 'nullable|integer|min:0',
        ]);

        // Initialize an array to store the updates
        $updates = [];

        // Iterate through each employee's slug and actual days worked
        foreach ($request->dayNo as $employeeSlug => $rataActualDays) {

            // If rataActualDays is not set or is empty, set it to 22
            if (empty($rataActualDays)) {
                $rataActualDays = 22;
            }

            // Compute RA and TA deduction for the employee
            $rataDeduction = $this->compRATADed($rataActualDays, $employeeSlug);

            // Add the data to the updates array
            $updates[] = [
                'slug' => $employeeSlug,
                'rata_actualdays' => $rataActualDays,
                'rata_deduction' => $rataDeduction,
            ];
        }

        // Perform the upsert operation
        PayrollMasterEmployees::query()->upsert(
            $updates,
            ['slug'], // Unique constraint columns
            ['rata_actualdays', 'rata_deduction'] // Columns to update
        );

    }

    private function compRATADed($rataActualDays, $employeeSlug)
    {
        // Fetch the payroll master with related employee and incentive details
        $employeeRecord = PayrollMasterDetails::query()
            ->where('pay_master_employee_listing_slug', $employeeSlug)
            ->get()
            ;

        // Determine the proportion based on the actual working days
        $proportion = match(true) {
            $rataActualDays >= 1 && $rataActualDays <= 5 => 0.25,
            $rataActualDays >= 6 && $rataActualDays <= 11 => 0.50,
            $rataActualDays >= 12 && $rataActualDays <= 16 => 0.75,
            $rataActualDays >= 17 => 1.00,
            default => 0, // If no working days, no RATA
        };

        $totalRATA = 0;

        // Calculate RA and TA deductions
        foreach (['RA', 'TA'] as $code) {
            $templateIncentive = $employeeRecord->where('code', $code);

            foreach ($templateIncentive as $empRata) {

                if ($empRata->amount) {
                    $computedAmount = $empRata->amount * $proportion;
                    $totalRATA += $computedAmount;
                } else {
                    logger()->warning("Template incentive not found or amount is zero for employee slug: {$employeeSlug}, code: {$code}");
                }

            }
        }

        return $totalRATA;
    }

    private function hdmfUpload($payrollMaster, Request $request){
        $employeeSlugToPayMasterEmployeeSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee_slug => $data->slug,
            ];
        });
        $excel = Excel::toArray(new GSISImport(),$request->file('file'));
        $data = $excel[0];

        $headers = $data[0];

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

    private function gsisUpload($payrollMaster, Request $request){
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

    public function print($slug,$type){

        switch ($type){
            case 'MONTHLY':
                return $this->printMonthly($slug);
                break;
            case 'PAYSLIP_ALL':
                return $this->payslipAll($slug);
                break;

        }
    }

    private function payslipAll($slug){
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => [
                    'employee.plantilla',
                    'employeePayrollDetails',
                ],
                'hmtDetails',
            ])
            ->findOrFail($slug);

        return view('printables.hru.payroll_preparation.monthly_payslip_all')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    private function printMonthly($slug){
        $tree = PPURespCodes::query()
            ->with([
                'employees' => function(HasMany $q){
                    $q->active()->applyProjectId()->permanent();
                },
            ])
            ->tree()
            ->get()
            ->toTree();

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => [
                    'employee.plantilla',
                    'employeePayrollDetails',
                ],
                'hmtDetails',
            ])
            ->findOrFail($slug);
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

    public function printRT($slug){
        $tree = PPURespCodes::query()
            ->with([
                'employees' => function(HasMany $q){
                    $q->active()->applyProjectId()->permanent();
                },
            ])
            ->tree()
            ->get()
            ->toTree();

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees' => [
                    'employee.plantilla',
                    'employeePayrollDetails',
                ],
                'hmtDetails',
            ])
            ->findOrFail($slug);

        return view('printables.hru.payroll_preparation.RATA.monthly_payroll')->with([
            'payrollMaster' => $payrollMaster,
            'tree' => $tree,
            'payrollEmployeesGroupedByRespCenter' => $payrollMaster->payrollMasterEmployees->groupBy(function ($data){
                return $data->employee->resp_center;
            }),

            'payrollEmployeesBySlug' => $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
                return [
                    $data->employee->slug => $data,
                ];
            })
        ]);
    }

    private function recursiveSearch($data,$depth = 0){
        foreach ($data as $item){
            if($item->children->count() > 0){
                $this->recursiveSearch($item->children,$depth + 1);
            }else{
                echo $item->rc_code .' Depth:'.$depth.'<br>';
            }
        }
    }

    public function updateLockStatus($payrollSlug,$status){

        $payroll = PayrollMaster::query()->find($payrollSlug);
        if($status == 'lock'){
            $payroll->is_locked = 1;
            $payroll->user_locked = \Auth::user()->user_id;
            $payroll->locked_at = \Carbon::now();
            $payroll->save();
            return 'locked';
        }

        if($status == 'unlock'){
            $payroll->is_locked = null;
            $payroll->user_unlocked = \Auth::user()->user_id;
            $payroll->unlocked_at = \Carbon::now();
            $payroll->save();
            return 'unlocked';
        }
        abort(503,$status);
    }

}