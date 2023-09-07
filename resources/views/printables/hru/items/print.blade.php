@php
$rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')

@php
    $applicants = $item->applicants;
    $chunkBy = 3;
    $chunkedApplicants = $applicants->chunk($chunkBy);
@endphp

@forelse($chunkedApplicants as $applicants)
    <div style="break-after: page">
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="width: 70px">
                    <img src="{{asset('images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                </td>
                <td>
                    PRELIMINARY EVALUATION OF APPLICANTS FOR THE POSITION: <b>{{ $item->position }}</b> JOB GRADE {{$item->salary_grade}}
                    <b>ITEM NO: {{$item->item_no}}</b>
                    <br>
                    DIVISION/DEPARTMENT : <b>{{$item->place_of_assignment}}</b>
                </td>
            </tr>
        </table>
        <table class="tbl tbl-bordered tbl-padded" style="width: 100%;  font-size: 11px">
            <thead>
            <tr>
                <th>Name & Age</th>
                @forelse($applicants as $applicant)
                    <th style="width: 25%">
                        {{strtoupper($applicant->lastname)}}, {{strtoupper($applicant->firstname)}} {{strtoupper($applicant->middlename)}}
                    </th>
                @empty
                @endforelse
            </tr>
            <tr>
                <th>Position</th>
                @forelse($applicants as $applicant)
                    <th>
                        {{$applicant->position}}
                    </th>
                @empty
                @endforelse
            </tr>
            <tr>
                <th>Civil Status</th>
                @forelse($applicants as $applicant)
                    <th>
                        {{$applicant->civil_status}}
                    </th>
                @empty
                @endforelse
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    Education
                    <br>
                    {{$item->qs_education}}
                </td>

                @forelse($applicants as $applicant)
                    <td>
                        @forelse($applicant->educationalBackground as $education)
                            <b>{{$education->course}}</b><br>
                            {{$education->school}}<hr class="no-margin">
                        @empty
                        @endforelse
                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td>
                    Education
                    <br>
                    {{$item->qs_training}}
                </td>

                @forelse($applicants as $applicant)
                    <td>
                        @forelse($applicant->trainings as $training)
                            <b>{{$training->training}}</b> {{$training->from}} to {{$training->to}}, {{$training->number_of_hours}} - {{$training->conducted_by}}<hr class="no-margin">
                        @empty
                        @endforelse
                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td>
                    Experience
                    <br>
                    {{$item->qs_experience}}
                </td>

                @forelse($applicants as $applicant)
                    <td>
                        @forelse($applicant->workExperiences as $workExperience)
                            <b>{{$workExperience->position}}</b> {{$workExperience->from}} to {{$workExperience->to}} - {{$workExperience->company}}<hr class="no-margin">
                        @empty
                        @endforelse
                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td>
                    Eligibility
                    <br>
                    {{$item->qs_eligibility}}
                </td>

                @forelse($applicants as $applicant)
                    <td>
                        @forelse($applicant->eligibilities as $eligibility)
                            <b>{{$eligibility->eligibility}}</b> {{$eligibility->rating}}<hr class="no-margin">
                        @empty
                        @endforelse
                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td class="text-strong">POTENTIAL/APTITUDE</td>
                @forelse($applicants as $applicant)
                    <td>

                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td class="text-strong">Performance Appraisal Report (Evaluation)</td>
                @forelse($applicants as $applicant)
                    <td>

                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td class="text-strong">Average Point Score</td>
                @forelse($applicants as $applicant)
                    <td>

                    </td>
                @empty
                @endforelse
            </tr>
            <tr>
                <td class="text-strong">Remarks</td>
                @forelse($applicants as $applicant)
                    <td>

                    </td>
                @empty
                @endforelse
            </tr>
            </tbody>
        </table>
        <span style="font-size: 10px">
            <i><b>Note:</b> All information presented are based on Personal Data Sheets and other pertinent application documents duly submitted by the applicant.</i>
        </span>
        <br>
        <table style="width: 100%">
            <tr>
                <td style="width: 33%">
                    Prepared by:
                    <br><br><br>
                </td>
                <td>
                    Certified Correct:
                    <br><br><br>
                </td>
                <td>
                    Noted:
                    <br><br><br>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <b>LIPS B. BERMUDEZ</b><br>
                    HRMO III<br>
                    Member, HRMPSB Secretariat
                </td>
                <td class="text-center">
                    <b>LUCILLE MAE M. SY</b><br>
                    HRMO IV<br>
                    Alternate HRMPSB Secretariat
                </td>
                <td class="text-center">
                    <b>ATTY. JOHANA S. JADOC</b><br>
                    Manager III, AFD Visayas<br>
                    Human Resource Management Officer, HRMPSB
                </td>
            </tr>
        </table>
    </div>
@empty
@endforelse
@endsection

@section('scripts')
<script type="text/javascript">

    print();
</script>
@endsection