<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft"
> {{$employee->saved_employee_data['full_name'] ?? ''}}</td>
<td class="text-end">{{Helper::toNumber($employee->saved_employee_data['monthly_basic'] ?? null)}}</td>
<td class="text-end">{{Helper::toNumber($employee->rata_ra_rate)}}</td>
<td class="text-end">{{Helper::toNumber($employee->rata_ta_rate)}}</td>
<td class="editable-dtr double-click-edit text-end">
    <span class="text-ph">{{$employee->rata_actual_days_worked}}</span>
    <form class="dynamic-form" data="updateRataDays" style="display: none">
        <div class="input-group">
            <input type="number" step="0.001" value="{{$employee->rata_actual_days_worked}}" class="form-control" name="rata_actual_days_worked">
            <button class="btn btn-secondary" type="submit"><i class="fa fa-check"></i></button>
        </div>
    </form>
</td>
<td class="text-end">{{Helper::toNumber($employee->rata_total)}}</td>
<td class="text-end editable-dtr double-click-edit text-end">
    <span class="text-ph">{{Helper::toNumber($employee->rata_deductions)}}</span>
    <form class="dynamic-form" data="updateRataDeductions" style="display: none">
        <div class="input-group">
            <input value="{{$employee->rata_deductions}}" class="form-control autonum" name="rata_deductions">
            <button class="btn btn-secondary" type="submit"><i class="fa fa-check"></i></button>
        </div>
    </form>

</td>
<td class="text-end">{{Helper::toNumber($employee->rata_net_amount)}}</td>