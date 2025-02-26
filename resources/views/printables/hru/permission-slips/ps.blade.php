@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        .ps-container table td{
            padding: 5px;
        }
    </style>
    <div style="font-family: Cambria;">
        @foreach($pss as $ps)
            @for($i = 0; $i < 3 ;$i++)
                <div class="ps-container">
                    <div>
                        <table style="width: 100%; font-size: 14px" class="b-top b-bottom b-left b-right">
                            <tr>
                                <td style="width: 30%"  rowspan="2">
                                    <img src="{{asset('images/sra.png')}}" style="width: 100px; float: right">
                                </td>
                                <td class="text-center" style="width: 40%;" rowspan="2">
                                    <span style="font-size: 14px">
                                        <b>SUGAR REGULATORY ADMINISTRATION</b> <br>
                                    </span>
                                    <span style="font-size: 11px">
                                    North Avenue, Diliman, Quezon City <br>
                                    Telephone Number: 8-9297187 <br><br>
                                    </span>

                                    <b>REVISED PERMISSION SLIP FORM</b> <br>
                                    <span style="font-size: 11px">(Effective 02/14/2025)</span>
                                </td>
                                <td class="text-right text-top">
                                    <small><span>{{$ps->ps_no}}</span></small>
                                </td>

                            </tr>
                            <tr>
                                <td class="text-bottom text-right"  style="font-size: 12px">
                                    @if($ps->personal_official == 'PERSONAL')
                                        PS. No <u><b>{{$ps->ps_frequency}}</b></u> for the Month of <u><b>{{Carbon::make($ps->date)->format('M Y')}}</b></u>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;">
                            <tr class=" b-bottom b-left b-right">
                                <td style="width: 20%">Date validity:</td>
                                <td style="width: 20%;">{{Carbon::make($ps->date)->format('m/d/Y')}}</td>
                                <td>
                                    <span style="font-size: 15px">{{$ps->personal_official == 'PERSONAL' ? '☑' : '☐'}}</span> Personal
                                </td>
                                <td>
                                    <span style="font-size: 15px">{{$ps->personal_official == 'OFFICIAL' ? '☑' : '☐'}}</span> Official
                                </td>
                                <td style="width: 10%">

                                </td>
                                <td>
                                    <span style="font-size: 15px">{{$ps->direct_nondirect == 'DIRECT' ? '☑' : '☐'}} </span> Direct
                                </td>
                                <td>
                                    <span style="font-size: 15px">{{$ps->direct_nondirect == 'NON-DIRECT' ? '☑' : '☐'}}</span> Non-direct
                                </td>
                            </tr>
                            <tr class=" b-bottom b-left b-right">
                                <td>
                                    Name of Employee:
                                </td>
                                <td colspan="6">
                                    <b>{{$ps->employee_name}}</b>
                                </td>
                            </tr>
                            <tr class=" b-bottom b-left b-right">
                                <td>
                                    Purpose:
                                </td>
                                <td colspan="6">
                                    {{$ps->purpose}}
                                </td>
                            </tr>
                            <tr class=" b-bottom b-left b-right">
                                <td>
                                    Destination(s):
                                </td>
                                <td colspan="6">
                                    {{$ps->destination}}
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;" class=" b-bottom b-left b-right">
                            <tr>
                                <td style="width: 30%;">
                                    Mode of transportation allowed/used:
                                </td>
                                @foreach(\App\Swep\Helpers\Arrays::modesOfTransportation() as $modeOfTransportation)
                                    <td style="width: {{ 70 / count(\App\Swep\Helpers\Arrays::modesOfTransportation()) }}%">
                                        <span style="font-size: 15px">{{$ps->mode_of_transportation == $modeOfTransportation ? '☑' : '☐'}}</span> {{$modeOfTransportation}}
                                    </td>
                                @endforeach

                            </tr>
                        </table>
                        <table style="width: 100%; font-size: 10px" class=" b-bottom b-left b-right">
                            <tr>
                                <td>
                                    Provision: For Official P.S. <br>
                                    <ol>
                                        <li>
                                            Permission slip shall be prepared in 3 copies: 1 copy for HRS, 1 copy for the Security Guard at the exit gate, and I copy for the concerned employee(s), to be attached to their Daily Time Record (DTR)
                                        </li>
                                        <li>
                                            The approved permission siip is valid within a 50-kilometer radius and shall be used exclusively for Official Business as specified. Any unauthorized use or deviation from its stated purpose will hold the employee accountable for misappropriation.
                                        </li>
                                        <li>
                                            Unauthorized alterations and insertions of this form is strictly prohibited and subject to administrative sanctions as per existing rules and regulations.
                                        </li>
                                    </ol>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;" class="b-left b-right b-bottom">
                            <tr>
                                <td style="width: 50%;">Recommended by:</td>
                                <td class="b-left">Approved by:</td>
                            </tr>
                            <tr>
                                <td class="text-center b-left">
                                    <b>{{$ps->supervisor_name}}</b> <br>
                                    <i><small>{{$ps->supervisor_position}}</small></i>
                                    <br>
                                    <small><p style="margin: 0px"> Date: <u><b>{{Helper::dateFormat($ps->supervisor_date,'m/d/Y')}}</b></u></p></small>
                                </td>
                                <td class="text-center b-left">
                                    _________________________________________ <br>
                                    <i><small>HR Office</small></i>
                                    <br>
                                    <small><p style="margin: 0px"> Date: <u>______________________</u></p></small>

                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;" class=" b-bottom b-left b-right">
                            <tr>
                                <td>
                                    To be filled by the Guard on duty: <br>
                                    Time of departure: ___________________ <br>
                                    Time of return:    ___________________
                                </td>
                                <td>
                                    Time spent/consumed: _______________
                                </td>
                            </tr>
                        </table>
                        <div class="text-right" style="font-size: 10px">
                            AFD-VIS-HRS-01 <br>
                            Effectivity date: Feb. 14, 2025
                        </div>
                    </div>
                    @if($i % 2 == 0)
                        <hr style="border: 1px dashed grey" class="no-margin">
                        <p class="no-margin" style="font-size: 8px; margin-bottom: 5px"><i class="fa fa-scissors"></i> CUT HERE</p>
                    @else
                        <div style=" break-after: page"></div>
                    @endif
                    @if($i == 2)
                        <div style=" break-after: page"></div>
                    @endif
                </div>
            @endfor

        @endforeach
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        print();

    </script>
@endsection