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
                        <img  src="{{asset('images/avatar.jpeg')}}" class="rounded-circle img-responsive mt-2" style="width: 100%;">
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