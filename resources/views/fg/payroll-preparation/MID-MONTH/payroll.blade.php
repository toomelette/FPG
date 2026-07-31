@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        @media print {
            @page {
                size: landscape; /* or portrait */
            }
        }
    </style>
    <div style="font-family: Cambria">
        <div style="font-size: 12px; margin-bottom: 10px">
            <p class="no-margin text-strong">FILPOWER GROUP & MARKETING CORPORATION</p>
            <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
            <p class="no-margin">Pay period: {{Helper::dateFormat($payrollMaster->date_from,'F d')}} to {{Helper::dateFormat($payrollMaster->date_to,'d, Y')}}</p>
        </div>
        @include('fg.payroll-preparation.MID-MONTH.table-payroll-summary')
        <table style="width: 100%; margin-top: 10px">
            <tr>
                <td style="width: 50%;">Prepared by:</td>
                <td colspan="2">Approved by:</td>
            </tr>
            <tr>
                <th style="height: 70px">LGDIAMANTE</th>
                <th>RLBERMEO, JR</th>
                <th>ANTHONY B. GUEVARA</th>
            </tr>
        </table>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        print();
    </script>
@endsection