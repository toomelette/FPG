@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMasterEmployees $payrollEmployee **/
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        @php
            $chunkedEmployees = $payrollMaster->payrollMasterEmployees->chunk(3);
        @endphp

        @foreach($chunkedEmployees as $chunk)
            <div style="break-after: page">
                @forelse($chunk as $payrollEmployee)
                    <table style="width: 100%; border-bottom: 1px solid black; font-size: 14px">
                        <tr>
                            <td class="text-bottom" style="width: 20%">EMP. NO.: <b>{{$payrollEmployee->saved_employee_data['employee_no'] ?? ''}}</b></td>
                            <td class="text-center">
                                <small>SUGAR REGULATORY ADMINISTRATION</small> <br>
                                <span class="text-strong">STATEMENT OF EARNINGS & DEDUCTIONS FOR {{strtoupper(Helper::dateFormat($payrollMaster->date,'F Y'))}}</span> <br>
                                <span class="text-strong"> {{$payrollEmployee->saved_employee_data['full_name'] ?? ''}} </span>
                            </td>
                            <td style="width: 20%">
                                <img style="width: 50px; float: right; margin-right: 20px" src="{{asset('images/sra_only2_low.png')}}">
                            </td>
                        </tr>
                    </table>
                    <table style="width: 100%; font-size: 14px" class="b-bottom">
                        <tr>
                            <td class="text-top b-right" style="padding-right: 5px; width: 25%">
                                <p class="text-center no-margin">MONTHLY EARNINGS</p>
                                @php
                                    $employeeIncentives = $payrollEmployee->employeePayrollDetails->where('type','INCENTIVE')
                                @endphp
                                <table style="width: 100%;">
                                    @forelse($employeeIncentives as $incentive)
                                        <tr>
                                            <td>{{$incentive->code}}</td>
                                            <td class="text-right">{{Helper::toNumber($incentive->amount)}}</td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    @if(isset($employeesWithRata[$payrollEmployee->employee_slug]))
                                        <tr>
                                            <td style="height: 10px"></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>RA</td>
                                            <td class="text-right">{{Helper::toNumber($ra = $employeesWithRata[$payrollEmployee->employee_slug]->rata_ra_rate)}}</td>
                                        </tr>
                                        <tr>
                                            <td>TA</td>
                                            <td class="text-right">{{Helper::toNumber($ta = $employeesWithRata[$payrollEmployee->employee_slug]->rata_ta_rate)}}</td>
                                        </tr>
                                    @else
                                        @php
                                            $ra = 0;
                                            $ta = 0;
                                        @endphp
                                    @endif
                                </table>

                            </td>
                            <td class="text-top b-right" style="padding-left: 5px;padding-right: 5px; width: 50%">
                                <p class="text-center no-margin">MONTHLY DEDUCTIONS</p>
                                @php
                                    $employeeDeductions = $payrollEmployee->employeePayrollDetails
                                        ->where('type','DEDUCTION')
                                        ->sortBy(function ($data){
                                            if($data->priority == null){
                                                return 10000;
                                            }else{
                                                return $data->priority;
                                            }
                                        })
                                @endphp
                                <table style="width: 50%" class="b-right">
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
                                        <td class="text-right">{{Helper::toNumber($employeeTotalIncentives = $employeeIncentives->sum('amount') + $ra + $ta )}}</td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL DEDUCTIONS</td>
                                        <td class="text-right">{{Helper::toNumber($employeeTotalDeductions = $employeeDeductions->sum('amount'),2,'0.00')}}</td>
                                    </tr>

                                    <tr>
                                        <td>NET PAY</td>
                                        <td class="text-right b-top">{{Helper::toNumber($employeeTotalIncentives - $employeeTotalDeductions)}}</td>
                                    </tr>

                                    <tr>
                                        <td style="height: 60px">15TH</td>
                                        <td class="text-right">{{Helper::toNumber($payrollEmployee->pay15)}}</td>
                                    </tr>

                                    <tr>
                                        <td style="height: 60px">30TH</td>
                                        <td class="text-right">{{Helper::toNumber($payrollEmployee->pay30)}}</td>
                                    </tr>
                                    @if(isset($employeesWithRata[$payrollEmployee->employee_slug]))
                                        <tr>
                                            <td style="height: 60px">RATA</td>
                                            <td class="text-right">{{Helper::toNumber($ra + $ta)}}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td style="height: 60px"></td>
                                            <td class="text-right"></td>
                                        </tr>
                                    @endif

                                </table>
                            </td>
                        </tr>
                    </table>
                   <p><b> {{$payrollEmployee->saved_employee_data['position'] ?? ''}} </b></p>

                    <hr style="border: 1px dashed grey" class="no-margin">
                    <p class="no-margin" style="font-size: 8px"><i class="fa fa-scissors"></i> CUT HERE</p>
                @empty
                @endforelse
            </div>
        @endforeach
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
                print();
            }
        })
        window.onafterprint = function () {
            @if(\Illuminate\Support\Facades\Request::has('employeeList'))
            window.close();
            @endif
        }
    </script>
@endsection