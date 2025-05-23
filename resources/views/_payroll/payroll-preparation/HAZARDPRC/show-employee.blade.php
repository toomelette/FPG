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

<a href="{{route('dashboard.payroll_template.index')}}?find={{$employeePayrollList->employee_slug}}" target="_blank" class="btn btn-outline-secondary btn-sm mb-2" style="width: 100%;" type="button">
    <i class="fa fa-user"></i> View Payroll Template
</a>

<a href="{{route('dashboard.employee.index')}}?find={{$employeePayrollList->saved_employee_data['employee_no'] ?? ''}}" target="_blank" class="btn btn-outline-secondary btn-sm" style="width: 100%;" type="button">
    <i class="fa fa-user"></i> View Employee
</a>
<hr>

<p class="text-info mb-0 mt-2">Details</p>
<table style="width: 100%;">
    <tbody>
    <tr>
        <td class="border-top">Basic Pay</td>
        <td class="text-end text-strong border-top">{{Helper::toNumber($employeePayrollList->saved_employee_data['monthly_basic'] ?? null)}}</td>
    </tr>
    <tr>
        <td>Hazard Pay <small>(Basic pay x 30%)</small></td>
        <td class="text-end text-strong">{{Helper::toNumber($employeePayrollList->hazardprc_gross ?? null)}}</td>
    </tr>
    <tr class="text-danger">
        <td>Less <small>(Days not exposed to hazard)</small></td>
        <td class="text-end text-strong">-{{Helper::toNumber($employeePayrollList->hazardprc_ineligible_days/$employeePayrollList->hazardprc_all_days * $employeePayrollList->hazardprc_gross ?? null)}}</td>
    </tr>
    <tr>
        <td>Days Exposed to hazard</td>
        <td class="text-end text-strong">{{Helper::toNumber($employeePayrollList->hazardprc_eligible_days/$employeePayrollList->hazardprc_all_days * $employeePayrollList->hazardprc_gross ?? null)}}</td>
    </tr>
    <tr class="text-danger">
        <td>Less Tax <small>{{$employeePayrollList->hazardprc_tax_rate * 100}}%</small></td>
        <td class="text-end text-strong">-{{Helper::toNumber($employeePayrollList->hazardprc_tax ?? null)}}</td>
    </tr>
    <tr>
        <td class="border-top">Net Pay</td>
        <td class="text-end text-strong border-top">-{{Helper::toNumber($employeePayrollList->hazardprc_net_amount ?? null)}}</td>
    </tr>
    </tbody>
</table>



