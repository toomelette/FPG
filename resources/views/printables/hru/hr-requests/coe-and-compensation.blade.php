@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    @php
        $employee = \App\Models\Employee::where('slug','=',$hrRequest->employee_slug)->first();
    @endphp
    <div style="font-family: Cambria; font-size: 16px; margin: 170px 40px 0px 40px">
        <small>MEMO-VIS-AFD-GAD-HRRS-{{Carbon::parse($hrRequest->document_fields['date'])->format('Y')}}-{{$hrRequest->document_fields['memo_code']}}</small>
        <br>
        <p style="text-align: right; line-height: 38px">
            {{Carbon::parse($hrRequest->document_fields['date'])->format('F d, Y')}}
        </p>
        <br>
        <p class="text-strong text-center" style="letter-spacing: 1px; font-size: 18px">CERTIFICATE OF EMPLOYMENT AND COMPENSATION</p>
        <br>
        {!!  Str::of($hrRequest->document_fields['first_paragraph'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 20px; text-align: justify">') !!}

        <p style="text-indent: 40px; line-height: 20px; text-align: justify">
            {{$employee->sex == 'MALE' ? 'His' : 'Her'}} present monthly compensation are as follows:
        </p>
        <table style="width: 60%; margin-left: 25%; font-size: 15px">
            <tr>
                <td style="width: 45%">Basic Salary</td>
                <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($hrRequest->document_fields['monthly_basic'])}}</td>
                <td style="width: 60px">/month</td>
                <td style="width: 100px"></td>
                <td style="width: 60px"></td>
            </tr>
            <tr>
                <td>PERA</td>
                <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($hrRequest->document_fields['pera'])}}</td>
                <td>/month</td>
                <td></td>
                <td></td>
            </tr>
            @if(!empty($hrRequest->document_fields['ra']))
                <tr>
                    <td>Representation</td>
                    <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($hrRequest->document_fields['ra'])}}</td>
                    <td>/month</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            @if(!empty($hrRequest->document_fields['ta']))
                <tr>
                    <td>Transportation</td>
                    <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($hrRequest->document_fields['ta'])}}</td>
                    <td>/month</td>
                    <td></td>
                    <td></td>
                </tr>
            @endif
            <tr>
                <td class="b-top">Total Earnings</td>
                <td class="text-right b-top">{{\App\Swep\Helpers\Helper::toNumber($totalMonthly = ($hrRequest->document_fields['monthly_basic'] ?? 0) + ($hrRequest->document_fields['pera'] ?? 0) + ($hrRequest->document_fields['ra'] ?? 0) + ($hrRequest->document_fields['ta'] ?? 0))}}</td>
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
        <table style="width: 60%; margin-left: 25%; font-size: 15px" >
        @if(!empty($hrRequest->document_fields['other_incentives']))

            @foreach($hrRequest->document_fields['other_incentives'] as $incentive => $amount)
                @if($amount !== null)
                    <tr>
                        <td style="width: 45%;">{{$incentive}}</td>
                        <td class="text-right">{{\App\Swep\Helpers\Helper::toNumber($amount)}}</td>
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
                    <td class="text-right b-top">{{\App\Swep\Helpers\Helper::toNumber($totalOther = collect($hrRequest->document_fields['other_incentives'])->sum())}}</td>
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
        {!!  Str::of($hrRequest->document_fields['purpose_paragraph'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 20px; text-align: justify">') !!}


        <br><br>
        <div style="overflow: auto">
            <div style="width: 50%; float: right">
                <p class="text-center">
                    <b>{{$hrRequest->document_fields['signatory_name']}}</b>
                    <br>
                    {{$hrRequest->document_fields['signatory_position']}}
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