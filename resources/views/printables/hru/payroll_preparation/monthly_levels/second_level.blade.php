@if($dept->children->count() > 0)
    @foreach($dept->children as $secondLevel)
        @php
            $totals[$secondLevel->rc_code] = [];
            foreach ($groupedDeductions as $ded) {
                $totals[$secondLevel->rc_code][$ded] = 0;
            }
            foreach ($groupedIncentives as $inc) {
                $totals[$secondLevel->rc_code][$inc] = null;
            }
            $totals[$secondLevel->rc_code]['pay15'] = null;
            $totals[$secondLevel->rc_code]['pay30'] = null;
            $totals[$secondLevel->rc_code]['takeHomePay'] = null;
        @endphp

        <tr>
            <td class="text-strong" style="padding-left: 10px">{{$secondLevel->desc}}</td>
        </tr>

        @if(isset($payrollEmployeesGroupedByRespCenter[$secondLevel->rc_code]))
            @forelse($payrollEmployeesGroupedByRespCenter[$secondLevel->rc_code] as $employee)
                <tr>
                    <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                        <span class="text-strong">{{$employee->employee->full_name}}</span>
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
                                    {{Helper::toNumber($amt = $employee->employeePayrollDetails->where('code',$grp->values()[$x])->first()->amount ?? null,2)}}
                                    @php
                                        $totals[$secondLevel->rc_code][$grp->values()[$x]] = $totals[$secondLevel->rc_code][$grp->values()[$x]] + $amt;
                                        $totals[$dept->rc_code][$grp->values()[$x]] = $totals[$dept->rc_code][$grp->values()[$x]] + $amt;
                                    @endphp
                                @else
                                    <br>
                                @endif
                            </td>
                        @endforeach
                        @foreach($chunkedDeductions as $grp)
                            <td class="text-right">
                                @if(isset($grp->values()[$x]))
                                    {{Helper::toNumber($amt = $employee->employeePayrollDetails->where('code',$grp->values()[$x])->first()->amount ?? null,2)}}
                                    @php
                                        $totals[$secondLevel->rc_code][$grp->values()[$x]] = $totals[$secondLevel->rc_code][$grp->values()[$x]] + $amt;
                                        $totals[$dept->rc_code][$grp->values()[$x]] = $totals[$dept->rc_code][$grp->values()[$x]] + $amt;
                                    @endphp
                                @else
                                    <br>
                                @endif
                            </td>
                        @endforeach
                        @switch($x)
                            @case(0)
                                <td class="text-right">
                                    {{\App\Swep\Helpers\Helper::toNumber($employee->pay15)}}
                                    @php
                                        $totals[$secondLevel->rc_code]['pay15'] = $totals[$secondLevel->rc_code]['pay15'] + $employee->pay15;
                                    @endphp
                                </td>
                                <td style="padding-left: 7px">15TH</td>
                                <td>____________________</td>
                                @break
                            @case(1)
                                <td class="text-right">
                                    {{\App\Swep\Helpers\Helper::toNumber($employee->pay30)}}
                                    @php
                                        $totals[$secondLevel->rc_code]['pay30'] = $totals[$secondLevel->rc_code]['pay30'] + $employee->pay30;
                                    @endphp
                                </td>
                                <td style="padding-left: 7px">30TH</td>
                                <td>____________________</td>
                                @break
                            @case(2)
                                <td class="text-right">
                                    {{\App\Swep\Helpers\Helper::toNumber($employee->totals['takeHomePay'])}}
                                    @php
                                        $totals[$secondLevel->rc_code]['takeHomePay'] = $totals[$secondLevel->rc_code]['takeHomePay'] + $employee->totals['takeHomePay'];
                                    @endphp
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
                </tr>
            @empty
            @endforelse
        @endif
        {{-- SECOND LEVEL TOTALS --}}
        <tr>
            <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}" class="b-top">
                TOTAL {{$secondLevel->desc}}
            </td>
        </tr>
        @for($x = 0; $x < $chunkBy ; $x++)
            <tr>
                @foreach($chunkedIncentives as $grp)
                    <td class="text-right {{$x==0?'b-top':''}}">
                        @if(isset($grp->values()[$x]))
                            {{Helper::toNumber($totals[$secondLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                        @else
                            <br>
                        @endif
                    </td>
                @endforeach
                @foreach($chunkedDeductions as $grp)
                    <td class="text-right {{$x==0?'b-top':''}}">
                        @if(isset($grp->values()[$x]))
                            {{Helper::toNumber($totals[$secondLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                        @else
                            <br>
                        @endif
                    </td>
                @endforeach
                @switch($x)
                    @case(0)
                        <td class="text-right b-top">
                            {{\App\Swep\Helpers\Helper::toNumber($totals[$secondLevel->rc_code]['pay15'])}}
                        </td>
                        <td style="padding-left: 7px" class="b-top">15TH</td>
                        <td class="b-top"></td>
                        @break
                    @case(1)
                        <td class="text-right">
                            {{\App\Swep\Helpers\Helper::toNumber($totals[$secondLevel->rc_code]['pay30'])}}
                        </td>
                        <td style="padding-left: 7px">30TH</td>
                        <td></td>
                        @break
                    @case(2)
                        <td class="text-right">
                            {{\App\Swep\Helpers\Helper::toNumber($totals[$secondLevel->rc_code]['takeHomePay'])}}
                        </td>
                        <td style="padding-left: 7px">TOTAL</td>
                        <td> </td>
                        @break
                @endswitch
            </tr>
        @endfor
        {{-- END SECOND LEVEL TOTALS --}}


    @endforeach
@endif