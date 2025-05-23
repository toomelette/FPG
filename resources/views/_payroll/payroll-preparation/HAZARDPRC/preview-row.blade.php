<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft"
> {{$employee->saved_employee_data['full_name'] ?? ''}}</td>
<td class="text-end">{{Helper::toNumber($employee->saved_employee_data['monthly_basic'] ?? null)}}</td>
<td class="text-end">{{Helper::toNumber($employee->hazardprc_gross)}}</td>
<td class="text-center">{{$employee->hazardprc_all_days}}</td>
<td class="editable-dtr double-click-edit text-end">
    <span class="text-ph">{{$employee->hazardprc_ineligible_days}}</span>
    <form class="no-of-days-form" style="display: none">
        <div class="input-group">
            <input type="number" step="0.001" value="{{$employee->hazardprc_ineligible_days}}" class="form-control" name="ineligible_days">
            <button class="btn btn-secondary" type="submit"><i class="fa fa-check"></i></button>
        </div>
    </form>
</td>
<td class="text-end">{{$employee->hazardprc_eligible_days}}</td>
<td class="text-end">{{Helper::toNumber($employee->hazardprc_tax)}}</td>
<td class="text-end">{{Helper::toNumber($employee->hazardprc_net_amount)}}</td>