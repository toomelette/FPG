@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<div style="font-family: Cambria">

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
                <th>Take Home Pay</th>
                <th>15th 30th</th>
                <th>Signature</th>
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
                        $totals[$dept->rc_code]['[pay15'] = '';
                        $totals[$dept->rc_code]['[pay30'] = '';
                        $totals[$dept->rc_code]['[takeHomePay'] = '';
                    @endphp
                    <tr>
                        <td class="text-strong">{{$dept->desc}}</td>
                    </tr>
                    @if(isset($payrollEmployeesGroupedByRespCenter[$dept->rc_code]))
                        @forelse($payrollEmployeesGroupedByRespCenter[$dept->rc_code] as $employee)
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

                            </tr>
                        @empty
                        @endforelse
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
                                <td class="{{$x==0?'b-top':''}}"></td>
                                <td class="{{$x==0?'b-top':''}}"></td>
                                <td class="{{$x==0?'b-top':''}}"></td>
                            </tr>
                        @endfor
                    @endif

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