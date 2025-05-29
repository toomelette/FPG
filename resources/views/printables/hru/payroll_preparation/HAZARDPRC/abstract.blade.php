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

    <div style="font-family: Cambria">
        <div class="clearfix">
            <img src="{{base_path('/public/images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
            <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
            <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
        </div>

        <div style="text-align: left">
            <h3 class="no-margin text-strong" style="font-size: 18px">PAYROLL ABSTRACT - {{$payrollMaster->project_id == 1 ? 'VISAYAS' : 'LUZ/MIN'}} - {{$payrollMaster->type}}</h3>
            <p class="no-margin ">Payroll Date: <b>{{Helper::dateFormat($payrollMaster->date)}}</b> </p>
            <p class="no-margin ">Payroll Type: <b>{{$payrollMaster->type}}</b> </p>
        </div>

        <table style="width: 100%" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center" style="width: 60px;">Emp. No</th>
                <th class="text-center">Name / Position / JG</th>
                <th class="text-center" style="width: 80px">Payroll Amount</th>
                <th class="text-center" style="width: 80px">Total Deductions</th>
                <th class="text-center" style="width: 80px">Salary for the period</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payrollMaster->payrollMasterEmployees as $payrollEmployee)
                <tr>
                    <td class="text-top">{{$payrollEmployee->saved_employee_data['employee_no'] ?? ''}}</td>
                    <td>
                        <span class="text-strong">{{$payrollEmployee->saved_employee_data['full_name'] ?? ''}}</span> <br>
                        {{$payrollEmployee->saved_employee_data['position'] ?? ''}} ({{$payrollEmployee->saved_employee_data['salary_grade'] ?? ''}} , {{$payrollEmployee->saved_employee_data['step_inc'] ?? ''}})
                    </td>
                    <td class="text-right text-top">
                        {{Helper::toNumber($payrollEmployee->hazardprc_gross ?? null)}}
                    </td>
                    <td class="text-right text-top">
{{--                        {{-- Ineligible Days / All Days * GROSS + Tax --}}
                        {{Helper::toNumber($deduction = $payrollEmployee->hazardprc_ineligible_days/$payrollEmployee->hazardprc_all_days * $payrollEmployee->hazardprc_gross + $payrollEmployee->hazardprc_tax ?? null)}}
                    </td>
                    <td class="text-right text-top">
                        {{Helper::toNumber($payrollEmployee->hazardprc_net_amount ?? null,2)}}
                    </td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="b-top">TOTAL</th>
                <th class="b-top">{{$employeesCount = $payrollMaster->payrollMasterEmployees->count()}} {{Str::plural('Employee',$employeesCount)}}</th>
                <th class="text-right b-top">
                    {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('hazardprc_gross') ?? null)}}
                </th>
                <th class="text-right b-top">
                    {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum(function ($payrollEmployee){
                        return $payrollEmployee->hazardprc_ineligible_days/$payrollEmployee->hazardprc_all_days * $payrollEmployee->hazardprc_gross + $payrollEmployee->hazardprc_tax;
                    }) ?? null)}}
                </th>
                <th class="text-right b-top">
                    {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('hazardprc_net_amount') ?? null)}}
                </th>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        // print();
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