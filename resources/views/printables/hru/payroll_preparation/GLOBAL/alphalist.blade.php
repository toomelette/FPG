@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria, Caladea">
        <div style="break-after: page">
            <div class="clearfix">
                <img src="{{base_path('/public/images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
                <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
            </div>

            <div style="text-align: left; margin-bottom: 20px">
                <h3 class="no-margin text-strong" style="font-size: 18px">Alphalist - {{$payrollMaster->type}}</h3>
            </div>

            <table style="width: 100%;" class="tbl-padded tbl-bordered-grey">
                <thead>
                <tr>
                    <th style="width: 8px;"></th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">{{$payrollMaster->type}}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($payrollMaster->payrollMasterEmployees as $payrollMasterEmployee)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$payrollMasterEmployee->saved_employee_data['full_name']}}</td>
                        <td class="text-right">{{Helper::toNumber($payrollMasterEmployee->pay15)}}</td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <th colspan="2">TOTAL</th>
                    <th class="text-right">{{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('pay15'))}}</th>
                </tr>
                </tbody>

            </table>
        </div>

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