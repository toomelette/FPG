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
    @endphp


    @forelse($departments as $department)
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
                </tr>
                </thead>

                @foreach($tree->where('rc_code',$department) as $dept)
                    @if($dept->children->count() > 0)
                        @include('printables.hru.payroll_preparation.tr_respCode',[
                            'rc' => $dept,
                        ])
                        @foreach($dept->children as $division)
                            @include('printables.hru.payroll_preparation.tr_respCode',[
                                'rc' => $division,
                            ])
                            @if($division->children->count() > 0)
                                @foreach($division->children as $section)
                                    @include('printables.hru.payroll_preparation.tr_respCode',[
                                        'rc' => $section,
                                    ])
                                @endforeach
                            @else
                                @include('printables.hru.payroll_preparation.tr_respCode',[
                                    'rc' => $division,
                                ])
                            @endif
                        @endforeach


                    @else
                        @include('printables.hru.payroll_preparation.tr_respCode',[
                            'rc' => $dept,
                        ])
                    @endif


                @endforeach
            </table>
            <hr class="page-break no-print">
        </div>
    @empty
    @endforelse

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