@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        .above {
            position: relative;
            display: inline-block;
            margin-bottom: .5em;
        }
        .above::before {
            position: absolute;
            top: 80%;
            width: 100%;
            border: 1px currentcolor solid;
            border-top: 0;
            content: "";
        }
        .above .below {
            position: absolute;
            width: 100%;
            left: 0;
            top: 50%;
            font-size: 0.75em;
            text-align: center;
        }
        p{
            font-size: 17px;
        }
        div.cont {
            position: fixed;
            top : 0;
            left: 100px;
        }

        div.cont2 {
            position: fixed;
            top : 50%;
            left: 100px;
        }
        .padded{
            padding: 5px;
        }
    </style>
    <div style="font-family: Cambria;position: relative">
        <div class="cont">
            <img src="{{asset('images/sra.png')}}" style="width: 90px; float: left; margin-right: 15px;">
        </div>
        <div class="text-center">
            <p class="no-margin">Republic of the Philippines</p>
            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
            <p class="no-margin">North Avenue, Diliman, Quezon City</p>
        </div>
        <h4 class="text-strong text-center" style="margin-top: 15px">CERTIFICATE OF APPEARANCE</h4>
        <p class="no-margin text-right">Date: <b><u>Jan..</u></b></p>
        <p class="no-margin">TO WHOM IT MAY CONCERN:<br><br></p>
        <p class="" style="text-align: justify; line-height: 50px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This is to certify that

                <span class="above">
                    <b>GERALD JESTER S. GUANCE</b>
                </span>
            has reported to this
            Office/Station on
                <span class="above">
                    <b>Dec. 13, 2023 | 9:30AM</b>
                    <span class="below">
                        (Date & Time)
                    </span>
                </span>
            up to
                <span class="above">
                    <b>Dec. 13, 2023 | 9:30AM</b>
                    <span class="below">
                        (Date & Time)
                    </span>
                </span>
            as per Travel
            Order/ Memorandum/ Letter/ Telegram etc. (true copy attached).

        </p>

        <table style="width: 100%; font-size: 16px">
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center text-strong">DIGNA D. GONZALES</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center">(Signature of Head of Office or Station)</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center text-strong"><br> Manager III, PPSPD</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center">(Designation)</td>
            </tr>
        </table>
        <p class="text-right" style="font-size: 8px">
            FM-AFD-ACC-022, Rev. 00 <br>
                Effectivity Date: March 12, 2015
        </p>
    </div>
    <hr style="border: 1px solid black">
    <div style="font-family: Cambria;position: relative">
        <div class="cont2">
            <img src="{{asset('images/sra.png')}}" style="width: 90px; float: left; margin-right: 15px;">
        </div>
        <div class="text-center">
            <p class="no-margin">Republic of the Philippines</p>
            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
            <p class="no-margin">North Avenue, Diliman, Quezon City</p>
        </div>
        <h4 class="text-strong text-center" style="margin-top: 15px">CERTIFICATE OF APPEARANCE</h4>
        <p class="no-margin text-right">Date: <b><u>{{Helper::dateFormat(request()->get('date'),'F d, Y')}}</u></b></p>
        <p class="no-margin">TO WHOM IT MAY CONCERN:<br><br></p>
        <p class="" style="text-align: justify; line-height: 50px">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; This is to certify that

            <span class="above">
                    <b>{{strtoupper(request()->get('employee'))}}</b>
                </span>
            has reported to this
            Office/Station on
            <span class="above">
                    <b>{{Helper::dateFormat(request()->get('date_from'),'F d, Y | h:i A')}}</b>
                    <span class="below">
                        (Date & Time)
                    </span>
                </span>
            up to
            <span class="above">
                    <b>{{Helper::dateFormat(request()->get('date_to'),'F d, Y | h:i A')}}</b>
                    <span class="below">
                        (Date & Time)
                    </span>
                </span>
            as per Travel
            Order/ Memorandum/ Letter/ Telegram etc. (true copy attached).

        </p>

        <table style="width: 100%; font-size: 16px">
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center text-strong">{{strtoupper(request()->get('sig_name'))}}</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center">(Signature of Head of Office or Station)</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center text-strong"><br> {{strtoupper(request()->get('sig_pos'))}}</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td class="text-center">(Designation)</td>
            </tr>
        </table>
        <p class="text-right" style="font-size: 8px">
            FM-AFD-ACC-022, Rev. 00 <br>
            Effectivity Date: March 12, 2015
        </p>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            //print();
        })

    </script>
@endsection