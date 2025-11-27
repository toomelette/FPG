@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 16px; margin: 170px 40px 0px 40px">
        <p style="text-align: right; line-height: 38px">
            {{Carbon::now()->format('F d, Y')}}
        </p>
        <br>
        <p class="text-strong text-center" style="letter-spacing: 1px; font-size: 22px">CERTIFICATE OF EMPLOYMENT AND COMPENSATION</p>
        <br>

        <p style="text-indent: 40px; line-height: 20px; text-align: justify">
        This is to certify that  {{$employee->sex == 'MALE' ? 'MR.' : 'MS.'}} {{$employee->full['FMiLE']}} has been an employee of the Sugar Regulatory Administration since
        {{Carbon::parse($employee->firstday_sra)->format('F d, Y')}}, to date.
        </p>

        {{$employee->sex == 'MALE' ? 'He' : 'She'}} holds a permanent appointment as {{$employee->plantilla->position}}.
        <br><br>
        <p style="text-indent: 40px; line-height: 20px; text-align: justify">
            {{$employee->sex == 'MALE' ? 'His' : 'Her'}} present monthly compensation are as follows:
        </p>
        @php
            $employee->load('templateIncentives.incentive','payrollSettings');
            $monthly = $employee->templateIncentives->where('incentive_code','MONTHLY')?->first()?->amount ?? 0;
            $pera = $employee->templateIncentives->where('incentive_code','PERA')?->first()?->amount ?? 0;
            $ra = $employee?->payrollSettings?->ra_rate ?? 0;
            $ta = $employee?->payrollSettings?->ta_rate ?? 0;
        @endphp
        <table style="width: 80%; margin-left: 15%; font-size: 15px">
            <tr>
                <td style="width: 60%">Basic Salary</td>
                <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($monthly)}}</td>
                <td style="width: 60px">/month</td>
                <td style="width: 100px"></td>
                <td style="width: 60px"></td>
            </tr>
            <tr>
                <td>PERA</td>
                <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($pera)}}</td>
                <td>/month</td>
                <td></td>
                <td></td>
            </tr>

            @if(!empty($employee->payrollSettings->receives_ra))
                <tr>
                    <td>Representation</td>
                    <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($ra)}}</td>
                    <td>/month</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            @if(!empty($employee->payrollSettings->receives_ta))
                <tr>
                    <td>Transportation</td>
                    <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($ta)}}</td>
                    <td>/month</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            <tr>
                <td class="b-top">Total Earnings</td>
                <td class="text-right b-top">{{\App\Swep\Helpers\Helper::toNumber($totalMonthly = $monthly + $pera + $ra + $ta)}}</td>
                <td class="b-top">/month</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><br></td>
                <td><br></td>
                <td><br></td>
                <td><br></td>
                <td><br></td>
            </tr>
            <tr>
                <td class="b-top">Annual</td>
                <td class="b-top"><br></td>
                <td class="b-top"><br></td>
                <td class="text-right b-top">{{\App\Swep\Helpers\Helper::toNumber($monthlyAnnual = $totalMonthly * 12)}}</td>
                <td class="b-top">/annum</td>
            </tr>
        </table>
        <br>
        <p style="text-indent: 40px; line-height: 20px; text-align: justify">
            Further, {{$employee->sex == 'MALE' ? 'he' : 'she'}} receives the following additional yearly remuneration, viz:
        </p>
        <table style="width: 80%; margin-left: 15%; font-size: 15px" >
            @php
                $otherIncentives = $employee->templateIncentives
                    ->where('amount','!=',0)
                    ->where('amount','!=',null)
                    ->whereNotIn('incentive_code',[
                        'MONTHLY',
                        'PERA',
                        'RA',
                        'TA'
                    ])
                    ->sortByDesc('amount');

            @endphp
            @if(!empty($otherIncentives))
                @foreach($otherIncentives as $incentive)
                    @if($incentive->amount !== null)
                        <tr>
                            <td style="width: 60%;">{{$incentive->incentive->description}}</td>
                            <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($incentive->amount)}}</td>
                            <td style="width: 60px">/annum</td>
                            <td style="width: 100px"></td>
                            <td style="width: 60px"></td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="b-top">Total Other Earnings</td>
                    <td class="b-top"></td>
                    <td class="b-top"></td>
                    <td class="text-right b-top">{{\App\Swep\Helpers\Helper::toNumber($totalOther = $otherIncentives->sum('amount'))}}</td>
                    <td class="b-top">/annum</td>

                </tr>

            @endif
            <tr>
                <td><br></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-strong" style="font-size: 12px">TOTAL GROSS EARNINGS</td>
                <td class="text-right"></td>
                <td></td>
                <td style="width: 100px" class="text-right text-strong">{{\App\Swep\Helpers\Helper::toNumber($monthlyAnnual + $totalOther)}}</td>
                <td class="text-strong" style="width: 60px">/annum</td>
            </tr>
        </table>
        <br><br>


        <p style="text-indent: 40px; line-height: 20px; text-align: justify">
        This certification is issued for whatever legal purpose it may serve.
        </p>
        <br><br>
        <div style="overflow: auto">
            <div style="width: 50%; float: right">
                <p class="text-center">
                    <b>{{request('signatory_name')}}</b>
                    <br>
                    {{request('signatory_position')}}
                </p>
            </div>
        </div>


        <br><br>

        <div>
            <p class="no-margin text-right" style="font-size: 10px;">FM-AFD-HRS-037, Rev. 01</p>
            <p class="no-margin text-right" style="font-size: 10px;">Effectivity Date: January 8, 2016</p>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        @if(\Illuminate\Support\Facades\Request::has('autoPrint') && \Illuminate\Support\Facades\Request::get('autoPrint') == true)
        print();
        @endif
    </script>
@endsection