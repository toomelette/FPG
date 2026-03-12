<td>
    {{$payrollEmployee?->saved_data['LFEMi']}}
</td>

<td class="text-end">
    {{\App\Swep\Helpers\Helper::toNumber($payrollEmployee?->saved_data['monthly_basic'])}}
</td>
@forelse($employeeAdjustments as $employeeAdjustment)
    <td class="text-center">
        <input style="width: 100%" class="text-end payroll-autonum" id="a-{{Str::random(10)}}" data-code="{{$employeeAdjustment->code}}" />
    </td>
@empty
@endforelse