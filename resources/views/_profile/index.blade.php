@php
    /** @var \App\Models\Employee $employee **/
    $employee->load(['employeeAddress','employeeFamilyDetail','employeeChildren'])
@endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Profile</x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row">
        <div class="col-md-3 col-xl-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Profile Settings</h5>
                </div>

                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab" aria-selected="true">
                        Account
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#educ" role="tab" aria-selected="false" tabindex="-1">
                        Education & Eligibility
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#service-records" role="tab" aria-selected="false" tabindex="-1">
                        Service Records
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#trainings" role="tab" aria-selected="false" tabindex="-1">
                        Trainings
                    </a>
                    <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#password" role="tab" aria-selected="false" tabindex="-1">
                        Password
                    </a>

                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="account" role="tabpanel">

                    <div class="card">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body">

                                <div class="row">
                                    <div class="col-md-9">
                                        <h3 class="text-strong">{{$employee->full['LFEM']}} <span class="float-end">{{$employee->employee_no}}</span></h3>
                                        <div class="row">
                                            <div class="col-md-6 col-xl-4 col-xxl-3">
                                                <dl class="dl-horizontal" style="">
                                                    <dt>Sex:</dt>
                                                    <dd>{{ $employee->sex }}</dd>
                                                    <dt>Date of Birth:</dt>
                                                    <dd>{{ __dataType::date_parse($employee->date_of_birth, 'M d, Y') }}</dd>
                                                    <dt>Place of Birth:</dt>
                                                    <dd>{{ $employee->place_of_birth ?? '-'}}</dd>
                                                    <dt>Age:</dt>
                                                    <dd>{{ Carbon::parse($employee->date_of_birth)->age }} years old</dd>
                                                    <dt>Civil Status:</dt>
                                                    <dd>{{ $employee->civil_status ?? '-'}}</dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-6 col-xl-4 col-xxl-3">
                                                <dl class="dl-horizontal" style="">
                                                    <dt>Tel No:</dt>
                                                    <dd>{{ $employee->tel_no ?? '-'}}</dd>
                                                    <dt>Cell No:</dt>
                                                    <dd>{{ $employee->cell_no ?? '-'}}</dd>
                                                    <dt>Email Address:</dt>
                                                    <dd>{{ $employee->email ?? '-'}}</dd>
                                                    <dt>Residential Address:</dt>
                                                    <dd>{{ $employee->employeeAddress->fullResAddress ?? '-'}}</dd>
                                                    <dt>Permanent Address:</dt>
                                                    <dd>{{ $employee->employeeAddress->fullPermAddress ?? '-'}}</dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-6 col-xl-4 col-xxl-3">
                                                <dl class="dl-horizontal" style="">
                                                    <dt>Position:</dt>
                                                    <dd>{{ $employee->plantilla->position ?? $employee->position ?? '-'}}</dd>
                                                    <dt>Item No:</dt>
                                                    <dd>{{ $employee->plantilla->item_no ?? '-'}}</dd>
                                                    <dt>SG/JG & Step:</dt>
                                                    <dd>{{ $employee->salary_grade ?? '-' }}{{ $employee->step_inc != null ? ', '.$employee->step_inc : ''}}</dd>
                                                    <dt>Date of Original Appointment:</dt>
                                                    <dd>{{ Helper::dateFormat($employee->firstday_gov) ?? '-'}}</dd>
                                                    <dt>First day in SRA:</dt>
                                                    <dd>{{ Helper::dateFormat($employee->firstday_sra) ?? '-'}}</dd>
                                                    <dt>Appointment Status:</dt>
                                                    <dd>{{ $employee->appointment_status ?? '-'}}</dd>
                                                </dl>
                                            </div>
                                            <div class="col-md-6 col-xl-4 col-xxl-3">
                                                <dl class="dl-horizontal" style="">
                                                    <dt>GSIS BP No:</dt>
                                                    <dd>{{ $employee->gsis ?? '-' }}</dd>
                                                    <dt>PhilHealth.:</dt>
                                                    <dd>{{ $employee->philhealth ?? '-' }}</dd>
                                                    <dt>TIN:</dt>
                                                    <dd>{{ $employee->tin ?? '-' }}</dd>
                                                    <dt>PAG-IBIG:</dt>
                                                    <dd>{{ $employee->hdmf ?? '-' }}</dd>
                                                </dl>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            @if(file_exists(public_path('symlink/employee_pics/uploaded_50/'.Auth::user()->employee->photo)))
                                                <img alt="Charles Hall" src="{{asset('symlink/employee_pics/uploaded_300/'.Auth::user()->employee->photo)}}" class="rounded img-responsive mt-2" width="250">
                                            @else
                                                <img  src="{{asset('images/avatar.jpeg')}}" class="rounded-circle img-responsive mt-2" width="128" height="128">
                                            @endif
                                        </div>
                                    </div>
                                </div>


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Family info</h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">

                                    <dl class="dl-horizontal" style="">
                                        <dt>Father's Last Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->father_lastname ?? '-' }}</dd>
                                        <dt>Father's Middle Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->father_middlename ?? '-' }}</dd>
                                        <dt>Father's First Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->father_firstname ?? '-' }}</dd>
                                        <dt>Name extension:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->father_name_ext ?? '-' }}</dd>
                                    </dl>

                                </div>
                                <div class="col-4">
                                    <dl class="dl-horizontal" style="">
                                        <dt>Mother's Last Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->mother_lastname ?? '-' }}</dd>
                                        <dt>Mother's Middle Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->mother_middlename ?? '-' }}</dd>
                                        <dt>Mother's First Name:</dt>
                                        <dd>{{ $employee->employeeFamilyDetail->mother_firstname ?? '-' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-4">

                                    <p class="text-strong mb-1">Children:</p>
                                    @if(!empty($employee->employeeChildren))
                                        <ul>
                                            @foreach($employee->employeeChildren as $child /** @var \App\Models\EmployeeChildren $child **/)
                                                <li>{{$child->fullname}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="educ" role="tabpanel">
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
                </div>

                <div class="tab-pane fade" id="service-records" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Service Records</h5>
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Position</th>
                                    <th>Appointment Status</th>
                                    <th>Salary</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $serviceRecords = $employee->employeeServiceRecord->sortByDesc('sequence_no');
                                @endphp
                                @forelse($serviceRecords as $serviceRecord)
                                    <tr>
                                        <td>{{Helper::dateFormat($serviceRecord->from_date,'M. d, Y')}}</td>
                                        <td>{{Helper::dateFormat($serviceRecord->to_date,'M. d, Y')}}</td>
                                        <td>{{$serviceRecord->position}}</td>
                                        <td>{{$serviceRecord->appointment_status}}</td>
                                        <td class="text-end">{{Helper::toNumber($serviceRecord->salary)}}</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="trainings" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Trainings</h5>
                            <table class="table table-striped table-bordered table-sm">
                                <thead>
                                <tr>
                                    <th style="width: 50%">Title</th>
                                    <th>Started</th>
                                    <th>Ended</th>
                                    <th>Detailed Period</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $trainings = $employee->employeeTraining->sortByDesc('sequence_no');
                                @endphp
                                @forelse($trainings as $training)
                                    <tr>
                                        <td>{{$training->title}}</td>
                                        <td>{{Helper::dateFormat($training->date_from,'M. d, Y')}}</td>
                                        <td>{{Helper::dateFormat($training->date_to,'M. d, Y')}}</td>
                                        <td>{{$training->detailed_period}}</td>
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Password</h5>

                            <form id="change-pass-form">

                                <div class="row">
                                    <x-forms.input label="Current Password" name="old_pass" cols="12 mb-3" type="password"/>
                                    <x-forms.input label="New Password" name="new_pass" cols="12 mb-3" type="password"/>
                                    <x-forms.input label="Verify New Password" name="new_pass2" cols="12 mb-3" type="password"/>
                                </div>

                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save changes</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#change-pass-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.profile.update_password")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Password successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })

    </script>
@endsection