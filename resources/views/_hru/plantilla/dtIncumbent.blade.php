<a class="text-strong" href="{{route('dashboard.employee.index')}}?find={{$data?->incumbentEmployee?->employee_no}}" target="_blank" >
    {!! $data?->incumbentEmployee?->full['LFEMi'] ?? '<span class="small text-muted">VACANT</span>' !!}
</a>
@if(!empty($data?->incumbentEmployee))
    @php
        $emp = $data?->incumbentEmployee;
    @endphp
    <div class="subdetail" style="margin-top: 3px">
        <table class="table-subdetail" style="width: 50%">
            <tbody>
            <tr>
                <td style="padding-right: 10px">JG - SI:</td>
                <td>{{$emp->salary_grade}} - {{$emp->step_inc}}</td>
            </tr>
            <tr>
                <td style="padding-right: 10px">Actual Salary:</td>
                <td>{{Helper::toNumber($jobGrades[$emp->salary_grade][$emp->step_inc] ?? null)}}</td>
            </tr>
            <tr>
                <td style="padding-right: 10px">Appt. Status:</td>
                <td>{{strtoupper($emp->appointment_status)}}</td>
            </tr>

            </tbody>
        </table>
    </div>
@endif

