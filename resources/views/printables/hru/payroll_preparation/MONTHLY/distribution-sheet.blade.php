@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
{{--    @dd($payrollMaster->hmtDetails->first())--}}
    @php
        $respCodes = \App\Swep\Helpers\Arrays::respCodeList();
        $usedIncentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->groupBy('code')->keys();
        $usedDeductionsAll = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
        $chunkedUsedDeductions = $usedDeductionsAll->chunk(5);
    @endphp

    <div style="font-family: Cambria; font-size: 16px">
        <div style="break-after: page">
            <div class="clearfix">
                <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
                <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
            </div>

            <div style="text-align: left">
                <h3 class="no-margin text-strong" style="font-size: 18px">DISTRIBUTION SHEET</h3>
                <p class="no-margin "><b>{{Carbon::parse($payrollMaster->date)->format('F Y')}}</b></p>
            </div>

            <table style="width: 100%; font-size: 14px" class="tbl-padded tbl-bordered">
                <thead>
                <tr>
                    <th class="text-center">Unit</th>
                    @foreach($usedIncentives as $usedIncentive)
                        <th class="text-center" style="width: 20%">{{$usedIncentive}}</th>
                    @endforeach
                    <th class="text-center" style="width: 20%">TOTAL</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tree as $dept => $rcs)
                    @php
                        $rcsArray = $rcs->keys()->toArray();
                    @endphp
                    @forelse($rcs as $rcCode => $rc)
                        <tr>
                            <td class="indent">{{$rc->first()->responsibilityCenter->alias}}</td>
                            @foreach($usedIncentives as $usedIncentive)
                                <td class="text-right">
                                    {{Helper::toNumber(
                                        $payrollMaster->hmtDetails->where('code',$usedIncentive)->where(function ($hmt) use($rcCode){
                                                    return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;
                                                })->sum('amount')
                                    )}}
                                </td>
                            @endforeach
                            <td class="text-right">
                                {{Helper::toNumber(
                                    $payrollMaster->hmtDetails->whereIn('code',$usedIncentives)->where(function ($hmt) use($rcCode){
                                                return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;
                                            })->sum('amount')
                                )}}
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="bg-success">
                        <td class="text-strong">TOTAL {{$dept}}</td>
                        @foreach($usedIncentives as $usedIncentive)
                            <td class="text-right text-strong">
                                {{Helper::toNumber(
                                       $payrollMaster->hmtDetails->where('code',$usedIncentive)->where(function ($hmt) use($rcCode,$rcsArray){
                                                   return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);
                                               })->sum('amount')
                               )}}
                            </td>
                        @endforeach
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                $payrollMaster->hmtDetails->whereIn('code',$usedIncentives)->where(function ($hmt) use($rcCode,$rcsArray){
                                            return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);
                                        })->sum('amount')
                            )}}
                        </td>
                    </tr>
                @empty
                @endforelse
                <tr class="bg-info">
                    <td class="text-strong">GRAND TOTAL</td>
                    @foreach($usedIncentives as $usedIncentive)
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                $payrollMaster->hmtDetails->where('code',$usedIncentive)->sum('amount')
                            )}}
                        </td>
                    @endforeach
                    <td class="text-right text-strong">
                        {{Helper::toNumber(
                            $payrollMaster->hmtDetails->whereIn('code',$usedIncentives)->sum('amount')
                        )}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        @forelse($chunkedUsedDeductions as $usedDeductions)
            <div style="break-after: page">
                <div class="clearfix">
                    <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                    <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
                    <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
                </div>

                <div style="text-align: left">
                    <h3 class="no-margin text-strong" style="font-size: 18px">DISTRIBUTION SHEET</h3>
                    <p class="no-margin "><b>{{Carbon::parse($payrollMaster->date)->format('F Y')}}</b></p>
                </div>
                <table style="width: 100%; font-size: 14px" class="tbl-padded tbl-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Unit</th>
                        @foreach($usedDeductions as $usedDeduction)
                            <th class="text-center" style="width: 16%; font-size: 12px; word-wrap: break-word">{{$usedDeduction}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tree as $dept => $rcs)
                        @php
                            $rcsArray = $rcs->keys()->toArray();
                        @endphp
                        @forelse($rcs as $rcCode => $rc)
                            <tr>
                                <td class="indent">{{$rc->first()->responsibilityCenter->alias}}</td>
                                @foreach($usedDeductions as $usedDeduction)
                                    <td class="text-right">
                                        {{Helper::toNumber(
                                            $payrollMaster->hmtDetails->where('code',$usedDeduction)->where(function ($hmt) use($rcCode){
                                                        return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;
                                                    })->sum('amount')
                                        )}}
                                    </td>
                                @endforeach
{{--                                <td class="text-right">--}}
{{--                                    {{Helper::toNumber(--}}
{{--                                        $payrollMaster->hmtDetails->whereIn('code',$usedDeductions)->where(function ($hmt) use($rcCode){--}}
{{--                                                    return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;--}}
{{--                                                })->sum('amount')--}}
{{--                                    )}}--}}
{{--                                </td>--}}
                            </tr>
                        @empty
                        @endforelse
                        <tr class="bg-success">
                            <td class="text-strong">TOTAL {{$dept}}</td>
                            @foreach($usedDeductions as $usedDeduction)
                                <td class="text-right text-strong">
                                    {{Helper::toNumber(
                                           $payrollMaster->hmtDetails->where('code',$usedDeduction)->where(function ($hmt) use($rcCode,$rcsArray){
                                                       return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);
                                                   })->sum('amount')
                                   )}}
                                </td>
                            @endforeach
{{--                            <td class="text-right text-strong">--}}
{{--                                {{Helper::toNumber(--}}
{{--                                    $payrollMaster->hmtDetails->whereIn('code',$usedDeductions)->where(function ($hmt) use($rcCode,$rcsArray){--}}
{{--                                                return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);--}}
{{--                                            })->sum('amount')--}}
{{--                                )}}--}}
{{--                            </td>--}}
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        @empty
        @endforelse

        <div>
            <div class="clearfix">
                <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
                <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
            </div>

            <div style="text-align: left">
                <h3 class="no-margin text-strong" style="font-size: 18px">DISTRIBUTION SHEET</h3>
                <p class="no-margin "><b>{{Carbon::parse($payrollMaster->date)->format('F Y')}}</b></p>
            </div>
            <table style="width: 100%; font-size: 14px" class="tbl-padded tbl-bordered">
                <thead>
                <tr>
                    <th class="text-center">Unit</th>
                    <th class="text-center">TOTAL DEDUCTIONS</th>
                    <th class="text-center">2ND WEEK</th>
                    <th class="text-center">4TH WEEK</th>
                    <th class="text-center">TOTAL</th>
                </tr>
                </thead>
                <tbody>
                @forelse($tree as $dept => $rcs)
                    @php
                        $rcsArray = $rcs->keys()->toArray();
                    @endphp
                    @forelse($rcs as $rcCode => $rc)
                        <tr>
                            <td class="indent">{{$rc->first()->responsibilityCenter->alias}}</td>
                            <td class="text-right">
                                {{Helper::toNumber(
                                    $payrollMaster->hmtDetails->whereIn('code',$usedDeductionsAll)->where(function ($hmt) use($rcCode){
                                                return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;
                                            })->sum('amount')
                                )}}
                            </td>
                            <td class="text-right">
                                {{Helper::toNumber(
                                    $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcCode){
                                                return $payrollMasterEmployees->saved_employee_data['resp_center'] == $rcCode;
                                            })->sum('pay15')
                                )}}
                            </td>
                            <td class="text-right">
                                {{Helper::toNumber(
                                    $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcCode){
                                                return $payrollMasterEmployees->saved_employee_data['resp_center'] == $rcCode;
                                            })->sum('pay30')
                                )}}
                            </td>
                            <td class="text-right">
                                {{Helper::toNumber(
                                    $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcCode){
                                            return $payrollMasterEmployees->saved_employee_data['resp_center'] == $rcCode;
                                        })->sum('pay15') +
                                    $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcCode){
                                            return $payrollMasterEmployees->saved_employee_data['resp_center'] == $rcCode;
                                        })->sum('pay30')
                                )}}
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="bg-success">
                        <td class="text-strong">TOTAL {{$dept}}</td>
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                   $payrollMaster->hmtDetails->whereIn('code',$usedDeductionsAll)->where(function ($hmt) use($rcCode,$rcsArray){
                                               return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);
                                           })->sum('amount')
                           )}}
                        </td>
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                   $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcsArray){
                                               return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$rcsArray);
                                           })->sum('pay15')
                           )}}
                        </td>
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                   $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcsArray){
                                               return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$rcsArray);
                                           })->sum('pay30')
                           )}}
                        </td>
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                   $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcsArray){
                                           return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$rcsArray);
                                       })->sum('pay15') +
                                   $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($rcsArray){
                                           return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$rcsArray);
                                       })->sum('pay30')
                           )}}
                        </td>

                    </tr>
                @empty
                @endforelse
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class="bg-info">
                    <td class="text-strong">GRAND TOTAL</td>
                    <td class="text-strong text-right">
                        @php
                            $allRcsUsed = $tree->flatten()->pluck('resp_center')->toArray();

                        @endphp
                        {{Helper::toNumber(
                                   $payrollMaster->hmtDetails->whereIn('code',$usedDeductionsAll)->where(function ($hmt) use($allRcsUsed){
                                               return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$allRcsUsed);
                                           })->sum('amount')
                           )}}
                    </td>
                    <td class="text-strong text-right">
                        {{Helper::toNumber(
                               $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($allRcsUsed){
                                       return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$allRcsUsed);
                                   })->sum('pay15')
                       )}}
                    </td>
                    <td class="text-strong text-right">
                        {{Helper::toNumber(
                              $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($allRcsUsed){
                                      return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$allRcsUsed);
                                  })->sum('pay30')
                      )}}
                    </td>
                    <td class="text-strong text-right">
                        {{Helper::toNumber(
                              $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($allRcsUsed){
                                      return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$allRcsUsed);
                                  })->sum('pay15') +
                              $payrollMaster->payrollMasterEmployees->where(function ($payrollMasterEmployees) use($allRcsUsed){
                                      return in_array($payrollMasterEmployees->saved_employee_data['resp_center'],$allRcsUsed);
                                  })->sum('pay30')
                      )}}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection