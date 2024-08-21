<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\PayrollRefundFormRequest;
use App\Models\HRU\Deductions;
use App\Models\HRU\PayrollMaster;
use App\Models\HRU\PayrollMasterDetails;
use App\Models\HRU\PayrollMasterEmployees;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PayrollRefundController extends Controller
{

    public function index($slug,Request $request)
    {
        if($request->has('show')){
            return $this->show($slug,$request);
        }
        $payrollMaster = PayrollMaster::query()
            ->with([
                'hmtDetails' => function ($q) {
                    $q->where('type','=','DEDUCTION');
                },
                'hmtDetails.deduction',
            ])
            ->withCount('payrollMasterEmployees')
            ->findOrFail($slug);
        $groupedPayrollDeductions = $payrollMaster->hmtDetails->sortBy('code')->groupBy('code','asc');
        return view('_payroll.payroll-refund.index')->with([
            'payrollMaster' => $payrollMaster,
            'groupedPayrollDeductions' => $groupedPayrollDeductions,
        ]);
    }

    public function show($slug,Request $request)
    {
        if($request->has('draw')){
            $payMasterDetails = PayrollMasterDetails::query()
                ->with([
                    'employeePayroll',
                ])
                ->whereHas('employeePayroll',function ($q) use ($slug){
                    $q->where('pay_master_slug','=',$slug);
                })
                ->where('code','=',$request->deductionCode);

            return  DataTables::of($payMasterDetails)
                ->addColumn('employee',function($data){
                    return $data->employeePayroll->saved_employee_data['full_name'];
                })
                ->addColumn('action',function($data){
                    return view('_payroll.payroll-refund.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('amount',function($data){
                    return Helper::toNumber($data->amount);
                })
                ->editColumn('refund_amount',function($data){
                    return Helper::toNumber($data->refund_amount);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();;
        }
        $deduction = Deductions::query()->where('deduction_code','=',$request->deductionCode)->first();
        return view('_payroll.payroll-refund.employee-list')->with([
            'deduction' => $deduction,
            'deductionCode' => $request->deductionCode,
            'payMasterSlug' => $slug,
        ]);
        $payrollEmployees = PayrollMasterEmployees::query()
            ->where('pay_master_slug','=',$slug);
        return $request->all();
    }

    public function edit($detailSlug)
    {
        $payrollDetail = PayrollMasterDetails::query()
            ->with([
                'employeePayroll.employee',
                'deduction',
            ])
            ->findOrFail($detailSlug);
        return view('_payroll.payroll-refund.edit')->with([
            'payrollDetail' => $payrollDetail,
        ]);
    }

    public function update($slug,PayrollRefundFormRequest $request)
    {
        $payrollDetail = PayrollMasterDetails::query()->findOrFail($slug);
        $payrollDetail->refund_amount = Helper::sanitizeAutonum($request->refund_amount);
        $payrollDetail->refund_date = $request->refund_date;
        $payrollDetail->refund_remarks = $request->refund_remarks;
        $payrollDetail->refunded_by = \Auth::user()->user_id;
        $payrollDetail->refunded_at = Carbon::now();
        if($payrollDetail->save()){
            return $payrollDetail->only('slug');
        }
        abort(503,'Error saving data.');
    }
}