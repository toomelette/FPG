<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
        return view('dashboard.hru.payroll_template.index');
    }

    public function edit($slug){
        $employee = $this->payrollTemplateService->findEmployeeBySlug($slug);
        return view('dashboard.hru.payroll_template.edit')->with([
            'employee' => $employee,
        ]);

    }
}