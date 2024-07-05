@extends('layouts.modal-content')

@section('modal-header')
    {{ $employee->fullname }}
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right" role="group" aria-label="...">
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p1' ]) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print PDS Page 1</a>&nbsp;
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p2' ]) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print PDS Page 2</a>&nbsp;
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p3' ]) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print PDS Page 3</a>&nbsp;
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p4' ]) }}" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-print"></i> Print PDS Page 4</a>&nbsp;
            </div>
        </div>
    </div>
    <br>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Details</a></li>
            <li><a href="#tab_2" data-toggle="tab">Educational Background</a></li>
            <li><a href="#tab_3" data-toggle="tab">Trainings</a></li>
            <li><a href="#tab_4" data-toggle="tab">Eligibilities</a></li>
            <li><a href="#tab_5" data-toggle="tab">Work Experience</a></li>
            <li><a href="#tab_6" data-toggle="tab">Voluntary Works</a></li>
            <li><a href="#tab_7" data-toggle="tab">Recognitions</a></li>
            <li><a href="#tab_8" data-toggle="tab">Organizations</a></li>
            <li><a href="#tab_9" data-toggle="tab">Special Skills</a></li>
            <li><a href="#tab_10" data-toggle="tab">References</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="row">
                    <div class="col-md-6">
                        <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                            Personal Information
                        </p>

                        <div class="well well-sm">
                            <dl class="dl-horizontal" style="padding-bottom:60px;">
                                <dt>Fullname:</dt>
                                <dd>{{ $employee->fullname }}</dd>
                                <dt>Date of Birth:</dt>
                                <dd>{{ __dataType::date_parse($employee->date_of_birth, 'M d, Y') }}</dd>
                                <dt>Place of Birth:</dt>
                                <dd>{{ $employee->place_of_birth }}</dd>
                                <dt>Sex:</dt>
                                <dd>{{ $employee->sex }}</dd>
                                <dt>Civil Status:</dt>
                                <dd>{{ $employee->civil_status }}</dd>
                                <dt>Height:</dt>
                                <dd>{{ $employee->height }}</dd>
                                <dt>Weight:</dt>
                                <dd>{{ $employee->weight }}</dd>
                                <dt>Blood Type:</dt>
                                <dd>{{ $employee->blood_type }}</dd>
                                <dt>Tel No:</dt>
                                <dd>{{ $employee->tel_no }}</dd>
                                <dt>Cell No:</dt>
                                <dd>{{ $employee->cell_no }}</dd>
                                <dt>Email Address:</dt>
                                <dd>{{ $employee->email }}</dd>
                                <dt>Citizenship:</dt>
                                <dd>{{ $employee->citizenship }}</dd>
                                <dt>Residential Address:</dt>
                                <dd>{{ optional($employee->employeeAddress)->fullResAddress }}</dd>
                                <dt>Permanent Address:</dt>
                                <dd>{{  optional($employee->employeeAddress)->fullPermAddress }}</dd>
                            </dl>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                            Appointment Details
                        </p>

                        <div class="well well-sm">
                            <dl class="dl-horizontal">
                                <dt>Employee No:</dt>
                                <dd>{{ $employee->employee_no }}</dd>
                                <dt>Status:</dt>
                                <dd>{{ $employee->is_active }}</dd>
                                <dt>Position:</dt>
                                <dd>{{ $employee->plantilla->position ?? $employee->position}}</dd>
                                <dt>Salary/Job Grade:</dt>
                                <dd>{{ $employee->salary_grade }}</dd>
                                <dt>Step Increment:</dt>
                                <dd>{{ $employee->step_inc }}</dd>
                                <dt>Appointment Status:</dt>
                                <dd>{{ $employee->appointment_status }}</dd>
                                <dt>Item No:</dt>
                                <dd>{{ $employee->item_no }}</dd>
                                <dt>Monthly Basic:</dt>
                                <dd>
                                    {{ Helper::toNumber($employee->incentive_monthly_basic, 2) }}
                                </dd>
                                <dt>ACA:</dt>
                                <dd>{{ Helper::toNumber($employee->aca, 2) }}</dd>
                                <dt>PERA:</dt>
                                <dd>{{ Helper::toNumber($employee->pera, 2) }}</dd>
                                <dt>Food Subsidy:</dt>
                                <dd>{{ Helper::toNumber($employee->food_subsidy, 2) }}</dd>
                                <dt>RA:</dt>
                                <dd>{{ Helper::toNumber($employee->ra, 2) }}</dd>
                                <dt>TA:</dt>
                                <dd>{{ Helper::toNumber($employee->ta, 2) }}</dd>
                                <dt>Government Service:</dt>
                                <dd>{{ __dataType::date_parse($employee->firstday_gov, 'M d, Y') }}</dd>
                                <dt>First Day in  SRA:</dt>
                                <dd>{{ __dataType::date_parse($employee->firstday_sra, 'M d, Y') }}</dd>
                                <dt>Appointment Date:</dt>
                                <dd>{{ __dataType::date_parse($employee->appointment_date, 'M d, Y') }}</dd>
                                <dt>Adjustment Date:</dt>
                                <dd>{{ __dataType::date_parse($employee->adjustment_date, 'M d, Y') }}</dd>

                            </dl>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                            Personal ID's
                        </p>

                        <div class="well well-sm">
                            <dl class="dl-horizontal">
                                <dt>GSIS:</dt>
                                <dd>{{ $employee->gsis }}</dd>
                                <dt>SSS:</dt>
                                <dd>{{ $employee->sss }}</dd>
                                <dt>PHILHEALTH:</dt>
                                <dd>{{ $employee->philhealth }}</dd>
                                <dt>TIN:</dt>
                                <dd>{{ $employee->tin }}</dd>
                                <dt>HDMF:</dt>
                                <dd>{{ $employee->hdmf }}</dd>
                                <dt>GSIS:</dt>
                                <dd>{{ $employee->gsis }}</dd>


                            </dl>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                            Family Info
                        </p>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="well well-sm">
                                    <dl class="dl-horizontal">
                                        <dt>Fathers Name</dt>
                                        <dd>{{ optional($employee->employeeFamilyDetail)->father_firstname . " " . substr(optional($employee->employeeFamilyDetail)->father_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->father_lastname }}</dd>
                                        <dt>Mothers Name:</dt>
                                        <dd>{{ optional($employee->employeeFamilyDetail)->mother_firstname . " " . substr(optional($employee->employeeFamilyDetail)->mother_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->mother_lastname }}</dd>
                                        <dt>Spouse Name:</dt>
                                        <dd>{{ optional($employee->employeeFamilyDetail)->spouse_firstname . " " . substr(optional($employee->employeeFamilyDetail)->spouse_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->spouse_lastname }}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="well well-sm">
                                    <center><b>CHILDREN</b></center>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <th>Date of Birth</th>
                                        </tr>
                                        @foreach($employee->employeeChildren()->populate() as $data)
                                            <tr>
                                                <td>{{ $data->fullname }}</td>
                                                <td>{{ __dataType::date_parse($data->date_of_birth, 'M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

                @if($employee->employeeEducationalBackground->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Level</th>
                            <th>Name of School</th>
                            <th>Course</th>
                            <th>Graduate Year</th>
                        </tr>
                        @foreach($employee->employeeEducationalBackground()->populate() as $data)
                            <tr>
                                <td>{{ $data->level }}</td>
                                <td>{{ $data->school_name }}</td>
                                <td>{{ $data->course }}</td>
                                <td>{{ $data->graduate_year }}</td>
                            </tr>
                        @endforeach

                    </table>
                @endif
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_3">
                @if($employee->employeeTraining->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Topics</th>
                            <th>Conducted by</th>
                            <th>Date</th>
                            <th>Venue</th>
                        </tr>
                        @foreach($employee->employeeTraining()->populate() as $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->conducted_by }}</td>
                                <td>
                                    @if(__dataType::date_parse($data->date_from, 'M') == __dataType::date_parse($data->date_to, 'M'))
                                        {{ __dataType::date_parse($data->date_from, 'M d') .' - '. __dataType::date_parse($data->date_to, 'd, Y') }}
                                    @else
                                        {{ __dataType::date_parse($data->date_from, 'M d, Y') .' - '. __dataType::date_parse($data->date_to, 'M d, Y') }}
                                    @endif
                                </td>
                                <td>{{ $data->venue }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_4">
            @if($employee->employeeEligibility->isEmpty())
                <div style="padding :5px;">
                    <center><h4>No Records found!</h4></center>
                </div>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>Eligibility</th>
                        <th>Level</th>
                        <th>Rating</th>
                    </tr>
                    @foreach($employee->employeeEligibility()->populate() as $data)
                        <tr>
                            <td>{{ $data->eligibility }}</td>
                            <td>{{ $data->level }}</td>
                            <td>{{ $data->rating }}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
            </div>

            <div class="tab-pane" id="tab_5">
                @if($employee->employeeExperience->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Company</th>
                            <th>Position</th>
                            <th>Appointment Status</th>
                        </tr>
                        @foreach($employee->employeeExperience()->populate() as $data)
                            <tr>
                                <td>{{ $data->company }}</td>
                                <td>{{ $data->position }}</td>
                                <td>{{ $data->appointment_status }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_6">
                @if($employee->employeeVoluntaryWork->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Name of Organization</th>
                            <th>Position</th>
                        </tr>
                        @foreach($employee->employeeVoluntaryWork()->populate() as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->position }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_7">
                @if($employee->employeeRecognition->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Title</th>
                        </tr>
                        @foreach($employee->employeeRecognition()->populate() as $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_8">
                @if($employee->employeeOrganization->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Name of Organization</th>
                        </tr>
                        @foreach($employee->employeeOrganization()->populate() as $data)
                            <tr>
                                <td>{{ $data->name }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_9">
                @if($employee->employeeSpecialSkill->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Special Skills or Hobies</th>
                        </tr>
                        @foreach($employee->employeeSpecialSkill()->populate() as $data)
                            <tr>
                                <td>{{ $data->description }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="tab-pane" id="tab_10">
                @if($employee->employeeReference->isEmpty())
                    <div class="callout callout-success">
                        <h4>No data found!</h4>
                    </div>
                @else
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Tel No.</th>
                        </tr>
                        @foreach($employee->employeeReference()->populate() as $data)
                            <tr>
                                <td>{{ $data->fullname }}</td>
                                <td>{{ $data->address }}</td>
                                <td>{{ $data->tel_no }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('modal-footer')
    <div class="row">
        <x-html.timestamp-footer :source-data="$employee" cols="11"/>
        <div class="col-md-1">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

