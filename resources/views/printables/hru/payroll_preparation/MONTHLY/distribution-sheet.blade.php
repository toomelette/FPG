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
        <div>
            <p class="text-strong">DISTRIBUTION SHEET <br>
                {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
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
            <div>
                <p class="text-strong">DISTRIBUTION SHEET <br>
                    {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
                <table style="width: 100%; font-size: 14px" class="tbl-padded tbl-bordered">
                    <thead>
                    <tr>
                        <th class="text-center">Unit</th>
                        @foreach($usedDeductions as $usedDeduction)
                            <th class="text-center" style="width: 16%">{{$usedDeduction}}</th>
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
            <p class="text-strong">DISTRIBUTION SHEET <br>
                {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
            <table style="width: 100%; font-size: 14px" class="tbl-padded tbl-bordered">
                <thead>
                <tr>
                    <td>Unit</td>
                    <td>TOTAL DEDUCTIONS</td>
                    <td>2ND WEEK</td>
                    <td>4TH WEEK</td>
                    <td>TOTAL</td>
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
                            <td>
                                {{Helper::toNumber(
                                    $payrollMaster->hmtDetails->whereIn('code',$usedDeductionsAll)->where(function ($hmt) use($rcCode){
                                                return $hmt->employeePayroll->saved_employee_data['resp_center'] == $rcCode;
                                            })->sum('amount')
                                )}}
                            </td>
                            <td>2ND WEEK</td>
                            <td>4TH WEEK</td>
                            <td>TOTAL</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="bg-success">
                        <td class="text-strong">TOTAL {{$dept}}</td>

                        <td>2ND WEEK</td>
                        <td>4TH WEEK</td>
                        <td>TOTAL</td>
                        <td class="text-right text-strong">
                            {{Helper::toNumber(
                                $payrollMaster->hmtDetails->whereIn('code',$usedDeductionsAll)->where(function ($hmt) use($rcCode,$rcsArray){
                                            return in_array($hmt->employeePayroll->saved_employee_data['resp_center'],$rcsArray);
                                        })->sum('amount')
                            )}}
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection