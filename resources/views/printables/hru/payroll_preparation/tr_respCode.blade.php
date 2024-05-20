<tr>
    <td style="padding-left: {{$rc->depth * 10}}px">{{$rc->respCenter->desc}} </td>
    @foreach($chunkedIncentives as $grp)
        <th class="text-center">
        </th>
    @endforeach
    @foreach($chunkedDeductions as $grp)
        <th class="text-center">
        </th>
    @endforeach
</tr>


@if(isset($payrollEmployeesGroupedByRespCenter[$rc->rc_code]))
    @forelse($payrollEmployeesGroupedByRespCenter[$rc->rc_code] as $employee)
        <tr>
            <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                {{$employee->employee->full_name}}
                <br>
                {{$employee->employee->position}} | {{$employee->employee->salary_grade}},{{$employee->employee->step_inc}}
                <br>
                {{$employee->employee->employee_no}}
            </td>

        </tr>
        @for($x = 0; $x < $chunkBy ; $x++)
            <tr>
                @foreach($chunkedIncentives as $grp)
                    <td class="text-right">
                        @if(isset($grp->values()[$x]))
                            {{Helper::toNumber($employee->employeePayrollDetails->where('code',$grp->values()[$x])->first()->amount ?? null,2)}}
                        @else
                            <br>
                        @endif
                    </td>
                @endforeach
                @foreach($chunkedDeductions as $grp)
                    <td class="text-right">
                        @if(isset($grp->values()[$x]))
                            {{Helper::toNumber($employee->employeePayrollDetails->where('code',$grp->values()[$x])->first()->amount ?? null,2)}}
                        @else
                            <br>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endfor


    @empty
    @endforelse
@endif