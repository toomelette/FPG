<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft"
> {{$employee->saved_employee_data['full_name'] ?? ''}}</td>

@forelse($incentives as $incentive)
    <td class="text-end">
        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
    </td>
@empty
@endforelse
@forelse($deductions as $deduction)
    <td class="text-end editable-dtr edit-deduction" data-bs-toggle="modal" data-bs-target="#edit-deduction-modal" deduction-code="{{$deduction ?? ''}}" data="{{$employee->employeePayrollDetails->where('code',$deduction)->first()?->slug}}">
        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$deduction)->first()->amount ?? null,2)}}
    </td>
@empty
@endforelse

<td class="text-end">{{Helper::toNumber($employee->pay15)}}</td>