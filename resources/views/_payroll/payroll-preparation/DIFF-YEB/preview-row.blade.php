<td class="first employee-options-btn" data="{{$employee->slug}}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft">
    {{$employee->saved_employee_data['full_name'] ?? ''}}
</td>

<td style="width: 10px !important;" class="sticky">
    <div class="btn-group">
        <button data="{{$employee->slug}}"  type="button" for="delete" class="btn btn-sm btn-outline-danger delete-clone-btn" ><i class="fa fa-trash"></i></button>
    </div>
</td>

<td class="text-end">
    <x-forms.input label="Basic Pay" id="an-old-mbs-{{$employee->slug}}" class="text-end detect-change autonum-simple"  name="data[{{$employee->slug}}][diff_old_monthly_basic]" cols="12" :input-only="true" :value="Helper::toNumber( $employee->diff_old_monthly_basic  ?? null)"/>
</td>

<td>
    <x-forms.input label="Basic Pay" id="an-new-mbs-{{$employee->slug}}" class="text-end detect-change autonum-simple" name="data[{{$employee->slug}}][diff_new_monthly_basic]" cols="12" :input-only="true" :value="$employee->diff_new_monthly_basic"/>
    <x-forms.input label="Basic Pay" class="text-end hide-this" name="data[{{$employee->slug}}][has_been_changed]" for="has_been_changed" cols="12" :input-only="true" :value="0"/>
</td>
@forelse($incentives as $incentive)
    <td class="text-end" data-bs-toggle="modal" data-bs-target="#edit-deduction-modal" deduction-code="{{$deduction ?? ''}}" data="{{$employee->employeePayrollDetails->where('code',$incentive)->first()?->slug}}">
        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
    </td>
@empty
@endforelse
@forelse($deductions as $deduction)
{{--    <td class="text-end" data-bs-toggle="modal" data-bs-target="#edit-deduction-modal" deduction-code="{{$deduction ?? ''}}" data="{{$employee->employeePayrollDetails->where('code',$deduction)->first()?->slug}}">--}}
{{--        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$deduction)->first()->amount ?? null,2)}}--}}
{{--    </td>--}}
    <td>
        <x-forms.input label="{{$deduction ?? ''}}" id="an-new-mbs-{{Str::random(5)}}" class="text-end detect-change autonum-simple" name="data[{{$employee->slug}}][details][{{$deduction}}]" cols="12" :input-only="true" :value="$employee->employeePayrollDetails->where('code',$deduction)->first()->amount ?? null"/>
    </td>
@empty
@endforelse

<td class="text-end @if($employee->pay15 < 0) text-danger @endif">{{Helper::toNumber($employee->pay15)}}</td>