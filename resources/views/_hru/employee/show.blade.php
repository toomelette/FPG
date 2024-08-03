@extends('adminkit.modal')

@section('modal-header')
    {{$employee->full['LFEMi']}} - <small>{{$employee->plantilla->position ?? $employee->position}}</small>
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group float-end" role="group" aria-label="...">
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p1' ]) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-print"></i> Print PDS Page 1</a>
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p2' ]) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-print"></i> Print PDS Page 2</a>
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p3' ]) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-print"></i> Print PDS Page 3</a>
                <a href="{{ route('dashboard.employee.print_pds', [ $employee->slug, 'p4' ]) }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa fa-print"></i> Print PDS Page 4</a>
            </div>
        </div>
    </div>


    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Details</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Educational Background</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Trainings</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-4" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Eligibilities</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-5" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Work Experience</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-6" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Other Records</a></li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1" role="tabpanel">

                <div class="row">
                    <div class="col-6">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Personal Information</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <dl class="dl-horizontal" style="">
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
                                    <dt>Tel No:</dt>
                                    <dd>{{ $employee->tel_no }}</dd>
                                    <dt>Cell No:</dt>
                                    <dd>{{ $employee->cell_no }}</dd>
                                    <dt>Email Address:</dt>
                                    <dd>{{ $employee->email }}</dd>
                                </dl>
                            </div>
                            <div class="col-6">
                                <dl class="dl-horizontal" style="">
                                    <dt>Height:</dt>
                                    <dd>{{ $employee->height }}</dd>
                                    <dt>Weight:</dt>
                                    <dd>{{ $employee->weight }}</dd>
                                    <dt>Blood Type:</dt>
                                    <dd>{{ $employee->blood_type }}</dd>
                                    <dt>Citizenship:</dt>
                                    <dd>{{ $employee->citizenship }}</dd>
                                    <dt>Residential Address:</dt>
                                    <dd>{{ optional($employee->employeeAddress)->fullResAddress }}</dd>
                                    <dt>Permanent Address:</dt>
                                    <dd>{{  optional($employee->employeeAddress)->fullPermAddress }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="alert alert-success mb-2" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Appointment Details</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <dl class="dl-horizontal">
                                    <dt>Employee No:</dt>
                                    <dd>{{ $employee->employee_no }}</dd>
                                    <dt>Position:</dt>
                                    <dd>{{ $employee->plantilla->position ?? $employee->position}}</dd>
                                    <dt>Appointment Status:</dt>
                                    <dd>{{ $employee->appointment_status }}</dd>
                                    <dt>Item No:</dt>
                                    <dd>{{ $employee->item_no }}</dd>
                                    <dt>Salary/Job Grade:</dt>
                                    <dd>{{ $employee->salary_grade }}</dd>
                                    <dt>Step Increment:</dt>
                                    <dd>{{ $employee->step_inc }}</dd>
                                    <dt>Monthly Basic:</dt>
                                    <dd>
                                        {{ Helper::toNumber($employee->jg_monthly_basic, 2) }}
                                    </dd>
                                </dl>
                            </div>
                            <div class="col-6">
                                <dl class="dl-horizontal">
                                    <dt>Status:</dt>
                                    <dd>{{ $employee->is_active }}</dd>
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
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="alert alert-warning" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Personal IDs</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <dl class="dl-horizontal">
                                    <dt>GSIS:</dt>
                                    <dd>{{ $employee->gsis }}</dd>
                                    <dt>SSS:</dt>
                                    <dd>{{ $employee->sss }}</dd>
                                    <dt>PHILHEALTH:</dt>
                                    <dd>{{ $employee->philhealth }}</dd>
                                </dl>
                            </div>
                            <div class="col-6">
                                <dl class="dl-horizontal">
                                    <dt>TIN:</dt>
                                    <dd>{{ $employee->tin }}</dd>
                                    <dt>HDMF:</dt>
                                    <dd>{{ $employee->hdmf }}</dd>
                                    <dt>GSIS:</dt>
                                    <dd>{{ $employee->gsis }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="alert alert-info" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Parents and Spouse's Information</strong>
                            </div>
                        </div>
                        <dl class="dl-horizontal">
                            <dt>Fathers Name</dt>
                            <dd>{{ optional($employee->employeeFamilyDetail)->father_firstname . " " . substr(optional($employee->employeeFamilyDetail)->father_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->father_lastname }}</dd>
                            <dt>Mothers Name:</dt>
                            <dd>{{ optional($employee->employeeFamilyDetail)->mother_firstname . " " . substr(optional($employee->employeeFamilyDetail)->mother_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->mother_lastname }}</dd>
                            <dt>Spouse Name:</dt>
                            <dd>{{ optional($employee->employeeFamilyDetail)->spouse_firstname . " " . substr(optional($employee->employeeFamilyDetail)->spouse_middlename , 0, 1) . ". " . optional($employee->employeeFamilyDetail)->spouse_lastname }}</dd>
                        </dl>
                    </div>
                    <div class="col-5">
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Children Information</strong>
                            </div>
                        </div>
                        <table class="table table-bordered table-sm">
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
            <div class="tab-pane" id="tab-2" role="tabpanel">
                <table class="table table-bordered">
                    <tr>
                        <th>Level</th>
                        <th>Name of School</th>
                        <th>Course</th>
                        <th>Graduate Year</th>
                    </tr>
                    @forelse($employee->employeeEducationalBackground as $data)
                        <tr>
                            <td>{{ $data->level }}</td>
                            <td>{{ $data->school_name }}</td>
                            <td>{{ $data->course }}</td>
                            <td>{{ $data->graduate_year }}</td>
                        </tr>
                    @empty
                        No data
                    @endforelse

                </table>

            </div>
            <div class="tab-pane" id="tab-3" role="tabpanel">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Topics</th>
                        <th>Conducted by</th>
                        <th>Date</th>
                        <th>Venue</th>
                    </tr>
                    @forelse($employee->employeeTraining as $data)
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
                    @empty
                    @endforelse
                </table>
            </div>
            <div class="tab-pane" id="tab-4" role="tabpanel">
                <table class="table table-bordered">
                    <tr>
                        <th>Eligibility</th>
                        <th>Level</th>
                        <th>Rating</th>
                    </tr>
                    @forelse($employee->employeeEligibility as $data)
                        <tr>
                            <td>{{ $data->eligibility }}</td>
                            <td>{{ $data->level }}</td>
                            <td>{{ $data->rating }}</td>
                        </tr>
                    @empty
                    @endforelse
                </table>
            </div>
            <div class="tab-pane" id="tab-5" role="tabpanel">
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>Company</th>
                        <th>Position</th>
                        <th>Appointment Status</th>
                    </tr>
                    @forelse($employee->employeeExperience as $data)
                        <tr>
                            <td>{{ $data->company }}</td>
                            <td>{{ $data->position }}</td>
                            <td>{{ $data->appointment_status }}</td>
                        </tr>
                    @empty
                    @endforelse
                </table>
            </div>
            <div class="tab-pane" id="tab-6" role="tabpanel">
                <div class="row">
                    <div class="col-4">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Voluntary Works</strong>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Name of Organization</th>
                                <th>Position</th>
                            </tr>
                            @forelse($employee->employeeVoluntaryWork as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->position }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No data found.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                    <div class="col-4">
                        <div class="alert alert-success" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Recognitions</strong>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Title</th>
                            </tr>
                            @forelse($employee->employeeRecognition as $data)
                                <tr>
                                    <td>{{ $data->title }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </table>
                    </div>
                    <div class="col-4">
                        <div class="alert alert-warning" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Organizations</strong>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Name of Organization</th>
                            </tr>
                            @forelse($employee->employeeOrganization as $data)
                                <tr>
                                    <td>{{ $data->name }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <div class="alert alert-info" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Special Skills</strong>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Special Skills or Hobies</th>
                            </tr>
                            @forelse($employee->employeeSpecialSkill as $data)
                                <tr>
                                    <td>{{ $data->description }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </table>
                    </div>
                    <div class="col-5">
                        <div class="alert alert-danger" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>References</strong>
                            </div>
                        </div>

                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Tel No.</th>
                            </tr>
                            @forelse($employee->employeeReference as $data)
                                <tr>
                                    <td>{{ $data->fullname }}</td>
                                    <td>{{ $data->address }}</td>
                                    <td>{{ $data->tel_no }}</td>
                                </tr>
                            @empty
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('modal-footer')
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection