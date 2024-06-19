@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        table>thead>tr>th{
            border: 1px solid black;
        }
    </style>
<div style="font-family: Cambria">
    <table style="width: 100%">
        <tr>
            <td style="width: 33%;">
                <p class="no-margin text-strong">GENERAL PAYROLL - REGULAR</p>
            </td>
            <td class="text-center">
                <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                <p class="no-margin">Quezon City</p>
            </td>
            <td style="width: 33%;">
                STATION:
                TOTAL EMPLOYEES:
            </td>
        </tr>
    </table>
    @php
        $chunkBy = 3;
        $groupedIncentives= $payrollMaster->hmtDetails
                ->where('type','INCENTIVE')
                ->sortBy(function($data){
                    if($data->priority == null){
                        return 100000;
                    }else{
                        return $data->priority;
                    }
                })
               ->mapWithKeys(function ($data){
                   return [
                       $data->code => \Illuminate\Support\Str::random(),
                   ];
               })
               ->flip()->values();

        $chunkedIncentives = $groupedIncentives->chunk($chunkBy);
        $groupedDeductions = $payrollMaster->hmtDetails
                ->where('type','DEDUCTION')
                ->sortBy(function($data){
                    if($data->priority == null){
                        return 100000;
                    }else{
                        return $data->priority;
                    }
                })->mapWithKeys(function ($data){
                   return [
                       $data->code => \Illuminate\Support\Str::random(),
                   ];
               })
               ->flip()->values();
        $chunkedDeductions = $groupedDeductions->chunk($chunkBy);



        $departments = $tree->mapWithKeys(function ($data){
                        return [
                                $data->rc_code => $data->rc_code,
                        ];
                    });
        $totals = [];
    @endphp
    <div style="break-after: page">
        <table style="width: 100%" class="">
            <thead>
            <tr>
                <th>
                    Name of Employee
                </th>
                @foreach($chunkedIncentives as $grp)
                    <th class="text-center">
                        @foreach($grp as $incentive)
                            {{$incentive}} / <br>
                        @endforeach
                    </th>
                @endforeach
                @foreach($chunkedDeductions as $grp)
                    <th class="text-center">
                        @foreach($grp as $deduction)
                            {{$deduction}} / <br>
                        @endforeach
                    </th>
                @endforeach
                <th class="text-center">Take Home Pay</th>
                <th class="text-center">RA / TA</th>
                <th class="text-center">Signature</th>
            </tr>
            </thead>
            <tbody>
                {{-- DEPARTMENT LEVEL --}}
                @foreach($tree as $dept)
                    @php
                        $totals[$dept->rc_code] = [];
                        foreach ($groupedDeductions as $ded) {
                            $totals[$dept->rc_code][$ded] = 0;
                        }
                        foreach ($groupedIncentives as $inc) {
                            $totals[$dept->rc_code][$inc] = null;
                        }
                        $totals[$dept->rc_code]['rata_deduction'] = null;
                        $totals[$dept->rc_code]['takeHomePay'] = null;
                    @endphp
                    <tr>
                        <td class="text-strong">{{$dept->desc}}</td>
                    </tr>
                    {{-- FIRST LEVEL EMPLOYEES--}}
                    @if(isset($payrollEmployeesGroupedByRespCenter[$dept->rc_code]))
                        @forelse($payrollEmployeesGroupedByRespCenter[$dept->rc_code] as $employee)
                            <tr>
                                <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                                    <span class="text-strong">{{$employee->employee->full_name}}</span>
                                    <br>
                                    {{$employee->employee->plantilla->position ?? ''}} | {{$employee->employee->salary_grade}},{{$employee->employee->step_inc}}
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
                                                        $totals[$dept->rc_code]['rata_deduction'] = $totals[$dept->rc_code]['rata_deduction'] + $employee->pay15;
                                                    @endphp
                                                </td>
                                                <td style="padding-left: 7px">15TH</td>
                                                <td>____________________</td>
                                                @break
                                            @case(2)
                                                <td class="text-right">
                                                    {{\App\Swep\Helpers\Helper::toNumber($employee->totals['takeHomePay'])}}
                                                    @php
                                                        $totals[$dept->rc_code]['takeHomePay'] = $totals[$dept->rc_code]['takeHomePay'] + $employee->totals['takeHomePay'];
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
                    {{-- END FIRST LEVEL EMPLOYEES --}}

                    {{-- SECOND LEVEL --}}
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

                            {{--SECOND LEVEL EMPLOYEES--}}
                            @if(isset($payrollEmployeesGroupedByRespCenter[$secondLevel->rc_code]))
                                @forelse($payrollEmployeesGroupedByRespCenter[$secondLevel->rc_code] as $employee)
                                    <tr>
                                        <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                                            <span class="text-strong">{{$employee->employee->full_name}}</span>
                                            <br>
                                            {{$employee->employee->plantilla->position ?? ''}} | {{$employee->employee->salary_grade}},{{$employee->employee->step_inc}}
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
                            {{-- END SECOND LEVEL EMPLOYEES --}}

                            {{-- THIRD LEVEL --}}
                            @if($secondLevel->children->count() > 0)
                                @foreach($secondLevel->children as $thirdLevel)
                                    @php
                                        $totals[$thirdLevel->rc_code] = [];
                                        foreach ($groupedDeductions as $ded) {
                                            $totals[$thirdLevel->rc_code][$ded] = 0;
                                        }
                                        foreach ($groupedIncentives as $inc) {
                                            $totals[$thirdLevel->rc_code][$inc] = null;
                                        }
                                        $totals[$thirdLevel->rc_code]['pay15'] = null;
                                        $totals[$thirdLevel->rc_code]['pay30'] = null;
                                        $totals[$thirdLevel->rc_code]['takeHomePay'] = null;
                                    @endphp

                                    <tr>
                                        <td class="text-strong" style="padding-left: 20px">{{$thirdLevel->desc}}</td>
                                    </tr>

                                    {{-- THIRD LEVEL EMPLOYEES --}}
                                    @if(isset($payrollEmployeesGroupedByRespCenter[$thirdLevel->rc_code]))
                                        @forelse($payrollEmployeesGroupedByRespCenter[$thirdLevel->rc_code] as $employee)
                                            <tr>
                                                <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                                                    <span class="text-strong">{{$employee->employee->full_name}}</span>
                                                    <br>
                                                    {{$employee->employee->plantilla->position ?? ''}} | {{$employee->employee->salary_grade}},{{$employee->employee->step_inc}}
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
                                                                    $totals[$thirdLevel->rc_code][$grp->values()[$x]] = $totals[$thirdLevel->rc_code][$grp->values()[$x]] + $amt;
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
                                                                    $totals[$thirdLevel->rc_code][$grp->values()[$x]] = $totals[$thirdLevel->rc_code][$grp->values()[$x]] + $amt;
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
                                                                    $totals[$thirdLevel->rc_code]['pay15'] = $totals[$thirdLevel->rc_code]['pay15'] + $employee->pay15;
                                                                @endphp
                                                            </td>
                                                            <td style="padding-left: 7px">15TH</td>
                                                            <td>____________________</td>
                                                            @break
                                                        @case(1)
                                                            <td class="text-right">
                                                                {{\App\Swep\Helpers\Helper::toNumber($employee->pay30)}}
                                                                @php
                                                                    $totals[$thirdLevel->rc_code]['pay30'] = $totals[$thirdLevel->rc_code]['pay30'] + $employee->pay30;
                                                                @endphp
                                                            </td>
                                                            <td style="padding-left: 7px">30TH</td>
                                                            <td>____________________</td>
                                                            @break
                                                        @case(2)
                                                            <td class="text-right">
                                                                {{\App\Swep\Helpers\Helper::toNumber($employee->totals['takeHomePay'])}}
                                                                @php
                                                                    $totals[$thirdLevel->rc_code]['takeHomePay'] = $totals[$thirdLevel->rc_code]['takeHomePay'] + $employee->totals['takeHomePay'];
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
                                    {{-- END THIRD LEVEL EMPLOYEES --}}


                                    {{-- FOURTH LEVEL --}}
                                    @if($thirdLevel->children->count() > 0)
                                        @foreach($thirdLevel->children as $fourthLevel)
                                            @php
                                                $totals[$fourthLevel->rc_code] = [];
                                                foreach ($groupedDeductions as $ded) {
                                                    $totals[$fourthLevel->rc_code][$ded] = 0;
                                                }
                                                foreach ($groupedIncentives as $inc) {
                                                    $totals[$fourthLevel->rc_code][$inc] = null;
                                                }
                                                $totals[$fourthLevel->rc_code]['pay15'] = null;
                                                $totals[$fourthLevel->rc_code]['pay30'] = null;
                                                $totals[$fourthLevel->rc_code]['takeHomePay'] = null;
                                            @endphp

                                            <tr>
                                                <td class="text-strong" style="padding-left: 30px">{{$fourthLevel->desc}}</td>
                                            </tr>

                                            {{-- FOURTH LEVEL EMPLOYEES --}}
                                            @if(isset($payrollEmployeesGroupedByRespCenter[$fourthLevel->rc_code]))
                                                @forelse($payrollEmployeesGroupedByRespCenter[$fourthLevel->rc_code] as $employee)
                                                    <tr>
                                                        <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}">
                                                            <span class="text-strong">{{$employee->employee->full_name}}</span>
                                                            <br>
                                                            {{$employee->employee->plantilla->position ?? ''}} | {{$employee->employee->salary_grade}},{{$employee->employee->step_inc}}
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
                                                                            $totals[$fourthLevel->rc_code][$grp->values()[$x]] = $totals[$fourthLevel->rc_code][$grp->values()[$x]] + $amt;
                                                                            $totals[$thirdLevel->rc_code][$grp->values()[$x]] = $totals[$thirdLevel->rc_code][$grp->values()[$x]] + $amt;
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
                                                                            $totals[$fourthLevel->rc_code][$grp->values()[$x]] = $totals[$fourthLevel->rc_code][$grp->values()[$x]] + $amt;
                                                                            $totals[$thirdLevel->rc_code][$grp->values()[$x]] = $totals[$thirdLevel->rc_code][$grp->values()[$x]] + $amt;
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
                                                                            $totals[$fourthLevel->rc_code]['pay15'] = $totals[$fourthLevel->rc_code]['pay15'] + $employee->pay15;
                                                                        @endphp
                                                                    </td>
                                                                    <td style="padding-left: 7px">15TH</td>
                                                                    <td>____________________</td>
                                                                    @break
                                                                @case(1)
                                                                    <td class="text-right">
                                                                        {{\App\Swep\Helpers\Helper::toNumber($employee->pay30)}}
                                                                        @php
                                                                            $totals[$fourthLevel->rc_code]['pay30'] = $totals[$fourthLevel->rc_code]['pay30'] + $employee->pay30;
                                                                        @endphp
                                                                    </td>
                                                                    <td style="padding-left: 7px">30TH</td>
                                                                    <td>____________________</td>
                                                                    @break
                                                                @case(2)
                                                                    <td class="text-right">
                                                                        {{\App\Swep\Helpers\Helper::toNumber($employee->totals['takeHomePay'])}}
                                                                        @php
                                                                            $totals[$fourthLevel->rc_code]['takeHomePay'] = $totals[$fourthLevel->rc_code]['takeHomePay'] + $employee->totals['takeHomePay'];
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
                                            {{-- END FOURTH LEVEL EMPLOYEES --}}



                                            {{-- FOURTH LEVEL TOTALS --}}
                                            <tr>
                                                <td style="vertical-align: top; padding-left: 30px" rowspan="{{$chunkBy + 1}}" class="b-top">
                                                    TOTAL {{$fourthLevel->desc}}
                                                </td>
                                            </tr>
                                            @for($x = 0; $x < $chunkBy ; $x++)
                                                <tr>
                                                    @foreach($chunkedIncentives as $grp)
                                                        <td class="text-right {{$x==0?'b-top':''}}">
                                                            @if(isset($grp->values()[$x]))
                                                                {{Helper::toNumber($totals[$fourthLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                                                            @else
                                                                <br>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    @foreach($chunkedDeductions as $grp)
                                                        <td class="text-right {{$x==0?'b-top':''}}">
                                                            @if(isset($grp->values()[$x]))
                                                                {{Helper::toNumber($totals[$fourthLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                                                            @else
                                                                <br>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    @switch($x)
                                                        @case(0)
                                                            <td class="text-right b-top">
                                                                {{\App\Swep\Helpers\Helper::toNumber($totals[$fourthLevel->rc_code]['pay15'])}}
                                                            </td>
                                                            <td style="padding-left: 7px" class="b-top">15TH</td>
                                                            <td class="b-top"></td>
                                                            @break
                                                        @case(1)
                                                            <td class="text-right">
                                                                {{\App\Swep\Helpers\Helper::toNumber($totals[$fourthLevel->rc_code]['pay30'])}}
                                                            </td>
                                                            <td style="padding-left: 7px">30TH</td>
                                                            <td></td>
                                                            @break
                                                        @case(2)
                                                            <td class="text-right">
                                                                {{\App\Swep\Helpers\Helper::toNumber($totals[$fourthLevel->rc_code]['takeHomePay'])}}
                                                            </td>
                                                            <td style="padding-left: 7px">TOTAL</td>
                                                            <td> </td>
                                                            @break
                                                    @endswitch
                                                </tr>
                                            @endfor
                                            {{-- END FOURTH LEVEL TOTALS --}}


                                        @endforeach
                                    @endif
                                    {{-- END FOURTH LEVEL --}}


                                    {{-- THIRD LEVEL TOTALS --}}
                                    <tr>
                                        <td style="vertical-align: top; padding-left: 20px" rowspan="{{$chunkBy + 1}}" class="b-top">
                                            TOTAL {{$thirdLevel->desc}}
                                        </td>
                                    </tr>
                                    @for($x = 0; $x < $chunkBy ; $x++)
                                        <tr>
                                            @foreach($chunkedIncentives as $grp)
                                                <td class="text-right {{$x==0?'b-top':''}}">
                                                    @if(isset($grp->values()[$x]))
                                                        {{Helper::toNumber($totals[$thirdLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                                                    @else
                                                        <br>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @foreach($chunkedDeductions as $grp)
                                                <td class="text-right {{$x==0?'b-top':''}}">
                                                    @if(isset($grp->values()[$x]))
                                                        {{Helper::toNumber($totals[$thirdLevel->rc_code][$grp->values()[$x]] ?? null,2)}}
                                                    @else
                                                        <br>
                                                    @endif
                                                </td>
                                            @endforeach
                                            @switch($x)
                                                @case(0)
                                                    <td class="text-right b-top">
                                                        {{\App\Swep\Helpers\Helper::toNumber($totals[$thirdLevel->rc_code]['pay15'])}}
                                                    </td>
                                                    <td style="padding-left: 7px" class="b-top">15TH</td>
                                                    <td class="b-top"></td>
                                                    @break
                                                @case(1)
                                                    <td class="text-right">
                                                        {{\App\Swep\Helpers\Helper::toNumber($totals[$thirdLevel->rc_code]['pay30'])}}
                                                    </td>
                                                    <td style="padding-left: 7px">30TH</td>
                                                    <td></td>
                                                    @break
                                                @case(2)
                                                    <td class="text-right">
                                                        {{\App\Swep\Helpers\Helper::toNumber($totals[$thirdLevel->rc_code]['takeHomePay'])}}
                                                    </td>
                                                    <td style="padding-left: 7px">TOTAL</td>
                                                    <td> </td>
                                                    @break
                                            @endswitch
                                        </tr>
                                    @endfor
                                    {{-- END THIRD LEVEL TOTALS --}}


                                @endforeach
                            @endif
                            {{-- END THIRD LEVEL --}}

                            {{-- SECOND LEVEL TOTALS --}}
                            <tr>
                                <td style="vertical-align: top; padding-left: 10px" rowspan="{{$chunkBy + 1}}" class="b-top">
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
                    {{-- END SECOND LEVEL --}}

                    {{-- FIRST LEVEL TOTALS --}}
                    <tr>
                        <td style="vertical-align: top" rowspan="{{$chunkBy + 1}}" class="b-top">
                            TOTAL {{$dept->desc}}
                        </td>
                    </tr>
                    @for($x = 0; $x < $chunkBy ; $x++)
                        <tr>
                            @foreach($chunkedIncentives as $grp)
                                <td class="text-right {{$x==0?'b-top':''}}">
                                    @if(isset($grp->values()[$x]))
                                        {{Helper::toNumber($totals[$dept->rc_code][$grp->values()[$x]] ?? null,2)}}
                                    @else
                                        <br>
                                    @endif
                                </td>
                            @endforeach
                            @foreach($chunkedDeductions as $grp)
                                <td class="text-right {{$x==0?'b-top':''}}">
                                    @if(isset($grp->values()[$x]))
                                        {{Helper::toNumber($totals[$dept->rc_code][$grp->values()[$x]] ?? null,2)}}
                                    @else
                                        <br>
                                    @endif
                                </td>
                            @endforeach
                            @switch($x)
                                @case(0)
                                    <td class="text-right b-top">
                                        {{\App\Swep\Helpers\Helper::toNumber($totals[$dept->rc_code]['rata_deduction'])}}
                                    </td>
                                    <td style="padding-left: 7px" class="b-top">15TH</td>
                                    <td class="b-top"></td>
                                    @break
                                @case(2)
                                    <td class="text-right">
                                        {{\App\Swep\Helpers\Helper::toNumber($totals[$dept->rc_code]['takeHomePay'])}}
                                    </td>
                                    <td style="padding-left: 7px">TOTAL</td>
                                    <td style="break-after: page"> </td>
                                    @break
                            @endswitch
                        </tr>
                    @endfor
                    {{-- END FIRST LEVEL TOTALS --}}
                @endforeach

            </tbody>
        </table>


</div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            let set = 625;
            if ($("#items_table_{{$rand}}").height() < set) {
                let rem = set - $("#items_table_{{$rand}}").height();
                $("#adjuster").css('height', rem)
                print();
            }
        })
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection