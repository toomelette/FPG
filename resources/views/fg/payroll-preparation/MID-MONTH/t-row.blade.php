<td>
    {{$payrollEmployee?->saved_data['LFEMi']}}
</td>

<td class="text-end">
    {{\App\Swep\Helpers\Helper::toNumber($payrollEmployee?->saved_data['monthly_basic'])}}
</td>
@forelse($employeeAdjustments as $employeeAdjustment)
    <td class="text-center">
        <label for="a-{{Str::random(10)}}" class="hide-this"></label>
        <input class="text-end payroll-autonum input-payroll"
               id="a-{{Str::random(10)}}"
               name="data[{{$payrollEmployee->id}}][{{$employeeAdjustment->code}}]"
               data-code="{{$employeeAdjustment->code}}"
               value="{{null_if_zero($payrollEmployee->employeeAdjustments->firstWhere('code','=',$employeeAdjustment->code)?->amount)}}"
        />
    </td>
@empty
@endforelse
<td class="text-end">
    {{Helper::toNumber($payrollEmployee->net_pay,2,'0.00')}}
</td>