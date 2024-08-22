@php
    /** @var \App\Models\HRU\PayrollMasterDetails $deduction **/
    $defaultDeductions = $deductions;
@endphp

<table style="width: 100% ; break-after: page" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center" style="width: 60px;">Emp. No</th>
        <th class="text-center">Name</th>
        <th class="text-center" style="width: 80px">Amount</th>
    </tr>
    </thead>
    <tbody>

        @forelse($defaultDeductions as $hdmfDeduction)
            <tr>
                <td>{{$hdmfDeduction->employeePayroll->saved_employee_data['employee_no'] ?? ''}}</td>
                <td>{{$hdmfDeduction->employeePayroll->saved_employee_data['full_name'] ?? ''}}</td>
                <td class="text-right">{{Helper::toNumber($hdmfDeduction->amount ?? null)}}</td>

            </tr>
        @empty
        @endforelse


        <tr class="bg-info">
            <td colspan="2" class="text-strong b-top">TOTAL {{$deductionCode}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($defaultDeductions->sum('amount'))}}</td>
        </tr>

    </tbody>
</table>