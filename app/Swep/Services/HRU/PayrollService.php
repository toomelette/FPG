<?php

namespace App\Swep\Services\HRU;

use App\Imports\GSISImport;
use App\Models\HRU\Deductions;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Models\HRU\TemplateDeductions;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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


}