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
            {{Helper::toNumber($payrollMaster->payrollEmployees->sum('net_pay'))}}
        </th>
    </tr>
    </tbody>
</table>