<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft"
> {{$employee->saved_employee_data['full_name'] ?? ''}}</td>

<td class="text-end">
    <x-forms.input label="Basic Pay" class="text-end" name="data[{{$employee->slug}}][diff_old_monthly_basic]" cols="12" :input-only="true" :value="Helper::toNumber($employee->saved_employee_data['monthly_basic'] ?? null)"/>
</td>
<td>
    <x-forms.input label="From" name="data[{{$employee->slug}}][diff_from]"  for="diff_from" class="date-change" cols="12" :input-only="true" type="date" min="{{Carbon::parse($payrollMaster->date)->firstOfMonth()->format('Y-m-d')}}" max="{{Carbon::parse($payrollMaster->date)->lastOfMonth()->format('Y-m-d')}}" :value="$employee->diff_from"/>
</td>
<td>
    <x-forms.input label="From" name="data[{{$employee->slug}}][diff_to]"  for="diff_to" class="date-change" cols="12" :input-only="true" type="date" min="{{Carbon::parse($payrollMaster->date)->firstOfMonth()->format('Y-m-d')}}" max="{{Carbon::parse($payrollMaster->date)->lastOfMonth()->format('Y-m-d')}}" :value="$employee->diff_to"/>
</td>

<td>
    <x-forms.input label="Working Days" name="data[{{$employee->slug}}][diff_days]" for="diff_days" cols="12" :input-only="true" :value="$employee->diff_days"/>
</td>
<td>
    <x-forms.input label="Basic Pay" class="text-end" name="data[{{$employee->slug}}][diff_new_monthly_basic]" cols="12" :input-only="true" :value="$employee->diff_new_monthly_basic"/>

</td>
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