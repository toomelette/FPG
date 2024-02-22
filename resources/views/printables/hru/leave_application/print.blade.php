@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<style>
    div.cont {
        position: fixed;
        top :30px;
        left: 100px;
    }
    .padded{
        padding: 5px;
    }
</style>
<div style="font-family: Arial">
    <div class="cont">
        <img src="{{asset('images/sra.png')}}" style="width: 70px; float: left; margin-right: 15px;">
    </div>
    <p class="no-margin" style="font-size: 8px">Civil Service Form No. 6</p>
    <p class="no-margin" style="font-size: 8px">Revised 2020</p>
    <div class="text-center">
        <p class="no-margin" style="font-size: 12px;"> Republic of the Philippines</p>
        <p class="no-margin" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
        <p class="no-margin" style="font-size: 12px;"> {{\App\Swep\Helpers\Values::headerAddress()}}</p>
    </div>

    <br>
    <p class="text-center text-strong" style="font-size: 16px">
        APPLICATION FOR LEAVE
    </p>
    <table style="width: 100%;" class="">
        <tr>
            <td class="b-top b-left">1. OFFICE/DEPARTMENT</td>
            <td class="b-top">2. NAME (Last)</td>
            <td class="b-top">(First)</td>
            <td class="b-top b-right">(Middle)</td>
        </tr>
        <tr style="font-size: 14px; height: 30px">
            <td class="b-left b-bottom text-strong indent">{{$la->_department->name}}</td>
            <td class="b-bottom text-strong">{{$la->lastname}}</td>
            <td class="b-bottom text-strong">{{$la->firstname}}</td>
            <td class="b-right b-bottom text-strong">{{$la->middlename}}</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr style="font-size: 12px; height: 30px" class="padded">
            <td class="b-left b-bottom">3. DATE OF FILING: <u><b>{{Helper::dateFormat($la->date_of_filing,'M. d, Y')}}</b></u></td>
            <td class=" b-bottom">4. POSITION: <b><u>{{$la->position}}</u></b></td>
            <td class="b-right b-bottom">5. SALARY: <b><u>{{$la->salary}}</u></b></td>
        </tr>
        <tr>
            <td colspan="3" class="text-center text-strong b-left b-right b-bottom">6. DETAILS OF APPLICATION</td>
        </tr>
    </table>
    <table style="width: 100%;">

        <tr>
            <td style="vertical-align: top;width: 50%" class="b-left padded">
                6A. TYPE OF LEAVE TO BE AVAILED OF:
                @forelse(\App\Swep\Helpers\Arrays::leaveTypesForView() as $leave => $desc)
                    <p class="no-margin indent" style="font-size: 11px">
                        {{$leave == $la->leave_type ? '☑':'☐'}} {{$leave}} <small style="font-size: 6.5px">{{$desc}}</small>
                    </p>
                @empty
                @endforelse
                <br>
                <p class="indent-2"><u>{{$la->leave_type_specify}}</u></p>
            </td>
            <td style="vertical-align: top;" class="b-left b-right padded">
                6B. DETAILS OF LEAVE
                <p class="indent no-margin">In case of Vacation/Special Privilege Leave</p>
                <p class="indent no-margin">{{'Within the Philippines' == $la->leave_details ? '☑':'☐'}} Within the Philippines   </p>
                <p class="indent">{!! 'Abroad' == $la->leave_details ? ('☑ Abroad: '.'<u>'.$la->leave_specify.'</u>') :'☐ Abroad'  !!}</p>

                <p class="indent no-margin">In case of Sick Leave:</p>
                <p class="indent no-margin">{!! 'In Hospital' == $la->leave_details ? ('☑ In Hospital: '.'<u>'.$la->leave_specify.'</u>') :'☐ In Hospital'  !!}</p>
                <p class="indent">{!! 'Out Patient' == $la->leave_details ? ('☑ Out Patient: '.'<u>'.$la->leave_specify.'</u>') :'☐ Out Patient'  !!}</p>

                <p class="indent no-margin">In case of Special Leave Benefits for Women:</p>
                @if($la->leave_type == 'Special Leave Benefits for Women')
                    <p class="indent no-margin">{{$leave_specify}}</p>
                    <p class="indent">_______________________________________</p>
                @else
                    <p class="indent no-margin">__________________________________</p>
                    <p class="indent">__________________________________</p>
                @endif

                <p class="indent no-margin">In case of Study Leave</p>
                <p class="indent no-margin">{{"Completion of Master's Degree" == $la->leave_details ? '☑':'☐'}} Completion of Master's Degree   </p>
                <p class="indent">{{"BAR/Board Exam Review" == $la->leave_details ? '☑':'☐'}} BAR/Board Exam Review   </p>

                <p class="indent no-margin">Other Purpose:</p>
                <p class="indent no-margin">{{"Monetization of Leave Credits" == $la->leave_details ? '☑':'☐'}} Monetization of Leave Credits   </p>
                <p class="indent">{{"Terminal Leave" == $la->leave_details ? '☑':'☐'}} Terminal Leave   </p>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="vertical-align: top;width: 50%" class="b-top b-left padded">
                6C. NUMBER OF WORKING DAYS APPLIED FOR:
                <p class="indent" style="margin-top: 10px"> <u>{{$la->no_of_days}}</u></p>
                <p class="indent">INCLUSIVE DATES:</p>
                <p class="indent">
                    <u>
                    @forelse($la->dates as $date)
                        @if($loop->first)
                            {{Carbon::parse($date->date)->format('M. d,')}}
                            @if($loop->count < 2)
                                {{Carbon::parse($date->date)->format('Y')}}
                            @endif
                        @elseif($loop->last)
                            {{Carbon::parse($date->date)->format(' d, Y')}}
                        @else
                            {{Carbon::parse($date->date)->format('d,')}}
                        @endif
                    @empty
                    @endforelse
                    </u>
                </p>
            </td>
            <td style="vertical-align: top" class="b-top b-left b-right padded">
                6D. COMMUTATION
                @if($la->commutation == 'Requested')
                    <p class="no-margin indent">☐ Not Requested</p>
                    <p class="no-margin indent">☑ Requested</p>
                @else
                    <p class="no-margin indent">☑ Not Requested</p>
                    <p class="no-margin indent">☐ Requested</p>
                @endif
                <br>
                <p class="text-center no-margin">_______________________________________</p>
                <p class="text-center">(Signature of Applicant)</p>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="vertical-align: top;width: 50%" class="b-top b-left padded">
                7A. CERTIFICATION OF LEAVE CREDITS:
                <p> As of: </p>

                <table style="width: 90%; margin-left: 5%; font-size: 10px" class="tbl-bordered">
                    <tr>
                        <td class="text-strong text-center"></td>
                        <td class="text-strong text-center" style="width: 30%">Vacation Leave</td>
                        <td class="text-strong text-center" style="width: 30%">Sick Leave</td>
                    </tr>
                    <tr class="text-center">
                        <td>Total Earned</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="text-center">
                        <td>Less this application</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr class="text-center">
                        <td>Balance</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

                <br>
                <p class="text-center no-margin text-strong"> <u>{{$la->certified_by}}</u> </p>
                <p class="text-center">(Authorized Officer)</p>
            </td>
            <td style="vertical-align: top" class="b-top b-left b-right padded">
                7B. RECOMMENDATION
                <p class="no-margin indent">☐ For approval</p>
                <p class="no-margin indent">☐ For disapproval due to: </p>

                <p class="text-center no-margin">___________________________________________________</p>
                <p class="text-center">(Authorized Officer)</p>
            </td>
        </tr>
    </table>
    <table style="width: 100%">
        <tr>
            <td style="vertical-align: top; width: 50%" class="b-top b-left padded">
                7C. APPROVED FOR:
                <p class="indent no-margin"> ______ days with pay </p>
                <p class="indent no-margin"> ______ days without pay </p>
                <p class="indent no-margin"> ______ others (specify) </p>


            </td>
            <td style="vertical-align: top" class="b-top  b-right padded">
                7D. DISAPPROVED DUE TO:
                <p class="indent no-margin">__________________________________________</p>
                <p class="indent no-margin">__________________________________________</p>
                <p class="indent no-margin">__________________________________________</p>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="b-left b-right b-bottom">
                <br>
                <br>
                <br>
                <p class="text-center no-margin text-strong"> <u>{{$la->approved_by}}</u> </p>
                <p class="text-center no-margin">{{$la->approved_by_position}} </p>
                <p class="text-center">(Authorized Official)</p>
            </td>
        </tr>


    </table>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function () {
            print();
        })
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection