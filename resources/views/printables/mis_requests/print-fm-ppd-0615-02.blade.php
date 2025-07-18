
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-size: 15px; font-family: Cambria">
        <div class="print-wrapper exempt-font">
            <table style="width: 100%;" class="text-center" >
                <tbody>
                <tr>
                    <td style="width: 30%; padding-top: 20px" class="b-top b-left">
                        <img src="{{asset('images/sra.png')}}" width="80" alt="logo" style="float: right"/>
                    </td>
                    <td class="b-top" style="; padding-top: 20px">
                        <b>SUGAR REGULATORY ADMINISTRATION</b>
                        <br>North Avenue, Diliman, Quezon City
                    </td>
                    <td style="width: 30%;" class="b-top b-right"></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-strong b-left b-right" style="padding-top: 10px">
                        SERVICE REQUEST FORM <br><br>
                    </td>
                </tr>
                </tbody>
            </table>
            <table style="width: 100%;" class="tbl-bordered text-center">
                <tbody>
                <tr>
                    <td style="width: 50%; vertical-align: top; padding: 5px; letter-spacing: 2px">
                        <b>JOB REQUEST</b>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding: 5px; letter-spacing: 2px"">
                        <b>ACTION TAKEN</b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; vertical-align: top">
                        <table style="width: 100%;" class="tbl-padded">
                            <tbody>
                            <tr>
                                <td style="width: 15%">Date:</td>
                                <td style="width: 35%;" class="text-strong b-bottom">{{Carbon::parse($r->created_at)->format('M d, Y')}}</td>
                                <td style="width: 15%">Ctrl#:</td>
                                <td class="text-strong b-bottom">{{$r->request_no}}</td>
                            </tr>
                            <tr>
                                <td>
                                    Requestor:
                                </td>
                                <td colspan="3" class="b-bottom">
                                    <b>{{$r->requisitioner}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Details:
                                    <div class="row">
                                        @forelse(Helper::mis_request_nature() as $nature)
                                            @forelse($nature as $n)
                                                <div class="col-md-6 col-sm-6">
                                                    {{$n == $r->nature_of_request ? '☑' : '☐'}}  {{$n}}
                                                </div>
                                            @empty
                                            @endforelse
                                        @empty
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="b-bottom" style="padding-top: 10px">
                                    {{$r->request_details}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding-top: 15px">
                                    Approved by: (PPD/MIS Officer)
                                    <br><br><br>
                                    __________________________
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="vertical-align: top; padding: 10px 10px 30px 10px">
                        <table style="width: 100%">
                            <tbody>
                            <tr>
                                <td colspan="2"><br></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;" >MIS Personnel</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Details</td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%" >
                            <tbody>
                            <tr>
                                <td style="width: 50%;">☐ IN-HOUSE</td>
                                <td style="width: 50%;">☐ OUTSOURCE</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top: 5px">Recommendation (if any)</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>

                            </tbody>
                        </table>
                        <table style="width: 100%; margin-top: 10px">
                            <tbody>
                            <tr>
                                <td style="width: 35%;">Period Completed:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td style="width: 35%;">Requestor:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td style="width: 35%;">Date of Acceptance:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr style="border: 1px dashed grey; margin-top: 10px;" class="no-margin">
        <p class="no-margin" style="font-size: 8px; margin-bottom: 5px"><i class="fa fa-scissors"></i> CUT HERE</p>
        <div class="print-wrapper exempt-font">
            <table style="width: 100%;" class="text-center" >
                <tbody>
                <tr>
                    <td style="width: 30%; padding-top: 20px" class="b-top b-left">
                        <img src="{{asset('images/sra.png')}}" width="80" alt="logo" style="float: right"/>
                    </td>
                    <td class="b-top" style="; padding-top: 20px">
                        <b>SUGAR REGULATORY ADMINISTRATION</b>
                        <br>North Avenue, Diliman, Quezon City
                    </td>
                    <td style="width: 30%;" class="b-top b-right"></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-strong b-left b-right" style="padding-top: 10px">
                        SERVICE REQUEST FORM <br><br>
                    </td>
                </tr>
                </tbody>
            </table>
            <table style="width: 100%;" class="tbl-bordered text-center">
                <tbody>
                <tr>
                    <td style="width: 50%; vertical-align: top; padding: 5px; letter-spacing: 2px">
                        <b>JOB REQUEST</b>
                    </td>
                    <td style="width: 50%; vertical-align: top; padding: 5px; letter-spacing: 2px"">
                    <b>ACTION TAKEN</b>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px; vertical-align: top">
                        <table style="width: 100%;" class="tbl-padded">
                            <tbody>
                            <tr>
                                <td style="width: 15%">Date:</td>
                                <td style="width: 35%;" class="text-strong b-bottom">{{Carbon::parse($r->created_at)->format('M d, Y')}}</td>
                                <td style="width: 15%">Ctrl#:</td>
                                <td class="text-strong b-bottom">{{$r->request_no}}</td>
                            </tr>
                            <tr>
                                <td>
                                    Requestor:
                                </td>
                                <td colspan="3" class="b-bottom">
                                    <b>{{$r->requisitioner}}</b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    Details:
                                    <div class="row">
                                        @forelse(Helper::mis_request_nature() as $nature)
                                            @forelse($nature as $n)
                                                <div class="col-md-6 col-sm-6">
                                                    {{$n == $r->nature_of_request ? '☑' : '☐'}}  {{$n}}
                                                </div>
                                            @empty
                                            @endforelse
                                        @empty
                                        @endforelse
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="b-bottom" style="padding-top: 10px">
                                    {{$r->request_details}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="padding-top: 15px">
                                    Approved by: (PPD/MIS Officer)
                                    <br><br><br>
                                    __________________________
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                    <td style="vertical-align: top; padding: 10px 10px 30px 10px">
                        <table style="width: 100%">
                            <tbody>
                            <tr>
                                <td colspan="2"><br></td>
                            </tr>
                            <tr>
                                <td style="width: 30%;" >MIS Personnel</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td colspan="2">Details</td>
                            </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%" >
                            <tbody>
                            <tr>
                                <td style="width: 50%;">☐ IN-HOUSE</td>
                                <td style="width: 50%;">☐ OUTSOURCE</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding-top: 5px">Recommendation (if any)</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="b-bottom"><br></td>
                            </tr>

                            </tbody>
                        </table>
                        <table style="width: 100%; margin-top: 10px">
                            <tbody>
                            <tr>
                                <td style="width: 35%;">Period Completed:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td style="width: 35%;">Requestor:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            <tr>
                                <td style="width: 35%;">Date of Acceptance:</td>
                                <td class="b-bottom"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print()
    </script>
@endsection