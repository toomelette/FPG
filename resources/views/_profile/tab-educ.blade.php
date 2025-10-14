<div class="card">
    <div class="card-body">
        <h5 class="card-title">Education</h5>
        <table class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <th>Level</th>
                <th>School</th>
                <th>Course</th>
                <th>From</th>
                <th>To</th>
                <th>Units</th>
                <th>Graduated</th>
                <th>Scholarship</th>
                <th>Honor</th>
            </tr>
            </thead>
            <tbody>
            @php
                $educs = $employee->employeeEducationalBackground->sortByDesc('date_to');
            @endphp
            @forelse($educs as $educ)
                <tr>
                    <td>{{$educ->level}}</td>
                    <td>{{$educ->school_name}}</td>
                    <td>{{$educ->course}}</td>
                    <td>{{$educ->date_from}}</td>
                    <td>{{$educ->date_to}}</td>
                    <td>{{$educ->units}}</td>
                    <td>{{$educ->graduate_year}}</td>
                    <td>{{$educ->scholarship}}</td>
                    <td>{{$educ->honor}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Eligibilities</h5>
        <table class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <th>Eligibility</th>
                <th>Level</th>
                <th>Rating</th>
                <th>Exam Place</th>
                <th>Exam Date</th>
                <th>License No.</th>
                <th>Validity</th>
            </tr>
            </thead>
            <tbody>
            @php
                $eligs = $employee->employeeEligibility->sortByDesc('exam_date');
            @endphp
            @forelse($eligs as $elig)
                <tr>
                    <td>{{$elig->eligibility}}</td>
                    <td>{{$elig->level}}</td>
                    <td>{{$elig->rating}}</td>
                    <td>{{$elig->exam_place}}</td>
                    <td>{{Helper::dateFormat($elig->exam_date)}}</td>
                    <td>{{$elig->license_no}}</td>
                    <td>{{$elig->license_validity}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Work Experience</h5>
        <table class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <th>Company</th>
                <th>Position</th>
                <th>From</th>
                <th>To</th>
                <th>Salary</th>
                <th>SG/JG</th>
                <th>Step</th>
                <th>Appt. Status</th>
                <th>Govt. Service</th>
            </tr>
            </thead>
            <tbody>
            @php
                $works = $employee->employeeExperience->sortByDesc('date_from');
            @endphp
            @forelse($works as $work)
                <tr>
                    <td>{{$work->company}}</td>
                    <td>{{$work->position}}</td>
                    <td>{{Helper::dateFormat($work->date_from)}}</td>
                    <td>{{Helper::dateFormat($work->date_to)}}</td>
                    <td>{{Helper::toNumber($work->salary)}}</td>
                    <td>{{$work->salary_grade}}</td>
                    <td>{{$work->step}}</td>
                    <td>{{$work->appointment_status}}</td>
                    <td class="text-center">
                        @if($work->is_gov_service == 1)
                            <i class="fa fa-check"></i>
                        @endif
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>