@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        ol li {
            margin-top: 10px;
        }
    </style>


    @forelse($cosEmps as $cosEmp)
        <div style="font-family: Cambria; text-align: justify; font-size: 16px; break-after: page">
            <div style="break-after: page">
                <p class="text-strong text-center" style="font-size: 20px">CONTRACT OF SERVICE</p>
                <br>
                <p class="text-strong">KNOW ALL MEN BY THESE PRESENTS:</p>
                <p>This Contract of Service is made and entered into by and between:</p>
                <p style="padding-left: 30px; padding-right: 20px">
                    <b>SUGAR REGULATORY ADMINISTRATION (SRA)</b> a Government Owned and Controlled Corporation (GOCC) created by
                    Executive Order No. 18, series of 1986, as amended, with principal office address
                    at Sugar Center Building, North Avenue, Diliman, Quezon City, by virtue of Administrative Order No. 1, Series of 2025
                    dated April 4, 2025 herein represented by Deputy Administrator for Administrative and Finance Department <b>ATTY. BRANDO D. NOROÑA</b>,
                    and hereinafter referred to as the <b>"FIRST PARTY"</b>
                </p>
                <p class="text-center">- and -</p>
                <p style="padding-left: 30px; padding-right: 20px">
                    <b>{{$cosEmp->employee->full['FMiLE']}}</b>, of legal age, Filipino, <b>{{Str::lower($cosEmp->other_data['civil_status'] ?? null)}}</b>, and
                    a resident of <b>{{Str::of($cosEmp->other_data['address'] ?? null)->upper()}}</b>, now and hereinafter referred to as the <b>“SECOND PARTY”</b>.
                </p>

                <p class="text-strong text-center">WITNESSETH:</p>
                <p style="text-indent: 30px;">
                    <b>WHEREAS</b>, the SRA, as a government-owned and controlled corporation,
                    is mandated to promote the growth and development of the sugarcane industry in partnership with the private sector,
                    to ensure economic viability of cane and sugar production and maintain a stable, sufficient supply of quality cane and sugar in the country;
                </p>
                <p style="text-indent: 30px;">
                    <b>WHEREAS</b>, SRA awaits for the full Implementation of SRA Organizational Strengthening;
                </p>
                <p style="text-indent: 30px;">
                    <b>WHEREAS</b>,
                    there is a need to hire the services of various Contract of Service personnel in different SRA Departments to assist, support, reinforce,
                    and augment the existing manpower in order to effectively deliver prompt services to the sugarcane industry and SRA Clienteles;
                </p>

                <p style="text-indent: 30px;">
                    <b>WHEREAS</b>, on <b>{{Helper::dateFormat($cosEmp->cos->memo_date ?? null,'F d, Y')}}</b> through <b>{{$cosEmp->cos->memo_code ?? null}}</b>,
                    Administrator Pablo Luis S. Azcona approved the request of the <b>{{$cosEmp->employee->responsibilityCenter->department_full ?? ''}}</b>
                    for the renewal of the <b>SECOND PARTY</b> for a period of six ({{Carbon::parse($cosEmp->cos->date_from)->diffInMonths(Carbon::parse($cosEmp->cos->date_to)) + 1 }}) months
                    from {{Carbon::parse($cosEmp->cos->date_from)->format('F d, Y')}} to {{Carbon::parse($cosEmp->cos->date_to)->format('F d, Y')}}.
                </p>


                <p style="text-indent: 30px;">
                    <b>NOW THEREFORE</b>, for and in consideration of the above premises, the <b>SECOND PARTY</b>
                    is hereby contracted as <b>{{Str::of($cosEmp->employee->position ?? null)}} - Contract of Service (COS)</b>
                    under the following terms and conditions, to wit:
                </p>

                <ol>
                    <li>That the <b>SECOND PARTY</b> will be renewed by the <b>FIRST PARTY</b> on a contractual basis  for a period of six ({{Carbon::parse($cosEmp->cos->date_from)->diffInMonths(Carbon::parse($cosEmp->cos->date_to)) + 1 }}) months from {{Carbon::parse($cosEmp->cos->date_from)->format('F d, Y')}} July 1, 2025 to {{Carbon::parse($cosEmp->cos->date_to)->format('F d, Y')}}.</li>
                    <li>

                        That the <b>SECOND PARTY</b> shall receive a monthly salary of
                        <b>Pesos:
                            {{ucwords(\NumberToWords\NumberToWords::transformNumber('en',$sal = intval(Helper::sanitizeAutonum((int) $cosEmp->employee->monthly_basic * 1))))}}
                        </b>
                        <b>(Php {{Helper::toNumber($sal)}})</b> to be paid on a quincenas basis, rates under SSL5, Tranche 1, Step 1 of SSL 5 inclusive of a premium of 20% of such salary or wage. <i>Provided, however,</i> that if he/she is required to render services outside of his/her official workstation, he/she may be allowed to collect <b>Actual Travelling Expenses</b> subject to pertinent guidelines duly issued by the <b>FIRST PARTY</b>. <i>Provided, further,</i> that he/she will be allowed to claim overtime pay for services rendered beyond government office hours in accordance with the duly established rules on government accounting.
                    </li>

                    <li>
                        That as contract of service personnel, the <b>SECOND PARTY</b> shall be assigned to the <b>{{$cosEmp->employee->responsibilityCenter->long_name ?? null}}</b> and is obliged to perform the duties and responsibilities of the position, hereto attached as <b>Annex “A”</b>.
                    </li>
                    <li>
                        That the <b> SECOND PARTY</b> shall report on site, at the <b>{{$cosEmp->employee->responsibilityCenter->long_name ?? null}}, {{$cosEmp->cos_assignment ?? null}}</b> from Monday to Friday, and shall work a minimum of eight (8) hours a day.
                    </li>
                    <li>
                        Either party may terminate this Contract of Service, but only for legal and justifiable causes or grounds by notifying the other party in writing, at least thirty (30) days before its intended termination. This Contract of Service may also be immediately terminated for serious violations of any of the conditions set forth herein.
                    </li>
                    <li>
                        Prior to resignation/separation from the office, the <b>SECOND PARTY</b> shall be obliged to turn-over all documents and other pending tasks, in whatever form, as well as government supplies and property in his/her possession to his/her immediate supervisor. Payment of the <b>SECOND PARTY’s</b> final pay shall be withheld until the said obligation is complied.
                    </li>
                    <li>
                        All outputs produced in the course of or as a result of this Contract shall belong to the <b>FIRST PARTY</b>.
                    </li>
                    <li>
                        The <b>SECOND PARTY</b> shall not use or divulge confidential or classified information officially known to them by reason of their office and not made available to the public, without the express consent of the <b>FIRST PARTY</b> or its duly authorized representative.
                    </li>
                    <li>
                        It is understood that this Contract of Service does not create an employer – employee relationship between the <b>FIRST PARTY</b> and <b>SECOND PARTY</b>.
                    </li>
                    <li>
                        The services rendered hereunder are not considered and will not be credited as government service and that the <b>SECOND PARTY</b> is not entitled to the benefits of a regular employee of the <b>FIRST PARTY</b>.
                    </li>
                    <li>
                        That in case the <b>SECOND PARTY</b> commits a violation of this Contract or any act or offense punishable by law against the <b>FIRST PARTY</b>, the latter may proceed against the former through any judicial or quasi-judicial recourse/s available, and before any proper office, including regular courts.
                    </li>
                    <li>
                        Any dispute, claim, controversy, or disagreement arising out of or in connection with this Contract of Service shall be notified in writing by one party to the other and the Parties hereto shall endeavor to settle such dispute amicably within thirty (30) calendar days after receipt of the written notification. In case of failure to come to an amicable settlement, such dispute, claim, controversy, or disagreement shall be tried exclusively in a competent court in Bacolod City.
                    </li>
                </ol>
                <br><br>
                <p style="text-indent: 30px;">
                    <b>IN WITNESS WHEREOF</b>, the parties have hereunto set their hands this ___ of _________ 20___ at Bacolod City.
                </p>
            </div>
            <div style="break-after: page">
                <p class="text-strong">
                    SUGAR REGULATORY ADMINISTRATION
                </p>
                <p>By: </p><br><br>
                <table style="width: 100%; font-size: inherit">
                    <tr>
                        <td style="width: 50%;" class="text-center">
                            <p class="no-margin"><b><u>ATTY. BRANDO D. NOROÑA</u></b></p>
                            FIRST PARTY
                        </td>
                        <td style="width: 50%;" class="text-center">
                            <p class="no-margin"><b><u>{{$cosEmp->employee->full['FMiLE']}}</u></b></p>
                            SECOND PARTY
                        </td>
                    </tr>
                </table>
                <br><br><br>
                <p class="text-center text-strong">
                    FUNDS AVAILABLE:<br><br><br>
                </p>

                <p class="text-center text-strong no-margin">
                    <u>{{$cosEmp->cos->funds_available ?? ''}}</u>
                </p>
                <p class="text-center">
                    {{$cosEmp->cos->funds_available_position ?? ''}}
                </p>

                <p class="text-center text-strong">
                    <br><br>
                    SIGNED IN THE PRESENCE OF:<br><br><br>
                </p>

                <table style="width: 100%; font-size: inherit">
                    <tr>
                        <td style="width: 50%;" class="text-center">
                            <p class="no-margin"><b><u>{{$cosEmp->other_data['witness_1_name'] ?? null}}</u></b></p>
                            <p class="no-margin">{{$cosEmp->other_data['witness_1_position'] ?? null}}</p>
                        </td>
                        <td style="width: 50%;" class="text-center">
                            <p class="no-margin"><b><u>{{$cosEmp->other_data['witness_2_name'] ?? null}}</u></b></p>
                            <p class="no-margin">{{$cosEmp->other_data['witness_2_position'] ?? null}}</p>
                        </td>
                    </tr>
                </table>
            </div>




            <p class="text-strong text-center">ACKNOWLEDGEMENT</p>
            <br>
            <p class="no-margin">
                Republic of the Philippines)
            </p>
            <p>
                Bacolod City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </p>
            <br>
            <p style="text-indent: 30px;">
                <b>BEFORE ME, </b> a notary public for and in Bacolod City, this ____ day of _____ 20__, personally appeared the following:
            </p>

            <table style="width: 100%; font-size: inherit" class="tbl-padded">
                <tr>
                    <td>Name</td>
                    <td>Valid ID</td>
                    <td> Issued on/at</td>
                </tr>
                <tr>
                    <td>
                        <b><u>ATTY. BRANDO D. NOROÑA   </u></b>
                    </td>
                    <td>
                        <u>SRA ID No. 6228-8</u>
                    </td>
                    <td>
                        <u>SRA Quezon City</u>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b><u>{{$cosEmp->employee->full['FMiLE']}}</u></b>
                    </td>
                    <td>
                        <u>{{$cosEmp->other_data['valid_id'] ?? null}}</u>
                    </td>
                    <td>
                        <u>{{$cosEmp->other_data['valid_id_issued_at'] ?? null}}</u>
                    </td>
                </tr>
            </table>
            <br>
            <p>
                Known to me to be the same persons who executed the foregoing instrument and acknowledgment to me that the same is their free and voluntary act and deed and of the entity he/she represents.
            </p>
            <p>
                The foregoing instrument refers to a Contract of Service consisting of four (4) pages including this page wherein the Acknowledgement is written, signed by the parties and their witnesses on each and every page herein.
            </p>
            <br><br><br>
            <p>
                Doc. No.  _____; <br>
                Page No.  _____; <br>
                Book No. _____;<br>
                Series of _____.

            </p>
        </div>
    @empty
    @endforelse



@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection