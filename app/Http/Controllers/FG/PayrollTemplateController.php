<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\PayrollTemplateFormRequest;
use App\Models\Employee;
use App\Models\FG\PayrollAdjustments;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PayrollTemplateController extends Controller
{
    public function __construct(
        private $folder = 'fg.payroll-template.',
    )
    {
    }

    public function index(Request $request){
        $employees = \App\Models\Employee::query()
            ->permanent()
            ->active()
            ->applyProjectId()
            ->orderBy('lastname','asc')
            ->get();

        return view($this->folder.'index')->with([
            'employees' => $employees,
        ]);
    }

    public function edit($uuid){
        $employee = Employee::query()
            ->with([
                'payrollTemplates'
            ])
            ->findOrFail($uuid);

        $payrollAdjustments = PayrollAdjustments::query()
            ->get();
        return view($this->folder.'edit')->with([
            'employee' => $employee,
            'payrollAdjustments' => $payrollAdjustments,
        ]);
    }

    public function update(PayrollTemplateFormRequest $request,$employeeUuid)
    {
        $employee = Employee::query()
            ->findOrFail($employeeUuid);
        $adjustments = [];
        $request->adjustments =  collect($request->adjustments);

        $payrollAdjustments = PayrollAdjustments::query()
            ->whereIn('code',$request->adjustments->keys()->toArray())
            ->get();

        foreach ($request->adjustments as $adjustmentCode => $amount){
            $adjustments[] = [
                'code' => $adjustmentCode,
                'type' => $payrollAdjustments->firstWhere('code',$adjustmentCode)?->type,
                'amount' => $amount,
            ];
        }
        DB::transaction(function () use ($employee,$adjustments){
            $employee->payrollTemplates()->delete();
            $employee->payrollTemplates()->createMany($adjustments);
        });
    }
}
