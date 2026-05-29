@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        @media print {
            @page {
                size: landscape; /* or portrait */
            }
        }
    </style>
    @php
        $tdFirstWidth = 15;
        $tdLastWidth = 10;
        $headers = $incentivesUsed->count() + $deductionsUsed->count();
        $eachWidth = (100 - $tdFirstWidth - $tdLastWidth) / $headers;

    @endphp
    <div style="font-family: Cambria">
        <div style="font-size: 12px; margin-bottom: 10px">
            <p class="no-margin text-strong">FILPOWER GROUP & MARKETING CORPORATION</p>
            <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
            <p class="no-margin">Pay period: {{Helper::dateFormat($payrollMaster->date_from,'F d')}} to {{Helper::dateFormat($payrollMaster->date_to,'d, Y')}}</p>
        </div>
        <table style="width: 100%; font-size: 10px" class="tbl-bordered tbl-padded">
            <thead>
            <tr>
                <th>NAME OF EMPLOYEE</th>
                @forelse($incentivesUsed as $incentiveUsed)
                    <th class="text-center" style="width: {{$eachWidth}}%;">{{$incentiveUsed}}</th>
                @empty
                @endforelse
                @forelse($deductionsUsed as $deductionUsed)
                    <th class="text-center" style="width: {{$eachWidth}}%;">{{$deductionUsed}}</th>
                @empty
                @endforelse
                <th class="text-center">NET PAY</th>
            </tr>
            </thead>
            <tbody>
                @forelse($payrollMaster->payrollEmployees as $payrollEmployee)
                    <tr>
                        <td>
                            {{$payrollEmployee->saved_data['lastname'] ?? ''}}, {{$payrollEmployee->saved_data['firstname'] ?? ''}}

                        </td>
                        @forelse($incentivesUsed as $incentiveUsed)
                            <td class="text-right">{{Helper::toNumber($payrollEmployee->employeeAdjustments->firstWhere('code','=',$incentiveUsed)->amount)}}</td>
                        @empty
                        @endforelse
                        @forelse($deductionsUsed as $deductionUsed)
                            <td class="text-right">{{Helper::toNumber($payrollEmployee->employeeAdjustments->firstWhere('code','=',$deductionUsed)->amount)}}</td>
                        @empty
                        @endforelse
                        <td class="text-right">{{number_format($payrollEmployee->net_pay,2)}}</td>
                    </tr>
                @empty
                @endforelse
            <tr>
                <th>Total</th>
                @forelse($incentivesUsed as $incentiveUsed)
                    <th class="text-right">{{Helper::toNumber($payrollMaster->employeeAdjustments->where('code',$incentiveUsed)->sum('amount'))}}</th>
                @empty
                @endforelse
                @forelse($deductionsUsed as $deductionUsed)
                    <th class="text-right">{{Helper::toNumber($payrollMaster->employeeAdjustments->where('code',$deductionUsed)->sum('amount'))}}</th>
                @empty
                @endforelse
                <th class="text-right">
                    {{number_format($payrollMaster->payrollEmployees->sum('net_pay'),2)}}
                </th>
            </tr>
            </tbody>
        </table>
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