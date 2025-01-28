@php
   $rand = \Illuminate\Support\Str::random();
   /** @var \App\Models\RECORDS\DocumentRequests $documentRequest **/
@endphp
@extends('printables.print_layouts.print_layout_main')

<style>
    .wms{
        background-image: url('{{asset('images/sra_wm.jpg')}}') 50%;
        background-repeat: no-repeat;
        background-position: center;
    }

    body::after {
        content: '';
        position: fixed;
        z-index: -999999;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-image: url('{{asset('images/sra_wm.jpg')}}');
        opacity: 0.35;
        pointer-events: none;
        background-repeat: no-repeat;
        background-position: center;
        background-size: 700px 700px;
    }
</style>
@section('wrapper')
<div style="font-family: Cambria;" class="wm">
    <div class="letter-head">
        <table style="width: 100%;">
            <tr>
                <td style="width: 10%;"></td>
                <td style="width: 120px;">
                    <img src="{{asset('images/sra.png')}}" width="110">
                </td>
                <td>
                    Republic of the Philippines <br>
                    Department of Agriculture <br>
                    <span style="font-size: 18px" class="text-strong">SUGAR REGULATORY ADMINISTRATION</span> <br>
                    Sugar Center Bldg., North Avenue, Diliman, Quezon City, Philippines 1101 <br>
                    TIN 000-784-336 <br>
                    Website: http://www.sra.gov.ph <br>
                    Email Address: srahead@sra.gov.ph <br>
                    Tel No. (632) 8929-3633, (632) 3455-2135, (632) 3455-3376 <br>

                </td>
            </tr>
        </table>
    </div>
    <div style="height: 10px"></div>

    <p class="text-center text-strong" style="font-size: 16px; margin-top: 50px">REQUEST FOR RELEASE OF RECORDS/DOCUMENTS</p>
    <table style="width: 100%; font-size: 14px; margin-bottom: 15px">
        <tr>
            <td style="width: 50%;"></td>
            <td class="text-strong">Request Form No.:</td>
            <td class="b-bottom">{{$documentRequest->request_no}}</td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td class="text-strong">Date & Time Requested:</td>
            <td class="b-bottom">{{$documentRequest->requested_at->format('M. d, Y | h:i A')}}</td>
        </tr>
        <tr>
            <td style="width: 50%;"></td>
            <td class="text-strong">Date & Time Released:</td>
            <td class="b-bottom">{{$documentRequest->released_at?->format('M. d, Y h:i A')}}</td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 14px; margin-bottom: 15px">
        <tr>
            <td style="width: 20%" class="text-strong">REQUESTING PARTY:</td>
            @foreach($requestingParties = \App\Swep\Helpers\Arrays::documentRequestingParty() as $requestingParty)
                <td style="width: {{(100-20)/count($requestingParties)}}%; font-size: 12px">

                    <span class="fillbox {{$requestingParty == $documentRequest->requesting_party ? 'active' : ''}} " style="float: left;"></span>
                    {{$requestingParty}}
                    <br>
                    @if($requestingParty == 'Other Government Agencies')
                        <span style="font-size: 12px">
                            Please specify: <u>{{$documentRequest->requesting_party_specify}}</u>
                        </span>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
    <span class="text-strong">REQUESTED RECORDS/DOCUMENTS:</span>
    <div style="padding-left: 10%">
        {{$documentRequest->requested_records}}
    </div>
    <span class="text-strong">PURPOSE:</span>
    <div style="padding-left: 10%">
        @foreach(\App\Swep\Helpers\Arrays::documentRequestPurpose() as $key => $purpose)
            <div style="margin-bottom: 10px">
                <span class="fillbox {{$key == $documentRequest->purpose ? 'active' : ''}} " style="float: left;"></span> {{$purpose}}
                <u class="text-strong">{{$key == 'Others' ? $documentRequest->purpose_specify : ''}}</u> <br>
            </div>
        @endforeach
    </div>
    <table style="width: 100%; border-collapse: separate; border-spacing:10px; font-size: 14px">
        <tr>
            <td style="width: 33.33333%;" class="text-strong">Requested by:</td>
            <td style="width: 33.33333%;" class="text-strong">Endorsed by:</td>
            <td style="width: 33.33333%;" class="text-strong">Approved by:</td>
        </tr>
        <tr style="vertical-align: bottom">
            <td style="height: 30px" class="b-bottom text-center">
                <br>
                <b>{{$documentRequest->requested_by}}</b> <br>
                <i> {{$documentRequest->contact_details}}</i>
            </td>
            <td class="b-bottom text-strong text-center">{{$documentRequest->endorsed_by}}</td>
            <td class="b-bottom text-strong text-center">{{$documentRequest->approved_by}}</td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 11px">Signature over printed name of requesting party/office</td>
            <td class="text-center" style="font-size: 11px">Endorsing Officer</td>
            <td class="text-center" style="font-size: 11px">Approving Officer</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: separate; border-spacing:10px;font-size: 14px">
        <tr>
            <td style="width: 33.33333%;" class="text-strong">Released by:</td>
            <td style="width: 66.6666667%;"></td>
        </tr>
        <tr style="vertical-align: bottom">
            <td style="height: 30px" class="b-bottom"></td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 11px">Records Section</td>
            <td class="text-center"></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: separate; border-spacing:10px;font-size: 14px">
        <tr>
            <td style="width: 33.33333%;" class="text-strong">Received by:</td>
            <td style="width: 66.6666667%;"></td>
        </tr>
        <tr style="vertical-align: bottom">
            <td style="height: 30px" class="b-bottom"></td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="text-center" style="font-size: 11px">Signature over printed name of requesting party/office</td>
            <td class="text-center"></td>
        </tr>
    </table>
    
    <div class="letter-foot" style="position: absolute;bottom: 0">
        <table style="width: 100%">
            <tr>
                <td style="width: 10%;">
                    <img src="{{asset('images/bagong_pilipinas.jpg')}}">
                </td>
                <td style="width: 70%;"></td>
                <td style="width: 20%;">
                    <img src="{{asset('images/iso.jpg')}}">
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();

    </script>
@endsection