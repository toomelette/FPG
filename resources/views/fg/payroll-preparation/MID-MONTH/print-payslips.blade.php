@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        @php
            $chunkedEmployees = $payrollMaster->payrollEmployees->chunk(3);
        @endphp

        @foreach($chunkedEmployees as $chunk)
            <div style="break-after: page">
                @forelse($chunk as $payrollEmployee)
                    <div class="payslip-container">
                        <table style="width: 100%; font-size: 14px">
                            <tr>
                                <td class="text-bottom" style="width: 30%">
                                    <img style="width: 50px; float: right; margin-right: 20px" src="{{asset('images/fpg.png')}}">
                                </td>
                                <td class="text-center">
                                    <span>{{Str::upper(\App\Swep\Helpers\Get::company())}}</span> <br>
                                    <span class="text-strong">PAYSLIP </span> <br>
                                    <span class="text-strong"> {{$payrollEmployee->saved_employee_data['full_name'] ?? ''}} </span>
                                </td>
                                <td style="width: 30%">

                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%; border-bottom: 1px solid black; font-size: 14px">
                            <tr>
                                <td class="text-bottom" style="width: 33%;padding-bottom: 5px">
                                    <p class="no-margin text-strong">{{$payrollEmployee->saved_data['LFEMi']}}</p>
                                </td>
                                <td class="text-center" style="padding-bottom: 5px">
                                    Pay Period: {{Helper::dateFormat($payrollMaster->date_from,' M. d')}} to {{Helper::dateFormat($payrollMaster->date_to,'M. d, Y')}}
                                </td>
                                <td style="width: 33%;padding-bottom: 5px">
                                    <p class="no-margin text-strong text-right">{{$payrollEmployee->saved_data['position'] ?? null}}</p>
                                </td>
                            </tr>
                        </table>

                        <table style="width: 100%; font-size: 14px" class="b-bottom">
                            <tr>
                                <td class="text-top b-right" style="padding-right: 5px; width: 33%">
                                    <p class="text-center no-margin">MONTHLY EARNINGS</p>
                                    @php
                                        $employeeIncentives = $payrollEmployee->employeeAdjustments->where('type','INCENTIVE')
                                    @endphp
                                    <table style="width: 100%;">
                                        @forelse($employeeIncentives as $incentive)
                                            <tr>
                                                <td>{{$incentive->code}}</td>
                                                <td class="text-right">{{Helper::toNumber($incentive->amount)}}</td>
                                            </tr>
                                        @empty
                                        @endforelse

                                    </table>

                                </td>
                                <td class="text-top b-right" style="padding-left: 5px;padding-right: 5px; width: 33%">
                                    <p class="text-center no-margin">MONTHLY DEDUCTIONS</p>
                                    @php
                                        $employeeDeductions = $payrollEmployee->employeeAdjustments
                                            ->where('type','DEDUCTION')
                                            ->where('amount','!=',0)
                                            ->sortBy(function ($data){
                                                if($data->priority == null){
                                                    return 10000;
                                                }else{
                                                    return $data->priority;
                                                }
                                            });

                                    @endphp
                                    <table style="width: 100%;" class="deductions-table">
                                        @forelse($employeeDeductions as $deduction)
                                            <tr>
                                                <td>{{$deduction->code}}</td>
                                                <td class="text-right">{{Helper::toNumber($deduction->amount)}}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </table>
                                </td>
                                <td class="text-top" style="padding-left: 5px;">
                                    <p class="text-center no-margin">SUMMARY</p>
                                    <table style="width: 100%;">

                                        <tr>
                                            <td>TOTAL EARNINGS</td>
                                            <td class="text-right">{{Helper::toNumber($employeeTotalIncentives = $employeeIncentives->sum('amount'))}}</td>
                                        </tr>
                                        <tr>
                                            <td>TOTAL DEDUCTIONS</td>
                                            <td class="text-right">{{Helper::toNumber($employeeTotalDeductions = $employeeDeductions->sum('amount'),2,'0.00')}}</td>
                                        </tr>

                                        <tr>
                                            <td>NET PAY</td>
                                            <td class="text-right b-top text-strong">{{Helper::toNumber($employeeTotalIncentives - $employeeTotalDeductions)}}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <p class="no-margin"><b> {{$payrollEmployee->saved_data['employee_no'] ?? ''}} </b></p>

                        <table style="width: 100%; margin-top: 25px; margin-bottom: 5px">
                            <tr>
                                <td style="width: 85px">Prepared by:</td>
                                <td class="text-strong"><u>LHYCA DIAMANTE</u></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><i>Finance Officer</i></td>
                            </tr>
                        </table>
                        <hr style="border: 1px dashed grey" class="no-margin">
                        <p class="no-margin" style="font-size: 8px"><i class="fa fa-scissors"></i> CUT HERE</p>
                    </div>
                @empty
                @endforelse
            </div>
        @endforeach
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        let max = 350
        $(".payslip-container").each(function (){
            let containerHeight = $(this).height();
            if(containerHeight < max){
                console.log(max-containerHeight)
                $(this).find('.deductions-table').css('margin-bottom',max-containerHeight+'px')
            }
        })

        print()
    </script>
@endsection