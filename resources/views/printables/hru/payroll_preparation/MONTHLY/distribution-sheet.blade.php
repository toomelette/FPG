@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
{{--    @dd($payrollMaster->hmtDetails->first())--}}
    @php
        $respCodes = \App\Swep\Helpers\Arrays::respCodeList();
        $usedIncentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->groupBy('code')->keys();

    @endphp

    <div style="font-family: Cambria; font-size: 16px">
        <p class="text-strong">DISTRIBUTION SHEET <br>
            {{Carbon::parse($payrollMaster->date)->format('F Y')}}</p>
        <table style="width: 100%; font-size: 16px" class="tbl-padded tbl-bordered">
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
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection