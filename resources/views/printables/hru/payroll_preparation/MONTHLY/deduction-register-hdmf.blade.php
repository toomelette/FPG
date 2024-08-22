@php
    /** @var \App\Models\HRU\PayrollMasterDetails $deduction **/
    $hdmfDeductions = $deductions;
@endphp

<table style="width: 100% ; break-after: page" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center" style="width: 60px;">Emp. No</th>
        <th class="text-center">Name</th>
        <th class="text-center" style="width: 80px">Amount</th>
        <th class="text-center" style="width: 80px">Govt. Share</th>
    </tr>
    </thead>
    <tbody>
    @php
        $groupedByDepartment = $hdmfDeductions->groupBy(function ($ded){
              return Str::beforeLast($ded->employeePayroll->saved_employee_data['department'],'-');
            })->sortKeys();
    @endphp
    @forelse($groupedByDepartment as $department => $hdmfDeductions)

        <tr class="bg-success">
            <td colspan="4" class="text-strong">{{$department}}</td>
        </tr>
        @forelse($hdmfDeductions as $hdmfDeduction)
            <tr>
                <td>{{$hdmfDeduction->employeePayroll->saved_employee_data['employee_no'] ?? ''}}</td>
                <td>{{$hdmfDeduction->employeePayroll->saved_employee_data['full_name'] ?? ''}}</td>
                <td class="text-right">{{Helper::toNumber($hdmfDeduction->amount ?? null)}}</td>
                <td class="text-right">{{Helper::toNumber($hdmfDeduction->govt_share ?? null)}}</td>

            </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="2" class="text-strong b-top">TOTAL {{$department}} ({{$deductionCode}})</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($hdmfDeductions->sum('amount'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($hdmfDeductions->sum('govt_share'))}}</td>
        </tr>
    @empty
    @endforelse
    @php
        $hdmfDeductions = $groupedByDepartment->flatten();

    @endphp
    <tr class="bg-info">
        <td colspan="2" class="text-strong b-top">TOTAL {{$deductionCode}}</td>
        <td class="text-right text-strong b-top">{{Helper::toNumber($hdmfDeductions->sum('amount'))}}</td>
        <td class="text-right text-strong b-top">{{Helper::toNumber($hdmfDeductions->sum('govt_share'))}}</td>
    </tr>

    </tbody>
</table>