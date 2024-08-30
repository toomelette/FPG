<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft"
> {{$employee->saved_employee_data['full_name'] ?? ''}}</td>
@forelse($groupedIncentives as $incentive => $null)
    <td class="text-end">
        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
    </td>
@empty
@endforelse

<td class="text-end text-info incentive-subtotal">
    {{Helper::toNumber($incTotal = $employee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount'),2)}}
</td>

@forelse($groupedDeductions as $ded => $null)

    @php
        $deduction = $employee->employeePayrollDetails->where('code',$ded)->first();
    @endphp

    <td class="text-end {{($deduction->deduction->non_edit ?? null) == 1 ? '' : 'editable-dtr edit-deduction'}} " data="{{$deduction->slug ?? null}}" deduction-code="{{$ded ?? ''}}" data-bs-toggle="modal" data-bs-target="#edit-deduction-modal">
        {{Helper::toNumber($deduction->amount ?? null,2)}}
    </td>
@empty
@endforelse

<td class="text-end text-info deduction-subtotal">{{Helper::toNumber($dedTotal = $employee->employeePayrollDetails->where('type','DEDUCTION')->sum('amount'),2)}}</td>
<td class="text-end text-strong {{$incTotal - $dedTotal < 5000 ? 'text-danger table-danger' : ''}}">
    {{Helper::toNumber($incTotal - $dedTotal)}}
</td>
<td class="text-end {{$employee->pay15 < 2500 ? 'text-danger table-danger' : ''}}">{{Helper::toNumber($employee->pay15,2)}}</td>
<td class="text-end {{$employee->pay30 < 2500 ? 'text-danger table-danger' : ''}}">{{Helper::toNumber($employee->pay30,2)}}</td>