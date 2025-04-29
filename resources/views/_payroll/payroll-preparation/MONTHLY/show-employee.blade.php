<h4 class="text-strong">{{$employeePayrollList->saved_employee_data['full_name'] ?? ''}}</h4>
<h5 class="text-strong">{{$employeePayrollList->saved_employee_data['employee_no'] ?? ''}}</h5>
<p>{{$employeePayrollList->saved_employee_data['position'] ?? ''}}</p>
<table class="mb-3">
    <tbody>
    <tr>
        <td style="width: 120px">Monthly Basic:</td>
        <td class="text-strong">{{Helper::toNumber($employeePayrollList->saved_employee_data['monthly_basic'] ?? '')}}</td>
    </tr>
    <tr>
        <td>Job Grade:</td>
        <td class="text-strong">{{$employeePayrollList->saved_employee_data['salary_grade'] ?? ''}}</td>
    </tr>
    <tr>
        <td>Step Inc:</td>
        <td class="text-strong">{{$employeePayrollList->saved_employee_data['step_inc'] ?? ''}}</td>
    </tr>
    </tbody>
</table>
<a href="{{route('dashboard.payroll_preparation.print',[$payMasterSlug,'PAYSLIP_ALL'])}}?employeeList={{$employeePayrollListSlug}}" target="_blank" class="btn btn-primary btn-sm mb-2" style="width: 100%;" type="button">
    <i class="fa fa-print"></i> Print Payslip
</a>

<a href="{{route('dashboard.payroll_template.index')}}?find={{$employeePayrollList->employee_slug}}" target="_blank" class="btn btn-outline-secondary btn-sm mb-2" style="width: 100%;" type="button">
    <i class="fa fa-user"></i> View Payroll Template
</a>

<a href="{{route('dashboard.employee.index')}}?find={{$employeePayrollList->saved_employee_data['employee_no'] ?? ''}}" target="_blank" class="btn btn-outline-secondary btn-sm" style="width: 100%;" type="button">
    <i class="fa fa-user"></i> View Employee
</a>
<hr>

<p class="text-info mb-0 mt-2">Summary of Incentives</p>
@php
    $incentives = $employeePayrollList->employeePayrollDetails->where('type','INCENTIVE');
 @endphp
<table style="width: 100%;">
    <tbody>
    @if($incentives->count() > 0)
        @foreach($incentives as $payrollDetail)
            <tr>
                <td>{{$payrollDetail->code}}</td>
                <td class="text-end">{{Helper::toNumber($payrollDetail->amount,2,'0.00')}}</td>
            </tr>
        @endforeach
    @endif
        <tr>
            <td class="border-top"><small>Total incentives</small></td>
            <td class="text-end text-strong border-top">{{Helper::toNumber($incentives->sum('amount'))}}</td>
        </tr>
    </tbody>
</table>

<p class="text-danger mb-0 mt-4">Summary of Deduction</p>
@php
    $deductions = $employeePayrollList->employeePayrollDetails->where('type','DEDUCTION')->sortBy('priority');
@endphp
<table style="width: 100%;">
    <tbody>
    @if($deductions->count() > 0)
        @foreach($deductions as $payrollDetail)
            <tr>
                <td>{{$payrollDetail->code}}</td>
                <td class="text-end">{{Helper::toNumber($payrollDetail->amount,2,'0.00')}}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td class="border-top"><small>Total deductions</small></td>
        <td class="text-end text-strong border-top">{{Helper::toNumber($deductions->sum('amount'))}}</td>
    </tr>
    </tbody>
</table>

<p class="text-info mb-0 mt-4">Take home pay</p>
<table style="width: 100%;">
    <tbody>
    <tr>
        <td>15th</td>
        <td class="text-end">{{Helper::toNumber($employeePayrollList->pay15,2,'0.00')}}</td>
    </tr>
    <tr>
        <td>30th</td>
        <td class="text-end">{{Helper::toNumber($employeePayrollList->pay30,2,'0.00')}}</td>
    </tr>
    <tr>
        <td class="border-top"><small>Total take home pay</small></td>
        <td class="text-end text-strong border-top">{{Helper::toNumber($employeePayrollList->pay15 + $employeePayrollList->pay30)}}</td>
    </tr>
    </tbody>
</table>

