<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HRU\PayrollEmployeeSettings;
use App\Models\HRU\TemplateDeductions;
use App\Models\HRU\TemplateIncentives;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
use App\Swep\Services\HRU\PayrollTemplateService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PayrollTemplateController extends Controller
{
    public function __construct(
        protected PayrollTemplateService $payrollTemplateService,
    )
    {

    }

    public function index(Request $request){
        if($request->ajax() && $request->has('updateAllTaxRates') && $request->updateAllTaxRates == true){
            $emps = Employee::query()
                    ->active()
                    ->permanent()
                    ->applyProjectId()
                    ->orderBy('lastname','asc')
                    ->get();
            $jobGrades = Arrays::jobGrades();
            foreach ($emps as $emp){
                if(isset($jobGrades[$emp->salary_grade][$emp->step_inc])){
                    $monthlyBasic = $jobGrades[$emp->salary_grade][$emp->step_inc];
                    $taxRate = $emp->tax_rate;
                    $taxAmount = $monthlyBasic * $taxRate;
                    if($taxAmount != 0){
                        dd($taxAmount, $monthlyBasic, $taxRate);
                    }
                }
            }
        }
        if($request->ajax() && $request->has('draw')){
            $employees = Employee::query()
                ->with([
                    'nonZeroIncentives',
                ])
                ->applyProjectId()
                ->active();
            return DataTables::of($employees)
                ->addColumn('action',function($data){
                    return view('dashboard.hru.payroll_template.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('incentives',function($data){
                    return view('dashboard.hru.payroll_template.dtIncentives')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('deductions',function($data){
                    return view('dashboard.hru.payroll_template.dtDeductions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }

        $employees = \App\Models\Employee::query()
            ->permanent()
            ->active()
            ->applyProjectId()
            ->orderBy('lastname','asc')
            ->get();

        return view('_payroll.payroll-template.index')->with([
            'employees' => $employees,
        ]);
    }

    public function edit($slug){
        $employee = $this->payrollTemplateService->findEmployeeBySlug($slug);
        $employee->load('payrollSettings');
        $incentivesArray = $employee->templateIncentives->mapWithKeys(function ($data){
           return [
               $data->incentive_code => $data->amount,
           ];
        });
        $deductionsArray = $employee->templateDeductions->mapWithKeys(function ($data){
            return [
                $data->deduction_code => $data->amount,
            ];
        });

        return view('_payroll.payroll-template.edit')->with([
            'employee' => $employee,
            'employeeIncentivesArray' => $incentivesArray,
            'employeeDeductionsArray' => $deductionsArray,
        ]);
    }

    public function update(Request $request,$empSlug){

        $emp = $this->payrollTemplateService->findEmployeeBySlug($empSlug);
        $emp->load('payrollSettings');

        if(!empty($emp->payrollSettings)){
            $emp->payrollSettings->receives_hazard_prc = $request->has('receives_hazard_prc') ? 1 : null;
            $emp->payrollSettings->hazard_prc_tax_rate = $request->has('receives_hazard_prc') ? $request->hazard_prc_tax_rate : null;
            $emp->payrollSettings->save();
        }else{
            PayrollEmployeeSettings::query()->insert([
                'employee_slug' => $empSlug,
                'receives_hazard_prc' => $request->has('receives_hazard_prc') ? 1 : null,
                'hazard_prc_tax_rate' => $request->has('receives_hazard_prc') ? $request->hazard_prc_tax_rate : null,
            ]);
        }
        $arrIncentives = [];
        if(count($request->incentives) > 0){
            foreach ($request->incentives as $code => $incentive){
                array_push($arrIncentives,[
                    'employee_slug' => $empSlug,
                    'incentive_code' => $code,
                    'amount' => Helper::sanitizeAutonum($incentive),
                ]);
            }
        }

        $arrDeductions = [];
        if(count($request->deductions) > 0){
            foreach ($request->deductions as $code => $deduction){
                array_push($arrDeductions,[
                    'employee_slug' => $empSlug,
                    'deduction_code' => $code,
                    'amount' => Helper::sanitizeAutonum($deduction),
                ]);
            }
        }
        $emp->templateIncentives()->delete();
        $emp->templateDeductions()->delete();

        if(TemplateIncentives::insert($arrIncentives) && TemplateDeductions::insert($arrDeductions)){
            return $emp->only('slug');
        }
        abort(503,'Error saving changes.');

    }
}