@php
    $chunkBy = 3;
    $groupedIncentives= $payrollMaster->hmtDetails
            ->where('type','INCENTIVE')
            ->sortBy(function($data){
                if($data->priority == null){
                    return 100000;
                }else{
                    return $data->priority;
                }
            })
           ->mapWithKeys(function ($data){
               return [
                   $data->code => \Illuminate\Support\Str::random(),
               ];
           })
           ->flip()->values();

    $chunkedIncentives = $groupedIncentives->chunk($chunkBy);
    $groupedDeductions = $payrollMaster->hmtDetails
            ->where('type','DEDUCTION')
            ->sortBy(function($data){
                if($data->priority == null){
                    return 100000;
                }else{
                    return $data->priority;
                }
            })->mapWithKeys(function ($data){
               return [
                   $data->code => \Illuminate\Support\Str::random(),
               ];
           })
           ->flip()->values();
    $chunkedDeductions = $groupedDeductions->chunk($chunkBy);

    $colspan = 6 + $groupedIncentives->count() + $groupedDeductions->count();
    $sumGrand = [];
    $sumGrandSundry = [];
    $sumGrand['pay15'] = null;
    $sumGrand['pay30'] = null;

    $recap = [];
@endphp
<table style="width: 100%" class="tbl-padded">
    <thead>


    <tr>
        <th >
            Name of Employee
        </th>
        <th>Position</th>
        @foreach($groupedIncentives as $incentive)
            <th>{{$incentive}}</th>
        @endforeach
        @foreach($groupedDeductions as $deduction)
            <th>{{$deduction}}</th>
        @endforeach
        <th class="text-center">15th</th>
        <th class="text-center">30th</th>
        <th class="text-center">Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tree as $group => $rcs)
        @forelse($rcs as $rcCode => $rc)
            @php

                $payrollEmployeesPerRc = $payrollEmployeesGroupedByRespCenter[$rcCode] ?? [];
                $sumPerRc = [];
                $sumPerRcSundry = [];
            @endphp
            @if(!empty($payrollEmployeesPerRc))
                <tr>
                    <td colspan="{{$colspan}}" class="indent text-strong" style="background-color: #e6f8ff">{{$rc->first()->responsibilityCenter->desc ?? ''}}</td>
                </tr>
                @forelse($payrollEmployeesPerRc as $payrollEmployee /** @var App\Models\HRU\PayrollMasterEmployees $payrollEmployee **/)
                    <tr>
                        <td>
                            {{$payrollEmployee->saved_employee_data['full_name'] ?? ''}}
{{--                            <span class="text-strong"></span> <br>--}}
{{--                            {{$payrollEmployee->saved_employee_data['employee_no'] ?? ''}} <span>({{$payrollEmployee->saved_employee_data['salary_grade'] ?? ''}} , {{$payrollEmployee->saved_employee_data['step_inc'] ?? ''}})</span>--}}
                        </td>
                        <td>
                            {{$payrollEmployee->saved_employee_data['position'] ?? ''}}
                        </td>

                        @foreach($groupedIncentives as $incentive)
                        <td class="text-right text-top">

                                {{Helper::toNumber($amt = $payrollEmployee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null)}}<br>
                                @php
                                    //include to totals per RC
                                    if(isset($sumPerRc[$incentive])){
                                        $sumPerRc[$incentive] = $sumPerRc[$incentive] + $amt;
                                    }else{
                                        $sumPerRc[$incentive] = $amt;
                                    }
                                @endphp

                        </td>
                        @endforeach


                        @foreach($groupedDeductions as $deduction)
                        <td class="text-right text-top">

                                {{Helper::toNumber($amt = $payrollEmployee->employeePayrollDetails->where('code',$deduction)->first()->amount ?? null)}}<br>
                                @php
                                    //include to totals per RC
                                    if(isset($sumPerRc[$deduction])){
                                        $sumPerRc[$deduction] = $sumPerRc[$deduction] + $amt;
                                    }else{
                                        $sumPerRc[$deduction] = $amt;
                                    }
                                @endphp

                        </td>
                        @endforeach

                        <td class="text-right text-top text-strong">
                            {{Helper::toNumber($payrollEmployee->pay15)}}
                        </td>
                        <td class="text-right text-top text-strong">
                            {{Helper::toNumber($payrollEmployee->pay30)}}
                        </td>
                        <td class="text-right text-top text-strong">
                            {{Helper::toNumber($payrollEmployee->pay15 + $payrollEmployee->pay30)}}
                        </td>
                    </tr>
                @empty
                @endforelse

                {{--TOTALS PER RC FOOTER--}}
                <tr>
                    <td class="indent b-top text-strong">TOTAL {{$rc->first()->responsibilityCenter->desc ?? ''}}</td>

                    @foreach($groupedIncentives as $incentive)
                    <td class="text-right text-top b-top">

                            {{Helper::toNumber( $amtRc = $sumPerRc[$incentive])}} <br>
                            @php
                                if(isset($sumPerGroup[$incentive])){
                                    $sumPerGroup[$incentive] = $sumPerGroup[$incentive] + $amtRc;
                                }else{
                                    $sumPerGroup[$incentive] = $amtRc;
                                }
                            @endphp

                    </td>
                    @endforeach


                    @foreach($groupedDeductions as $deduction)
                    <td class="text-right text-top b-top">

                            {{Helper::toNumber($amtRc = $sumPerRc[$deduction])}} <br>
                            @php
                                if(isset($sumPerGroup[$deduction])){
                                    $sumPerGroup[$deduction] = $sumPerGroup[$deduction] + $amtRc;
                                }else{
                                    $sumPerGroup[$deduction] = $amtRc;
                                }
                            @endphp
                    </td>
                    @endforeach

                    <td class="text-top text-right text-strong b-top">
                        {{Helper::toNumber($rc15 = $payrollEmployeesPerRc->sum('pay15'))}} <br>
                    </td>
                    <td class=""> {{Helper::toNumber($rc30 = $payrollEmployeesPerRc->sum('pay30'))}} </td>
                    <td class="">{{Helper::toNumber($rc15 + $rc30)}}</td>
                </tr>
            @endif
        @empty
        @endforelse
    @endforeach
    </tbody>
</table>