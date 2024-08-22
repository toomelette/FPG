@php
    /** @var \App\Models\HRU\PayrollMasterDetails $deduction **/
    $phicDeductions = $deductions;
@endphp
<table style="width: 100% ; break-after: page" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center" style="width: 60px;">Emp. No</th>
        <th class="text-center">Name</th>
        <th class="text-center" style="width: 80px">Basic Pay</th>
        <th class="text-center" style="width: 80px">Per. Share</th>
        <th class="text-center" style="width: 80px">Govt. Share</th>
    </tr>
    </thead>
    <tbody>
    @php
        $groupedByDepartment = $phicDeductions->groupBy(function ($ded){
              return Str::beforeLast($ded->employeePayroll->saved_employee_data['department'],'-');
            })->sortKeys();
         $monthlyBasicTotals = [];
    @endphp
    @forelse($groupedByDepartment as $department => $phicDeductions)
        @php
            $monthlyBasicTotals[$department] = 0;
        @endphp
        <tr class="bg-success">
            <td colspan="5" class="text-strong">{{$department}}</td>
        </tr>
        @forelse($phicDeductions as $phicDeduction)
            @php
                $monthlyBasic = $phicDeduction->employeePayroll->saved_employee_data['monthly_basic'] ?? null;
                $monthlyBasicTotals[$department] = $monthlyBasicTotals[$department] + $monthlyBasic;
            @endphp
            <tr>
                <td>{{$phicDeduction->employeePayroll->saved_employee_data['employee_no'] ?? ''}}</td>
                <td>{{$phicDeduction->employeePayroll->saved_employee_data['full_name'] ?? ''}}</td>
                <td class="text-right">{{Helper::toNumber($monthlyBasic)}}</td>
                <td class="text-right">{{Helper::toNumber($phicDeduction->amount ?? null)}}</td>
                <td class="text-right">{{Helper::toNumber($phicDeduction->govt_share ?? null)}}</td>
            </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="2" class="text-strong b-top">TOTAL {{$department}} ({{$deductionCode}})</td>
            <td class="text-right text-strong b-top">
                {{Helper::toNumber($monthlyBasicTotals[$department])}}
            </td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($phicDeductions->sum('amount'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($phicDeductions->sum('govt_share'))}}</td>
        </tr>
    @empty
    @endforelse
    @php
        $phicDeductions = $groupedByDepartment->flatten();

    @endphp
    <tr class="bg-info">
        <td colspan="2" class="text-strong b-top">TOTAL {{$deductionCode}}</td>
        <td class="text-right text-strong b-top">{{Helper::toNumber(array_sum($monthlyBasicTotals))}}</td>
        <td class="text-right text-strong b-top">{{Helper::toNumber($phicDeductions->sum('amount'))}}</td>
        <td class="text-right text-strong b-top">{{Helper::toNumber($phicDeductions->sum('govt_share'))}}</td>
    </tr>

    </tbody>
</table>