@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        table>thead>tr>th{
            border: 1px solid black;
        }
    </style>
    <div style="font-family: Cambria">
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
                    ->where('sundry_account','=',0)
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

            $colspan = 6 + $chunkedIncentives->count() + $chunkedDeductions->count();
            $sumGrand = [];
            $sumGrandSundry = [];
            $sumGrand['pay15'] = null;
            $sumGrand['pay30'] = null;

            $recap = [];
        @endphp
        <div style="break-after: page">

            @foreach($tree as $group => $rcs)

            <table style="width: 100%" class=" tbl-padded">
                <thead>

                <tr>
                    <th style="width: 25%; padding: 0; border: none"></th>
                    @foreach($chunkedIncentives as $grp)
                        <th style="padding: 0; border: none"></th>
                    @endforeach
                    @foreach($chunkedDeductions as $grp)
                        <th style="padding: 0; border: none"></th>
                    @endforeach
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 7%""></th>
                    <th style="padding: 0; border: none;width: 8%"></th>
                    <th style="padding: 0; border: none;width: 4%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                </tr>

                <tr>
                    <td colspan="{{$colspan}}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 15%;">
                                    <p class="no-margin text-strong">GENERAL PAYROLL - REGULAR</p>
                                </td>
                                <td class="text-center">
                                    <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                    <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                                </td>
                                <td style="width: 15%;">
                                    STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                    DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                    TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th rowspan="2">
                        Name of Employee
                    </th>
                    @foreach($chunkedIncentives as $grp)
                        <th rowspan="2" class="text-center">
                            @foreach($grp as $incentive)
                                {{$incentive}} {{$loop->last ? '':'/'}} <br>
                            @endforeach
                        </th>
                    @endforeach
                    @foreach($chunkedDeductions as $grp)
                        <th rowspan="2" class="text-center">
                            @foreach($grp as $deduction)
                                {{$deduction}} {{$loop->last ? '':'/'}} <br>
                            @endforeach
                        </th>
                    @endforeach
                    <th colspan="2" class="text-center">SUNDRIES</th>
                    <th rowspan="2" class="text-center">Take Home Pay</th>
                    <th rowspan="2" class="text-center">15th 30th</th>
                    <th rowspan="2" class="text-center">Signature</th>
                </tr>
                <tr>
                    <th class="text-center">ACCT. CODE</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
                </thead>
                <tbody>



                @php
                    $sumPerGroup = [];
                    $sumPerGroupSundry = [];
                    $sumPerGroup['pay15'] = null;
                    $sumPerGroup['pay30'] = null;
                @endphp
                <tr>
                    <td colspan="{{$colspan}}" class="text-strong" style="background-color: #f0ffef">{{$group}}</td>
                </tr>
                @forelse($rcs as $rcCode => $rc)
                    <tr>
                        <td colspan="{{$colspan}}" class="indent text-strong" style="background-color: #e6f8ff">{{$rc->first()->responsibilityCenter->desc ?? ''}}</td>
                    </tr>
                    @php

                        $payrollEmployeesPerRc = $payrollEmployeesGroupedByRespCenter[$rcCode] ?? [];
                        $sumPerRc = [];
                        $sumPerRcSundry = [];
                    @endphp
                    @if(!empty($payrollEmployeesPerRc))
                        @forelse($payrollEmployeesPerRc as $payrollEmployee /** @var App\Models\HRU\PayrollMasterEmployees $payrollEmployee **/)
                            <tr>
                                <td>
                                    <span class="text-strong">{{$payrollEmployee->saved_employee_data['full_name'] ?? ''}}</span> <br>
                                    {{$payrollEmployee->saved_employee_data['position'] ?? ''}} <br>
                                    {{$payrollEmployee->saved_employee_data['employee_no'] ?? ''}} <span>({{$payrollEmployee->saved_employee_data['salary_grade'] ?? ''}} , {{$payrollEmployee->saved_employee_data['step_inc'] ?? ''}})</span>
                                </td>
                                @foreach($chunkedIncentives as $grp)
                                    <td class="text-right text-top">
                                        @foreach($grp as $incentive)
                                            {{Helper::toNumber($amt = $payrollEmployee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null)}}<br>
                                            @php
                                                //include to totals per RC
                                                if(isset($sumPerRc[$incentive])){
                                                    $sumPerRc[$incentive] = $sumPerRc[$incentive] + $amt;
                                                }else{
                                                    $sumPerRc[$incentive] = $amt;
                                                }
                                            @endphp
                                        @endforeach
                                    </td>
                                @endforeach
                                @foreach($chunkedDeductions as $grp)
                                    <td class="text-right text-top">
                                        @foreach($grp as $deduction)
                                            {{Helper::toNumber($amt = $payrollEmployee->employeePayrollDetails->where('code',$deduction)->first()->amount ?? null)}}<br>
                                            @php
                                                //include to totals per RC
                                                if(isset($sumPerRc[$deduction])){
                                                    $sumPerRc[$deduction] = $sumPerRc[$deduction] + $amt;
                                                }else{
                                                    $sumPerRc[$deduction] = $amt;
                                                }
                                            @endphp
                                        @endforeach
                                    </td>
                                @endforeach
                                <td class="text-left text-top">
                                @forelse($payrollEmployee->employeePayrollDetails->sortBy('code')->where('sundry_account',1) as $sundry)
                                        {{$sundry->code}} <br>
                                        @php
                                            if(!isset($sumPerRcSundry[$sundry->code])){
                                                $sumPerRcSundry[$sundry->code] = null;
                                            }
                                        @endphp
                                @empty

                                @endforelse
                                </td>

                                <td class="text-right text-top">
                                    @forelse($payrollEmployee->employeePayrollDetails->sortBy('code')->where('sundry_account',1) as $sundry)
                                        {{Helper::toNumber($amt = $sundry->amount)}} <br>
                                        @php
                                            $sumPerRcSundry[$sundry->code] = $sumPerRcSundry[$sundry->code] + $amt;
                                        @endphp
                                    @empty

                                    @endforelse
                                </td>
                                <td class="text-right text-top text-strong">
                                    {{Helper::toNumber($payrollEmployee->pay15)}} <br>
                                    {{Helper::toNumber($payrollEmployee->pay30)}} <br>
                                    {{Helper::toNumber($payrollEmployee->pay15 + $payrollEmployee->pay30)}}
                                </td>
                                <td class="text-left text-top">
                                    15TH <br>
                                    30TH <br>
                                    TOTAL
                                </td>
                                <td class="text-left text-top">
                                    _________________________ <br>
                                    _________________________
                                </td>
                            </tr>
                        @empty
                        @endforelse

                        {{--TOTALS PER RC FOOTER--}}
                        <tr>
                            <td class="indent b-top text-strong">TOTAL {{$rc->first()->responsibilityCenter->desc ?? ''}}</td>

                            @foreach($chunkedIncentives as $grp)
                                <td class="text-right text-top b-top">
                                    @foreach($grp as $incentive)
                                        {{Helper::toNumber( $amtRc = $sumPerRc[$incentive])}} <br>
                                        @php
                                            if(isset($sumPerGroup[$incentive])){
                                                $sumPerGroup[$incentive] = $sumPerGroup[$incentive] + $amtRc;
                                            }else{
                                                $sumPerGroup[$incentive] = $amtRc;
                                            }
                                        @endphp
                                    @endforeach
                                </td>
                            @endforeach

                            @foreach($chunkedDeductions as $grp)
                                <td class="text-right text-top b-top">
                                    @foreach($grp as $deduction)
                                        {{Helper::toNumber($amtRc = $sumPerRc[$deduction])}} <br>
                                        @php
                                            if(isset($sumPerGroup[$deduction])){
                                                $sumPerGroup[$deduction] = $sumPerGroup[$deduction] + $amtRc;
                                            }else{
                                                $sumPerGroup[$deduction] = $amtRc;
                                            }
                                        @endphp
                                    @endforeach
                                </td>
                            @endforeach
                            <td class="text-top text-left b-top">
                                @forelse($sumPerRcSundry as $sundryCode => $sumPerRcSundryItem)
                                    {{$sundryCode}} <br>
                                    @php
                                        if(!isset($sumPerGroupSundry[$sundryCode])){
                                            $sumPerGroupSundry[$sundryCode] = null;
                                        }
                                    @endphp
                                @empty
                                @endforelse
                            </td>
                            <td class="text-top text-right b-top">
                                @forelse($sumPerRcSundry as $sundryCode => $sumPerRcSundryItem)
                                    {{Helper::toNumber($amtRc = $sumPerRcSundryItem)}} <br>
                                    @php
                                        $sumPerGroupSundry[$sundryCode] = $sumPerGroupSundry[$sundryCode] + $amtRc;
                                    @endphp
                                @empty
                                @endforelse
                            </td>
                            <td class="text-top text-right text-strong b-top">
                                {{Helper::toNumber($rc15 = $payrollEmployeesPerRc->sum('pay15'))}} <br>
                                {{Helper::toNumber($rc30 = $payrollEmployeesPerRc->sum('pay30'))}} <br>
                                {{Helper::toNumber($rc15 + $rc30)}}
                                @php
                                    $sumPerGroup['pay15'] = $sumPerGroup['pay15'] + $rc15;
                                    $sumPerGroup['pay30'] = $sumPerGroup['pay30'] + $rc30;
                                @endphp
                            </td>
                            <td class=""></td>
                            <td class=""></td>
                        </tr>
                    @endif
                @empty
                @endforelse

                {{-- TOTALS PER GROUP --}}
                <tr class="text-strong">
                    <td class="b-top">TOTAL {{$group}}</td>

                    @foreach($chunkedIncentives as $grp)
                        <td class="text-right text-top b-top">
                            @foreach($grp as $incentive)
                                {{Helper::toNumber($amtGroup = $sumPerGroup[$incentive])}} <br>
                                @php
                                    if(isset($sumGrand[$incentive])){
                                        $sumGrand[$incentive] = $sumGrand[$incentive] + $amtGroup;
                                    }else{
                                        $sumGrand[$incentive] = $amtGroup;
                                    }

                                    if(isset($recap[$group][$incentive])){
                                        $recap[$group][$incentive] = $recap[$group][$incentive] + $amtGroup;
                                    }else{
                                        $recap[$group][$incentive] = $amtGroup;
                                    }
                                @endphp
                            @endforeach
                        </td>
                    @endforeach

                    @foreach($chunkedDeductions as $grp)
                        <td class="text-right text-top b-top">
                            @foreach($grp as $deduction)
                                {{Helper::toNumber($amtGroup = $sumPerGroup[$deduction])}} <br>
                                @php
                                    if(isset($sumGrand[$deduction])){
                                        $sumGrand[$deduction] = $sumGrand[$deduction] + $amtGroup;
                                    }else{
                                        $sumGrand[$deduction] = $amtGroup;
                                    }
                                @endphp
                            @endforeach

                        </td>
                    @endforeach

                    @php
                        ksort($sumPerGroupSundry);
                    @endphp

                    <td class="text-top text-left b-top">
                        @forelse($sumPerGroupSundry as $sundryCode => $sumPerGroupSundryItem)
                            {{$sundryCode}} <br>
                            @php
                                if(!isset($sumGrandSundry[$sundryCode])){
                                    $sumGrandSundry[$sundryCode] = null;
                                }
                            @endphp
                        @empty
                        @endforelse
                    </td>
                    <td class="text-top text-right text-top b-top">
                        @forelse($sumPerGroupSundry as $sundryCode => $sumPerGroupSundryItem)
                            {{Helper::toNumber($amtGrand = $sumPerGroupSundryItem)}} <br>
                            @php
                                $sumGrandSundry[$sundryCode] = $sumGrandSundry[$sundryCode] + $amtGrand;
                            @endphp
                        @empty
                        @endforelse
                    </td>
                    <td class="text-strong text-right text-top b-top">
                        {{Helper::toNumber($group15 = $sumPerGroup['pay15'])}} <br>
                        {{Helper::toNumber($group30 = $sumPerGroup['pay30'])}} <br>
                        {{Helper::toNumber($group15 + $group30)}}

                        @php
                            $sumGrand['pay15'] = $sumGrand['pay15'] + $group15;
                            $sumGrand['pay30'] = $sumGrand['pay30'] + $group30;
                        @endphp
                    </td>
                    <td></td>
                    <td style="break-after: page"></td>
                </tr>
                {{-- END TOTALS PER GROUP--}}



                </tbody>
            </table>

            @endforeach

            <table style="width: 100%" class="tbl-padded">
                <thead>
                <tr>
                    <th style="width: 25%; padding: 0; border: none"></th>
                    @foreach($chunkedIncentives as $grp)
                        <th style="padding: 0; border: none"></th>
                    @endforeach
                    @foreach($chunkedDeductions as $grp)
                        <th style="padding: 0; border: none"></th>
                    @endforeach
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 7%""></th>
                    <th style="padding: 0; border: none;width: 8%"></th>
                    <th style="padding: 0; border: none;width: 4%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                </tr>
                <tr>
                    <td colspan="{{$colspan}}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 15%;">
                                    <p class="no-margin text-strong">GENERAL PAYROLL - REGULAR</p>
                                </td>
                                <td class="text-center">
                                    <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                    <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                                </td>
                                <td style="width: 15%;">
                                    STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                    DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                    TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th rowspan="2">
                        Name of Employee
                    </th>
                    @foreach($chunkedIncentives as $grp)
                        <th rowspan="2" class="text-center">
                            @foreach($grp as $incentive)
                                {{$incentive}} {{$loop->last ? '':'/'}} <br>
                            @endforeach
                        </th>
                    @endforeach
                    @foreach($chunkedDeductions as $grp)
                        <th rowspan="2" class="text-center">
                            @foreach($grp as $deduction)
                                {{$deduction}} {{$loop->last ? '':'/'}} <br>
                            @endforeach
                        </th>
                    @endforeach
                    <th colspan="2" class="text-center">SUNDRIES</th>
                    <th rowspan="2" class="text-center">Take Home Pay</th>
                    <th rowspan="2" class="text-center">15th 30th</th>
                    <th rowspan="2" class="text-center">Signature</th>
                </tr>
                <tr>
                    <th class="text-center">ACCT. CODE</th>
                    <th class="text-center">AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td colspan="{{$colspan}}" class="b-bottom"><br></td>
                </tr>
                <tr class="text-strong">
                    <td>
                        GRAND TOTAL
                    </td>
                    @foreach($chunkedIncentives as $grp)
                        <td class="text-right text-top">
                            @foreach($grp as $incentive)
                                {{Helper::toNumber($sumGrand[$incentive])}} <br>
                            @endforeach
                        </td>
                    @endforeach
                    @foreach($chunkedDeductions as $grp)
                        <td class="text-right text-top">
                            @foreach($grp as $deduction)
                                {{Helper::toNumber($sumGrand[$deduction])}} <br>
                            @endforeach
                        </td>
                    @endforeach


                    <td class="text-top text-left">
                        @forelse($sumGrandSundry as $sundryCode => $sumGrandSundryItem)
                            {{$sundryCode}} <br>
                        @empty
                        @endforelse
                    </td>
                    <td class="text-top text-right text-top">
                        @forelse($sumGrandSundry as $sundryCode => $sumGrandSundryItem)
                            {{Helper::toNumber($sumGrandSundryItem)}} <br>
                        @empty
                        @endforelse
                    </td>
                    <td class="text-right text-top text-strong">
                        {{Helper::toNumber($grand15 = $sumGrand['pay15'])}} {{--$payrollMaster->payrollMasterEmployees->sum('pay15')--}} <br>
                        {{Helper::toNumber($grand30 = $sumGrand['pay30'])}} <br>
                        {{Helper::toNumber($totalSalaries = $grand15 + $grand30)}}
                    </td>
                    <td style="color: blue" class="text-top">
                        G.15TH <br>
                        G.30TH <br>
                        G.TOTAL
                    </td>
                </tr>
                </tbody>
            </table>


            {{-- RECAP --}}
            <div style=" break-before: page">

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 15%;">
                            <p class="no-margin text-strong">GENERAL PAYROLL - REGULAR</p>
                        </td>
                        <td class="text-center">
                            <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                            <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                        </td>
                        <td style="width: 15%;">
                            STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                            DEPT:  <span class="text-strong"></span> <br>
                            TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                        </td>
                    </tr>
                </table>
                <br><br>
                <p class="text-center text-strong">RECAP</p>
                <table style="width: 100%;">
                <thead>
                <tr>
                    <th class="text-center text-uppercase">Resp Center</th>
                    <th class="text-center text-uppercase">Account Code</th>
                    <th class="text-center text-uppercase">Account Title</th>
                    <th class="text-center text-uppercase">Debit</th>
                    <th class="text-center text-uppercase">Credit</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $accountCodeToCode = $payrollMaster->hmtDetails->mapWithKeys(function ($data){
                        return [
                            $data->account_code => $data,
                        ];
                    });
                    $codeToAccountCode = $payrollMaster->hmtDetails->mapWithKeys(function ($data){
                        return [
                            $data->code => $data,
                        ];
                    });

                    $recapDeductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->groupBy('account_code');
                    $recap['debit'] = null;
                    $recap['credit'] = null;
                @endphp

                @foreach($groupedIncentives as $incentive)
                    @foreach($tree as $group => $rcs)
                    <tr>
                        <td>{{$group}}</td>
                        <td>{{$acctCode = $codeToAccountCode[$incentive]->account_code ?? ''}}</td>
                        <td>{{$acctCode = $codeToAccountCode[$incentive]->chartOfAccount->account_title ?? ''}}</td>
                        <td class="text-right">{{Helper::toNumber($debit = $recap[$group][$incentive] ?? null)}}</td>
                        <td></td>
                        @php
                            $recap['debit'] = $recap['debit'] + $debit;
                        @endphp
                    </tr>
                    @endforeach
                @endforeach
                @foreach($recapDeductions as $deductionCode => $deductions)
                    <tr>
                        <td></td>
                        <td>{{$acctCode = $accountCodeToCode[$deductionCode]->account_code ?? ''}}</td>
                        <td>{{$acctCode = $accountCodeToCode[$deductionCode]->chartOfAccount->account_title ?? ''}}</td>
                        <td></td>
                        <td class="text-right">
                            @if(!empty($accountCodeToCode[$deductionCode]->account_code))
                            {{Helper::toNumber($credit = $payrollMaster->hmtDetails->where('account_code',$accountCodeToCode[$deductionCode]->account_code)->sum('amount') ?? null)}}
                            @else
                            @endif
                        </td>
                        @php
                            $recap['credit'] = $recap['credit'] + ($credit ?? null);
                        @endphp
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td>{{$payrollMaster->account_code ?? 'ACCT CODE NOT ASSIGNED'}}</td>
                        <td>{{$payrollMaster->chartOfAccounts->account_title ?? 'ACCT CODE NOT ASSIGNED'}}</td>
                        <td></td>
                        <td class="text-right">{{Helper::toNumber($totalSalaries = $grand15 + $grand30)}}</td>
                        @php
                            $recap['credit'] = $recap['credit'] + $totalSalaries;
                        @endphp
                    </tr>
                    <tr class="text-strong">
                        <td colspan="3" class="b-top">TOTAL</td>
                        <td class="text-right b-top">{{Helper::toNumber($recap['debit'])}}</td>
                        <td class="text-right b-top">{{Helper::toNumber($recap['credit'])}}</td>
                    </tr>
                </tbody>
            </table>
            </div>


            <div style="break-before: page">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 15%;">
                            <p class="no-margin text-strong">GENERAL PAYROLL - REGULAR</p>
                        </td>
                        <td class="text-center">
                            <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                            <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                        </td>
                        <td style="width: 15%;">
                            STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                            DEPT:  <span class="text-strong"></span> <br>
                            TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%" class="b-top b-left b-right">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">A</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        CERTIFIED: Services duly rendered as stated.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->a_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->a_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Authorized Official
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="b-top b-right">

                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">C</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        @php
                                            $total = $recap['debit'];
                                        @endphp
                                        APPROVED FOR PAYMENT:
                                        {{strtoupper(\Illuminate\Support\Number::spell(floor($total)))}} PESOS
                                        @if($total - floor($total) != 0)
                                            AND {{strtoupper(\Illuminate\Support\Number::spell(round($total - floor($total), 2) * 100))}} CENTAVOS
                                        @endif
                                        ONLY
                                        (₱ {{Helper::toNumber($total)}})
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->c_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->c_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Head of the Agency/Authorized Representative
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td class="b-top b-left b-right b-bottom">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">B</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        CERTIFIED: Supporting documents complete; and cash
                                        available in the amount of ₱ {{Helper::toNumber($total)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->b_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->b_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Head, Accounting Unit
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td class="b-top b-right b-bottom">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">D</td>
                                    <td style="padding-left: 10px; width: 70%; ; padding-right: 10px" class="text-strong">
                                        CERTIFIED: Each employee whose name appears above has been
                                        paid the amount indicated opposite his/her name,
                                    </td>
                                    <td class="b-left" style="padding-left: 10px"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px; padding-right: 10px" class="text-center text-bottom">
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 65%;">
                                                    <p class="no-margin text-strong text-center">{{$payrollMaster->d_name}}</p>
                                                    <p class="no-margin text-center">{{$payrollMaster->d_position}}</p>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="b-top text-center">
                                                    Disbursing Officer
                                                </td>
                                                <td class="b-top text-center">
                                                    Date
                                                </td>
                                            </tr>
                                        </table>


                                    </td>
                                    <td class="b-left" style="padding-left: 10px">
                                        JEV NO. ____________ <br>
                                        DATE _______________
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="b-left" style="padding-left: 10px"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

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
                    // window.close();
                }
            </script>
@endsection