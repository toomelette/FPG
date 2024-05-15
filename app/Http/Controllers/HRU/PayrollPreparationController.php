<?php

namespace App\Http\Controllers\HRU;

use App\Imports\GSISImport;
use App\Models\Employee;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\TemplateDeductions;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Html\Elements\P;

class PayrollPreparationController
{
    public function create(){
        return view('dashboard.hru.payroll_preparation.create');
    }

    public function store(Request $request){
        $payMaster = new PayrollMaster();
        $payMaster->slug = Str::random();
        $payMaster->date = $request->date;
        $payMaster->type = $request->type;
        $employeeArr = [];
        if(count($request->employees) > 0){
            foreach ($request->employees as $employee){
                array_push($employeeArr,[
                    'slug' => Str::random(),
                    'pay_master_slug' => $payMaster->slug,
                    'employee_slug' => $employee,
                ]);
            }
        }
        if($payMaster->save()){
            PayrollMasterEmployees::query()->insert($employeeArr);
        }
        $this->recompute($payMaster->slug);
        return $payMaster->only('slug');
    }

    public function edit($slug,Request $request){
        if($request->has('recompute') && $request->recompute == true){
            $this->recompute($slug);

            $payrollMaster = PayrollMaster::query()
                ->with([
                    'payrollMasterEmployees.employee',
                    'payrollMasterEmployees.employeePayrollDetails',
                ])
                ->find($slug);

                $payrollMaster ?? abort(404,'Payroll not found.');
            return view('dashboard.hru.payroll_preparation.preview')->with([
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

        return view('dashboard.hru.payroll_preparation.edit')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }

    public function recompute($payrollMasterSlug){
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives' => function ($q){
                    $q->whereHas('incentive',function ($query){
                        $query->isMonthly()
                            ->exceptBasicPay();
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
        $jobGrades = Arrays::jobGrades();
        //GET DEDUCTIONS From Payroll Template Deductions to be put to Payroll Details
        foreach ($payrollMaster->payrollMasterEmployees as $employeeFromList){
            if(!empty($employeeFromList->employee->templateDeductions)){

                /* DEDUCTIONS */
                foreach ($employeeFromList->employee->templateDeductions as $templateDeduction){
                    array_push($detailsArr,[
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $templateDeduction->deduction_code,
                        'amount' => $templateDeduction->amount,
                        'priority' => $templateDeduction->priority,
                    ]);
                }


                /* INCENTIVES */
                //Push Monthly Salary to Array
                array_push($detailsArr,[
                    'employee_slug' => $employeeFromList->employee->slug,
                    'pay_master_employee_listing_slug' => $employeeFromList->slug,
                    'slug' => Str::random(),
                    'type' => 'INCENTIVE',
                    'code' => 'MONTHLY',
                    'amount' => $jobGrades[$employeeFromList->employee->salary_grade][$employeeFromList->employee->step_inc] ?? null,
                    'priority' => 1,
                ]);
                //push other incentives except monthly
                foreach ($employeeFromList->employee->templateIncentives as $templateIncentive){
                    array_push($detailsArr,[
                        'employee_slug' => $employeeFromList->employee->slug,
                        'pay_master_employee_listing_slug' => $employeeFromList->slug,
                        'slug' => Str::random(),
                        'type' => 'INCENTIVE',
                        'code' => $templateIncentive->incentive_code,
                        'amount' => $templateIncentive->amount,
                        'priority' => $templateIncentive->priority,
                    ]);
                }
            }
        }


        $toDelete = $payrollMaster->hmtDetails();
        $toDelete->delete();

        PayrollMasterDetails::query()->insert($detailsArr);

        //recompute 15th and 30th
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employeePayrollDetails',
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

        return true;
    }

    public function update(Request $request,$payrollMasterSlug){
        if($request->has('import') && $request->import == true){
            $payrollMaster = PayrollMaster::query()
                ->with([
                    'payrollMasterEmployees.employee',
                ])
                ->find($payrollMasterSlug);

            switch ($request->type){
                case 'GSIS':
                    return $this->gsisUpload($payrollMaster,$request);
                break;
                case 'SURECCO' :
                case 'SUDEMUPCO' :
                case 'SUGAREAP' :
                case 'ACCTREC' :
                case 'HDMF' :
                    return $this->hdmfUpload($payrollMaster,$request);
            }
        }
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

}