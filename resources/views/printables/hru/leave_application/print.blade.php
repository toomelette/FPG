@php
    $rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<style>
    div.cont {
        position: absolute;
        top :30px;
        left: 100px;
    }
    .padded{
        padding: 5px;
    }
</style>
<div style="font-family: Arial">
    <div style="break-after: page">
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
                    <br><br>
                    <p class="text-center no-margin"><b>{{$la->recommended_by}}</b></p>
                    <p class="text-center"><u><small>{{$la->recommended_by_position}}</small></u></p>
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
    <div style="font-family: 'Arial Narrow'">
        <table style="width: 100%; margin-bottom: 15px" class="tbl-bordered">
            <tr>
                <td class="text-center" style="padding: 10px; font-size: 14px">
                    <b>INSTRUCTIONS AND REQUIREMENTS</b>
                </td>
            </tr>
        </table>

        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: top">
                    Application for any type of leave shall be made on this Form and <u><b>to be
                            accomplished at least in duplicate</b></u> with documentary requirements, as
                    follows: <br><br>
                    <ol>
                        <li class="text-justify">
                            <b>Vacation leave*</b> <br>
                            <p>
                                It shall be filed five (5) days in advance, whenever possible, of the
                                effective date of such leave. Vacation leave within in the Philippines or
                                abroad shall be indicated in the form for purposes of securing travel
                                authority and completing clearance from money and work
                                accountabilities.
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Mandatory/Forced leave</b> <br>
                            <p>
                                Annual five-day vacation leave shall be forfeited if not taken during the
                                year. In case the scheduled leave has been cancelled in the exigency
                                of the service by the head of agency, it shall no longer be deducted from
                                the accumulated vacation leave. Availment of one (1) day or more
                                Vacation Leave (VL) shall be considered for complying the
                                mandatory/forced leave subject to the conditions under Section 25, Rule
                                XVI of the Omnibus Rules Implementing E.O. No. 292.
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Sick leave*</b> <br>
                            <ul>
                                <li>It shall be filed immediately upon employee's return from such leave.</li>
                                <li>If filed in advance or exceeding five (5) days, application shall be
                                    accompanied by a <u>medical certificate</u>. In case medical consultation
                                    was not availed of, an <u>affidavit</u> should be executed by an applicant.</li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>Maternity leave* – 105 days</b> <br>
                            <ul>
                                <li>Proof of pregnancy e.g. ultrasound, doctor’s certificate on the
                                    expected date of delivery</li>
                                <li>Accomplished Notice of Allocation of Maternity Leave Credits (CS
                                    Form No. 6a), if needed</li>
                                <li>Seconded female employees shall enjoy maternity leave with full pay
                                    in the recipient agency.</li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>Paternity leave – 7 days</b> <br>
                            <p>
                                Proof of child’s delivery e.g. birth certificate, medical certificate and
                                marriage contract
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Special Privilege leave – 3 days</b> <br>
                            <p>
                                It shall be filed/approved for at least one (1) week prior to availment,
                                except on emergency cases. Special privilege leave within the
                                Philippines or abroad shall be indicated in the form for purposes of
                                securing travel authority and completing clearance from money and work
                                accountabilities.
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Solo Parent leave – 7 days</b> <br>
                            <p>
                                It shall be filed in advance or whenever possible five (5) days before
                                going on such leave with updated Solo Parent Identification Card.
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Study leave* – up to 6 months</b> <br>
                            <ul>
                                <li>Shall meet the agency’s internal requirements, if any;</li>
                                <li>Contract between the agency head or authorized representative and
                                    the employee concerned.</li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>VAWC leave – 10 days</b> <br>
                            <ul>
                                <li>It shall be filed in advance or immediately upon the woman
                                    employee’s return from such leave.</li>
                                <li>
                                    It shall be accompanied by any of the following supporting documents:
                                    <ol type="a">
                                        <li>Barangay Protection Order (BPO) obtained from the barangay;</li>
                                        <li>Temporary/Permanent Protection Order (TPO/PPO) obtained from
                                            the court;</li>
                                        <li>If the protection order is not yet issued by the barangay or the court,
                                            a certification issued by the Punong Barangay/Kagawad or
                                            Prosecutor or the Clerk of Court that the application for the BPO, TPO or PPO has been filed with the said office shall be sufficient
                                            to support the application for the ten-day leave; or</li>

                                    </ol>
                                </li>
                            </ul>
                        </li>
                    </ol>
                </td>
                <td style=" vertical-align: top">
                    <ul style="list-style-type: none;">
                        <li>
                            <ul>
                                <li>
                                    In the absence of the BPO/TPO/PPO or the certification, a police
                                    report specifying the details of the occurrence of violence on the
                                    victim and a medical certificate may be considered, at the
                                    discretion of the immediate supervisor of the woman employee
                                    concerned.
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ol start="10">
                        <li class="text-justify">
                            <b>Rehabilitation leave* – up to 6 months</b> <br>
                            <ul>
                                <li>Application shall be made within one (1) week from the time of the
                                    accident except when a longer period is warranted.
                                </li>
                                <li>Letter request supported by relevant reports such as the police
                                    report, if any,</li>
                                <li>Medical certificate on the nature of the injuries, the course of
                                    treatment involved, and the need to undergo rest, recuperation, and
                                    rehabilitation, as the case may be.
                                </li>
                                <li>
                                    Written concurrence of a government physician should be obtained
                                    relative to the recommendation for rehabilitation if the attending
                                    physician is a private practitioner, particularly on the duration of the
                                    period of rehabilitation.
                                </li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>Special leave benefits for women* – up to 2 months</b> <br>
                            <ul>
                                <li>The application may be filed in advance, that is, at least five (5) days
                                    prior to the scheduled date of the gynecological surgery that will be
                                    undergone by the employee. In case of emergency, the application
                                    for special leave shall be filed immediately upon employee’s return
                                    but during confinement the agency shall be notified of said surgery.

                                </li>
                                <li>The application shall be accompanied by a medical certificate filled
                                    out by the proper medical authorities, e.g. the attending surgeon
                                    accompanied by a clinical summary reflecting the gynecological
                                    disorder which shall be addressed or was addressed by the said
                                    surgery; the histopathological report; the operative technique used
                                    for the surgery; the duration of the surgery including the perioperative period (period of confinement around surgery); as well as
                                    the employees estimated period of recuperation for the same.
                                </li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>Special Emergency (Calamity) leave – up to 5 days</b> <br>
                            <ul>
                                <li>The special emergency leave can be applied for a maximum of five
                                    (5) straight working days or staggered basis within thirty (30) days
                                    from the actual occurrence of the natural calamity/disaster. Said
                                    privilege shall be enjoyed once a year, not in every instance of
                                    calamity or disaster.
                                </li>
                                <li>The head of office shall take full responsibility for the grant of special
                                    emergency leave and verification of the employee’s eligibility to be
                                    granted thereof. Said verification shall include: validation of place of
                                    residence based on latest available records of the affected
                                    employee; verification that the place of residence is covered in the
                                    declaration of calamity area by the proper government agency; and
                                    such other proofs as may be necessary.
                                </li>
                            </ul>
                        </li>
                        <li class="text-justify">
                            <b>Monetization of leave credits</b> <br>
                            <p>
                                Application for monetization of fifty percent (50%) or more of the
                                accumulated leave credits shall be accompanied by letter request to
                                the head of the agency stating the valid and justifiable reasons.

                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Terminal leave*</b> <br>
                            <p>
                                Proof of employee’s resignation or retirement or separation from the
                                service.
                            </p>
                        </li>
                        <li class="text-justify">
                            <b>Adoption Leave</b> <br>
                            <p>
                                Application for adoption leave shall be filed with an authenticated
                                copy of the Pre-Adoptive Placement Authority issued by the
                                Department of Social Welfare and Development (DSWD).

                            </p>
                        </li>
                    </ol>
                </td>
            </tr>
        </table>
    </div>
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