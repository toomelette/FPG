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
            $headerIncentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
            $headerDeductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();

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
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 8%"></th>
                    <th style="padding: 0; border: none;width: 4%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                </tr>

                <tr>
                    <td colspan="{{$colspan}}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">
                                    <p class="no-margin text-strong">GENERAL PAYROLL (YEAR END BONUS & CASH GIFT)- {{implode(', ',\Request::get('payrollGroupsSelected'))}}</p>
                                    <p>PAY PERIOD: {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                    <p class="no-margin">{{\App\Swep\Helpers\Get::headerAddress()}}</p>
                                </td>
                                <td style="width: 20%;">
                                    STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                    DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                    TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th>
                        Name of Employee
                    </th>
                    @forelse($headerIncentives as $headerIncentive)
                        <th class="text-center">
                            {{$headerIncentive}}
                        </th>
                    @empty
                    @endforelse

                    @forelse($headerDeductions as $headerDeduction)
                        <th class="text-center">
                            {{$headerDeduction}}
                        </th>
                    @empty
                    @endforelse
                    <th class="text-center">NET AMOUNT RECEIVED</th>
                    <th class="text-center">Signature</th>
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
                                    <span >{{$payrollEmployee->saved_employee_data['full_name'] ?? ''}}</span> <br>
                                </td>
                                @forelse($headerIncentives as $headerIncentive)
                                    <td class="text-right">
                                        {{Helper::toNumber($payrollEmployee->employeePayrollDetails->where('code',$headerIncentive)?->first()->amount)}}
                                    </td>
                                @empty
                                @endforelse
                                @forelse($headerDeductions as $headerDeduction)
                                    <td class="text-right">
                                        {{Helper::toNumber($payrollEmployee->employeePayrollDetails->where('code',$headerDeduction)?->first()?->amount)}}
                                    </td>
                                @empty
                                @endforelse

                                <td class="text-right text-top text-strong">
                                    {{Helper::toNumber($payrollEmployee->pay15)}}

                                </td>
                                <td class="text-left text-top">
                                    _________________________

                                </td>
                            </tr>
                        @empty
                        @endforelse

                        {{--TOTALS PER RC FOOTER--}}
                        <tr>
                            <td class="indent b-top text-strong">TOTAL {{$rc->first()->responsibilityCenter->desc ?? ''}}</td>

                            @forelse($headerIncentives as $headerIncentive)
                                <td class="text-right b-top">
                                    {{
                                        Helper::toNumber(
                                            $sm = $payrollMaster->payrollMasterEmployees
                                            ->where('saved_employee_data.resp_center',$rc->first()->resp_center)
                                            ->sum(function ($emp) use ($headerIncentive){
                                                return $emp->employeePayrollDetails->where('code',$headerIncentive)->sum('amount');
                                            })
                                        )
                                    }}
                                </td>
                            @empty
                            @endforelse
                            @forelse($headerDeductions as $headerDeduction)

                                <td class="text-right b-top">
                                    {{
                                        Helper::toNumber(
                                            $sm = $payrollMaster->payrollMasterEmployees
                                            ->where('saved_employee_data.resp_center',$rc->first()->resp_center)
                                            ->sum(function ($emp) use ($headerDeduction){
                                                return $emp->employeePayrollDetails->where('code',$headerDeduction)->sum('amount');
                                            })
                                        )
                                    }}
                                </td>
                            @empty
                            @endforelse

                            <td class="text-top text-right text-strong b-top">
                                {{Helper::toNumber($rc15 = $payrollEmployeesPerRc->sum('pay15'))}} <br>

                                @php
                                    $sumPerGroup['pay15'] = $sumPerGroup['pay15'] + $rc15;
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

                    @forelse($headerIncentives as $headerIncentive)
                        <td class="text-right b-top">
                           {{
                                Helper::toNumber(
                                    $sm = $payrollMaster->payrollMasterEmployees
                                    ->whereIn('saved_employee_data.resp_center',$rcs->keys()->toArray())
                                    ->sum(function ($emp) use ($headerIncentive){
                                        return $emp->employeePayrollDetails->where('code',$headerIncentive)->sum('amount');
                                    })
                                )
                            }}
                        </td>
                    @empty
                    @endforelse

                    @forelse($headerDeductions as $headerDeduction)

                        <td class="text-right b-top">
                            {{
                                Helper::toNumber(
                                    $sm = $payrollMaster->payrollMasterEmployees
                                    ->whereIn('saved_employee_data.resp_center',$rcs->keys()->toArray())
                                    ->sum(function ($emp) use ($headerDeduction){
                                        return $emp->employeePayrollDetails->where('code',$headerDeduction)->sum('amount');
                                    })
                                )
                            }}
                        </td>
                    @empty
                    @endforelse

                    <td class="text-strong text-right text-top b-top">
                        {{Helper::toNumber($group15 = $sumPerGroup['pay15'])}} <br>

                        @php
                            $sumGrand['pay15'] = $sumGrand['pay15'] + $group15;
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
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 8%"></th>
                    <th style="padding: 0; border: none;width: 4%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                </tr>
                <tr>
                    <td colspan="{{$colspan}}">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">
                                    <p class="no-margin text-strong">GENERAL PAYROLL (YEAR END BONUS & CASH GIFT)- {{implode(', ',\Request::get('payrollGroupsSelected'))}}</p>
                                    <p>PAY PERIOD: {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
                                </td>
                                <td class="text-center">
                                    <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                    <p class="no-margin">{{\App\Swep\Helpers\Get::headerAddress()}}</p>
                                </td>
                                <td style="width: 20%;">
                                    STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                    DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                    TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollMaster->payrollMasterEmployees->count() }}</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <th>
                        Name of Employee
                    </th>
                    @forelse($headerIncentives as $headerIncentive)
                        <th class="text-center">
                            {{$headerIncentive}}
                        </th>
                    @empty
                    @endforelse

                    @forelse($headerDeductions as $headerDeduction)
                        <th class="text-center">
                            {{$headerDeduction}}
                        </th>
                    @empty
                    @endforelse
                    <th class="text-center">NET AMOUNT RECEIVED</th>
                    <th class="text-center">Signature</th>
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

                    @forelse($headerIncentives as $headerIncentive)
                        <td class="text-right b-top">
                            {{
                                 Helper::toNumber(
                                     $sm = $payrollMaster->payrollMasterEmployees
                                     ->whereIn('saved_employee_data.resp_center',collect($tree)->flatten()->pluck('resp_center')->toArray())
                                     ->sum(function ($emp) use ($headerIncentive){
                                         return $emp->employeePayrollDetails->where('code',$headerIncentive)->sum('amount');
                                     })
                                 )
                             }}
                        </td>
                    @empty
                    @endforelse

                    @forelse($headerDeductions as $headerDeduction)

                        <td class="text-right b-top">
                            {{
                                Helper::toNumber(
                                    $sm = $payrollMaster->payrollMasterEmployees
                                    ->whereIn('saved_employee_data.resp_center',collect($tree)->flatten()->pluck('resp_center')->toArray())
                                    ->sum(function ($emp) use ($headerDeduction){
                                        return $emp->employeePayrollDetails->where('code',$headerDeduction)->sum('amount');
                                    })
                                )
                            }}
                        </td>
                    @empty
                    @endforelse



                    <td class="text-right text-top text-strong">
                        {{
                            Helper::toNumber(
                                $grand15 = $payrollMaster->payrollMasterEmployees
                                ->sum('pay15')
                            )
                        }}
                    </td>
                    <td style="color: blue" class="text-top">

                    </td>
                </tr>
                </tbody>
            </table>
            @php
            $grand30 = 0;
             @endphp

            {{-- RECAP --}}
            <div style=" break-before: page">

                <table style="width: 100%;">
                    <tr>
                        <td style="width: 20%;">
                            <p class="no-margin text-strong">GENERAL PAYROLL (YEAR END BONUS & CASH GIFT)- {{implode(', ',\Request::get('payrollGroupsSelected'))}}</p>
                            <p>PAY PERIOD: {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
                        </td>
                        <td class="text-center">
                            <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                            <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                        </td>
                        <td style="width: 20%;">
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

                    $recapDeductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->mapWithKeys(function ($data){
                        return [
                            $data->account_code ?? $data->code.' ---- NO ACCOUNT CODE ASSIGNED' => $data,
                        ];
                    })->sortKeys();
                    $recap['debit'] = null;
                    $recap['credit'] = null;

                @endphp

                @foreach($groupedIncentives as $incentive)
                    @foreach($tree as $group => $rcs)
                    <tr>
                        <td>{{$group}}</td>
                        <td>{{$acctCode = $codeToAccountCode[$incentive]->account_code ?? ''}}</td>
                        <td>{{$acctCode = $codeToAccountCode[$incentive]->chartOfAccount->account_title ?? ''}}</td>
                        <td class="text-right">
                            {{
                                Helper::toNumber(
                                    $sum = $payrollMaster->payrollMasterEmployees
                                    ->whereIn('saved_employee_data.resp_center',$rcs->keys()->toArray())
                                    ->sum(function ($emp) use ($incentive,$rcs){
                                        return $emp->employeePayrollDetails
                                            ->where('code',$incentive)
                                            ->sum('amount');
                                    })
                                )
                            }}
                        </td>
                        <td></td>
                        @php
                            $recap['debit'] = $recap['debit'] + $sum;
                        @endphp
                    </tr>
                    @endforeach
                @endforeach
                @foreach($recapDeductions as $deductionCode => $deductions)
                    <tr>
                        <td></td>
                        <td>{{$acctCode = $accountCodeToCode[$deductionCode]->account_code ?? $deductionCode}}</td>
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
                        <td style="width: 20%;">
                            <p class="no-margin text-strong">GENERAL PAYROLL (YEAR END BONUS & CASH GIFT)- {{implode(', ',\Request::get('payrollGroupsSelected'))}}</p>
                            <p>PAY PERIOD: {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
                        </td>
                        <td class="text-center">
                            <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                            <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p>
                        </td>
                        <td style="width: 20%;">
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