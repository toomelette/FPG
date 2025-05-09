@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        table>thead>tr>th {
            border: 1px solid black;
        }

    </style>

    <div style="font-family: Cambria, Caladea">
        <div class="clearfix">
            <img src="{{base_path('/public/images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
            <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
            <p class="no-margin text-left" style="font-size: 12px;"> Araneta Street, Singcang, Bacolod City</p>
        </div>

        <div style="text-align: left; margin-bottom: 20px">
            <h3 class="no-margin text-strong" style="font-size: 18px">Payroll Deduction Register</h3>
        </div>

        @php
            $groupedDeductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy(function ($data){
                    switch ($data->code){
                        case 'GSIS': return 1;
                        case 'HDMF': return 2;
                        case 'PHIC': return 3;
                        case 'WTAX': return 4;
                        default: if($data->priority == null){return 10000;}else{return $data->priority;}
                    }
                })->groupBy('code');

         @endphp
        @forelse($groupedDeductions as $deductionCode => $deductions)

            <b>{{$deductions->first()->deduction->description}}</b>
            <table style="width: 100%;">
                <tbody>
                <tr>
                    <td style="width: 12%">Payroll Period:</td>
                    <td style="width: 38%;" class="text-strong">{{$payrollMaster->date}}</td>
                    <td style="width: 12%;">Location:</td>
                    <td class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZ/MIN'}}</td>
                </tr>
                <tr>
                    <td>Payroll Type:</td>
                    <td class="text-strong">{{$payrollMaster->type}}</td>
                    <td>Code:</td>
                    <td class="text-strong">{{$deductionCode}}</td>
                </tr>
                </tbody>
            </table>
            @switch($deductionCode)
                @case('GSIS')
                @case('PHIC')
                @case('HDMF')
                    @include('printables.hru.payroll_preparation.MONTHLY.deduction-register-'.strtolower($deductionCode))
                    @break
                @default
                    @include('printables.hru.payroll_preparation.MONTHLY.deduction-register-default')
                    @break
            @endswitch
            <hr class="page-break no-print">

        @empty
        @endforelse

    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
        $(document).ready(function () {
            let set = 625;
            if ($("#items_table_{{$rand}}").height() < set) {
                let rem = set - $("#items_table_{{$rand}}").height();
                $("#adjuster").css('height', rem)
                // print();
            }
        })
        window.onafterprint = function () {
            @if(\Illuminate\Support\Facades\Request::has('employeeList'))
            window.close();
            @endif
        }
    </script>
@endsection