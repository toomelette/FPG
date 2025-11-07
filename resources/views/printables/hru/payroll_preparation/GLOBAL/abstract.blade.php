@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/

    $grandTotalRata = 0;
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
            <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
            <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
            <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
        </div>

        <div style="text-align: left">
            <h3 class="no-margin text-strong" style="font-size: 18px">PAYROLL ABSTRACT - {{$payrollMaster->project_id == 1 ? 'VISAYAS' : 'LUZ/MIN'}} - MONTH END</h3>
            <p class="no-margin ">Payroll Date: <b>{{Helper::dateFormat($payrollMaster->date,'F Y')}}</b> </p>
            <p class="no-margin ">Payroll Type: <b>{{$payrollMaster->type}}</b> </p>
        </div>

        <table style="width: 100%" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center" style="width: 60px;">Emp. No</th>
                <th class="text-center">Name / Position / JG</th>
                <th class="text-center" style="width: 90px">Payroll Amount</th>
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
                        <span class="small">{{$payrollEmployee->saved_employee_data['position'] ?? ''}}</span> ({{$payrollEmployee->saved_employee_data['salary_grade'] ?? ''}} , {{$payrollEmployee->saved_employee_data['step_inc'] ?? ''}})
                    </td>
                    <td class="text-right text-top" >
                        {{Helper::toNumber($inc = $payrollEmployee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount'))}}

                    </td>
                    <td class="text-right text-top">

                        {{Helper::toNumber($ded = $payrollEmployee->employeePayrollDetails->where('type','DEDUCTION')->sum('amount'))}}
                    </td>

                    <td class="text-right text-top">
                        {{Helper::toNumber($inc - $ded)}}
                    </td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="text-top b-top">TOTAL</th>
                <th class="text-top b-top">{{$employeesCount = $payrollMaster->payrollMasterEmployees->count()}} {{Str::plural('Employee',$employeesCount)}}</th>
                <th class="text-top text-right b-top">
                    {{Helper::toNumber($totalInc = $payrollMaster->payrollMasterEmployees->sum(function ($payrollEmployee){
                        return $payrollEmployee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount');
                    }))}}
                </th>
                <th class="text-top text-right b-top">
                    {{Helper::toNumber($totalDed = $payrollMaster->payrollMasterEmployees->sum(function ($payrollEmployee){
                        return $payrollEmployee->employeePayrollDetails->where('type','DEDUCTION')->sum('amount');
                    }))}}
                </th>

                <th class="text-top text-right b-top">
                    {{Helper::toNumber($totalInc - $totalDed)}}
                </th>
            </tr>
            </tbody>
        </table>
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