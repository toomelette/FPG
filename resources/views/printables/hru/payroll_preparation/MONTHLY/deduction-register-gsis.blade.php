@php
/** @var \App\Models\HRU\PayrollMasterDetails $deduction **/
$gsisDeductions = $deductions;

@endphp
<table style="width: 100% ; break-after: page" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center" style="width: 60px;">Emp. No</th>
        <th class="text-center">Name</th>
        <th class="text-center" style="width: 80px">Basic Pay</th>
        <th class="text-center" style="width: 80px">Per. Share</th>
        <th class="text-center" style="width: 80px">Govt. Share</th>
        <th class="text-center" style="width: 80px">EC Share</th>
    </tr>
    </thead>
    <tbody>
    @php
        $groupedByDepartment = $gsisDeductions->groupBy(function ($ded){
              return Str::beforeLast($ded->employeePayroll->saved_employee_data['department'] ?? null,'-');
            })->sortKeys();
         $monthlyBasicTotals = [];

    @endphp
    @forelse($groupedByDepartment as $department => $gsisDeductions)
        @php
            $monthlyBasicTotals[$department] = 0;
        @endphp
        <tr class="bg-success">
            <td colspan="6" class="text-strong">{{$department}}</td>
        </tr>
        @forelse($gsisDeductions as $gsisDeduction)
            @php
                $monthlyBasic = $gsisDeduction->employeePayroll->saved_employee_data['monthly_basic'] ?? null;
                $monthlyBasicTotals[$department] = $monthlyBasicTotals[$department] + $monthlyBasic;
            @endphp
            <tr>
                <td>{{$gsisDeduction->employeePayroll->saved_employee_data['employee_no'] ?? ''}}</td>
                <td>{{$gsisDeduction->employeePayroll->saved_employee_data['full_name'] ?? ''}}</td>
                <td class="text-right">{{Helper::toNumber($monthlyBasic)}}</td>
                <td class="text-right">{{Helper::toNumber($gsisDeduction->amount ?? null)}}</td>
                <td class="text-right">{{Helper::toNumber($gsisDeduction->govt_share ?? null)}}</td>
                <td class="text-right">{{Helper::toNumber($gsisDeduction->ec_share ?? null)}}</td>
            </tr>
        @empty
        @endforelse
        <tr>
            <td colspan="2" class="text-strong b-top">TOTAL {{$department}} ({{$deductionCode}})</td>
            <td class="text-right text-strong b-top">
                {{Helper::toNumber($monthlyBasicTotals[$department])}}
            </td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('amount'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('govt_share'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('ec_share'))}}</td>
        </tr>
    @empty
    @endforelse
    @php
        $gsisDeductions = $groupedByDepartment->flatten();

     @endphp
        <tr class="bg-info">
            <td colspan="2" class="text-strong b-top">TOTAL {{$deductionCode}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber(array_sum($monthlyBasicTotals))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('amount'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('govt_share'))}}</td>
            <td class="text-right text-strong b-top">{{Helper::toNumber($gsisDeductions->sum('ec_share'))}}</td>
        </tr>

    </tbody>
</table>