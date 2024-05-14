<?php

namespace App\Http\Controllers\HRU;

use App\Imports\GSISImport;
use App\Models\Employee;
use App\Models\HRU\Incentives;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Html\Elements\P;

class PayrollPreparationController
{
    public function create(Request $request){

        if($request->update_table==true){
            return view('dashboard.hru.payroll_preparation.'.$request->type.'.emplyslist');
        };

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
        $this->{'recompute'.$request->type}($payMaster->slug);
        return $payMaster->only('slug');
    }

    private function recomputeRATA($payrollMasterSlug){

        $payrollMstrRata = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives',
            ])
            ->find($payrollMasterSlug);

        $detailsRata = [];
        $incentivesArrayAll = Arrays::incentives();

        foreach($payrollMstrRata->payrollMasterEmployees as $emplyLst){

            $codes = ['RA', 'TA'];

            if ($emplyLst->employee->templateIncentives) {
                foreach ($codes as $code) {
                    $incentive = $emplyLst->employee->templateIncentives->where('incentive_code', '=', $code)->first();

                    if ($incentive) {
                        $amount = $incentive->amount ?? $incentivesArrayAll[$code]['fixed_values'];

                        array_push($detailsRata, [
                            'employee_slug' => $emplyLst->employee_slug,
                            'pay_master_employee_listing_slug' => $emplyLst->slug,
                            'slug' => Str::random(),
                            'type' => 'INCENTIVE',
                            'code' => $code,
                            'amount' => $amount,
                            'priority' => $incentivesArrayAll[$code]['n_priority'],
                        ]);
                    }
                }
            }
        }

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
                    $this->recomputeMONTHLY($slug);
        
                    
                    return view('dashboard.hru.payroll_preparation.MONTHLY.preview')->with([
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
        
                return view('dashboard.hru.payroll_preparation.MONTHLY.edit')->with([
                    'payrollMaster' => $payrollMaster,
                ]);
                break;
            case 'RATA':
                if($request->has('recompute') && $request->recompute == true){
                    $this->recomputeRATA($slug);
        
                    
                    return view('dashboard.hru.payroll_preparation.MONTHLY.preview')->with([
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
        $incentives = Incentives::query()
            ->where('n_is_monthly','=',1)
            ->orderBy('n_priority','asc')
            ->get();


        //update basic pay based on employee master file
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollMasterEmployees.employee.templateIncentives',
            ])
            ->find($payrollMasterSlug);
        $employeeSlugToPayMasterEmployeeSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee_slug => $data->slug,
            ];
        });

        $jobGrades = Arrays::jobGrades();
        $detailsArr = [];
        $incentivesArrayAll = Arrays::incentives();
        foreach ($payrollMaster->payrollMasterEmployees as $employeeList){

            array_push($detailsArr,[
                'employee_slug' => $employeeList->employee_slug,
                'pay_master_employee_listing_slug' => $employeeList->slug,
                'slug' => Str::random(),
                'type' => 'INCENTIVE',
                'code' => 'MONTHLY',
                'amount' => $jobGrades[$employeeList->employee->salary_grade][$employeeList->employee->step_inc] ?? 0,
                'priority' => 1,
            ]);
            $code = 'PERA';
            $employeeList->employee->templateIncentives->where('incentive_code','=',$code)->first();
            $amount = $employeeList->employee->templateIncentives->where('incentive_code','=',$code)->first()->amount ?? $incentivesArrayAll[$code]['fixed_values'];
            array_push($detailsArr,[
                'employee_slug' => $employeeList->employee_slug,
                'pay_master_employee_listing_slug' => $employeeList->slug,
                'slug' => Str::random(),
                'type' => 'INCENTIVE',
                'code' => $code,
                'amount' => $amount,
                'priority' => $incentivesArrayAll[$code]['n_priority'],
            ]);
        }
        $toDelete = $payrollMaster->hmtDetails()->where(function ($q) use ($incentives){
            foreach($incentives as $incentive){
                $q->orWhere('code','=',$incentive->incentive_code);
            }
        });
        $toDelete->delete();
        PayrollMasterDetails::query()->insert($detailsArr);

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
        $deductions = Arrays::deductionsExcelHeader('HDMF');
        $employeesExcelToSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->employee_no => $data->employee->slug,
            ];
        });

        foreach ($data as $row){
            foreach ($deductions as $excelHeader => $deduction){

                if(isset($employeesExcelToSlug[$row[0]]) && isset($row[$headersFlipped[$excelHeader]]) && $row[$headersFlipped[$excelHeader]] != 0){
             
                    array_push($deductionsToBeInserted,[
                        'employee_slug' => $employeesExcelToSlug[$row[0]],
                        'pay_master_employee_listing_slug' => $employeeSlugToPayMasterEmployeeSlug[$employeesExcelToSlug[$row[0]]],
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $deduction->deduction_code,
                        'priority' => $deduction->n_priority,
                        'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                    ]);
                }
            }
        }


        $toDelete = $payrollMaster->hmtDetails()->where(function ($q) use ($deductions){
            foreach($deductions as $excelHeader => $deduction){
                $q->orWhere('code','=',$deduction->deduction_code);
            }
        });

        $toDelete->delete();
        if( PayrollMasterDetails::query()->insert($deductionsToBeInserted)){
            return true;
        }
        abort(503,'Error importing HDMF Excel.');
    }

    private function gsisUpload($payrollMaster, Request $request){
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
        $deductions = Arrays::deductionsExcelHeader('GSIS');
        $employeesGsisToSlug = $payrollMaster->payrollMasterEmployees->mapWithKeys(function ($data){
            return [
                $data->employee->gsis => $data->employee->slug,
            ];
        });

        foreach ($data as $row){
            foreach ($deductions as $excelHeader => $deduction){
                if(isset($employeesGsisToSlug[$row[0]]) && isset($row[$headersFlipped[$excelHeader]]) && $row[$headersFlipped[$excelHeader]] != 0){
                    array_push($deductionsToBeInserted,[
                        'employee_slug' => $employeesGsisToSlug[$row[0]],
                        'pay_master_employee_listing_slug' => $employeeSlugToPayMasterEmployeeSlug[$employeesGsisToSlug[$row[0]]],
                        'slug' => Str::random(),
                        'type' => 'DEDUCTION',
                        'code' => $deduction->deduction_code,
                        'priority' => $deduction->n_priority,
                        'amount' => $row[$headersFlipped[$excelHeader]] ?? 0,
                    ]);
                }
            }
        }

        $toDelete = $payrollMaster->hmtDetails()->where(function ($q) use ($deductions){
            foreach($deductions as $excelHeader => $deduction){
                $q->orWhere('code','=',$deduction->deduction_code);
            }
        });
        $toDelete->delete();


        if( PayrollMasterDetails::query()->insert($deductionsToBeInserted)){
            return true;
        }
        abort(503,'Error importing GSIS Excel.');
    }

}