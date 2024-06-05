<tr class="">
    <td style="padding-left: {{$rc->depth * 10}}px" class="text-strong">{{$rc->desc}}</td>
    @foreach($chunkedIncentives as $grp)
        <th class="text-center">
        </th>
    @endforeach
    @foreach($chunkedDeductions as $grp)
        <th class="text-center">
        </th>
    @endforeach
    <td></td>
    <td></td>
    <td></td>
</tr>


@if(!empty($rc->employees) && $rc->employees->count() > 0)
    @foreach($rc->employees as $employeeMaster)
        @php
        $employee = $payrollEmployeesBySlug[$employeeMaster->slug];

        @endphp
        <tr class="">
            <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                <span class="text-strong">{{$employeeMaster->full_name}}</span>
                <br>
                {{$employeeMaster->position}} | {{$employeeMaster->salary_grade}},{{$employeeMaster->step_inc}}
                <br>
                {{$employeeMaster->employee_no}}
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
                @switch($x)
                    @case(0)
                        <td class="text-right">
                            {{\App\Swep\Helpers\Helper::toNumber($employee->pay15)}}
                        </td>
                        <td style="padding-left: 7px">15TH</td>
                        <td>____________________</td>
                        @break
                    @case(1)
                        <td class="text-right">
                            {{\App\Swep\Helpers\Helper::toNumber($employee->pay30)}}
                        </td>
                        <td style="padding-left: 7px">30TH</td>
                        <td>____________________</td>
                        @break
                    @case(2)
                        <td class="text-right">
                            {{\App\Swep\Helpers\Helper::toNumber(
                                $employee->totals['takeHomePay']
                            )}}
                        </td>
                        <td style="padding-left: 7px">TOTAL</td>
                        <td>____________________ </td>
                        @break
                @endswitch

            </tr>
        @endfor
        <tr>
            <td><br></td>
            @foreach($chunkedIncentives as $grp)
                <td class="text-right"></td>
            @endforeach
            @foreach($chunkedDeductions as $grp)
                <td class="text-right"></td>
            @endforeach
            <td></td>
            <td></td>
            <td class="{{$loop->iteration == $rc->employees->count() ? 'brke' : ''}}"></td>
        </tr>
    @endforeach

@endif


