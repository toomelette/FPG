@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi']}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}}</x-slot:subtitle>
    </x-adminkit.html.page-title>

    <form id="edit-employee-form" autocomplete="off">
        <div class="tab mb-1">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Personal Information</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Family Information</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Appointment Details</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-4" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Other Records</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-5" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Other Questions</a></li>
            </ul>

            <div class="tab-content">
                    <div class="tab-pane active show" id="tab-1" role="tabpanel">
                        <div class="alert alert-primary" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Personal Information</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-10">
                                <div class="row mb-2">
                                    <x-forms.input label="Last Name" name="lastname" cols="3" :value="$employee ?? null"/>
                                    <x-forms.input label="First Name" name="firstname" cols="3" :value="$employee ?? null"/>
                                    <x-forms.input label="Middle Name" name="middlename" cols="2" :value="$employee ?? null"/>
                                    <x-forms.select label="Name Ext" name="name_ext" cols="1" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::name_extensions()"/>
                                    <x-forms.input label="Birthday" name="date_of_birth" cols="3" :value="$employee ?? null" type="date"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.select label="Sex" name="sex" cols="1" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::sex()"/>
                                    <x-forms.input label="Place of Birth" name="place_of_birth" cols="5" :value="$employee ?? null"/>
                                    <x-forms.select label="Civil Status" name="civil_status" cols="2" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::civil_status()"/>
                                    <x-forms.input label="Height" name="height" cols="1" :value="$employee ?? null"/>
                                    <x-forms.input label="Weight" name="weight" cols="1" :value="$employee ?? null"/>
                                    <x-forms.input label="Blood Type" name="blood_type" cols="2" :value="$employee ?? null"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Telephone No" name="tel_no" cols="2" :value="$employee ?? null"/>
                                    <x-forms.input label="Cellphone No" name="cell_no" cols="2" :value="$employee ?? null"/>
                                    <x-forms.input label="Email Address" name="email" cols="3" :value="$employee ?? null"/>
                                    <x-forms.select label="Ctznship" name="citizenship" cols="1" :value="$employee ?? null" :options="['Filipino' => 'Filipino', 'Dual Citizenship' => 'Dual Citizenship']"/>
                                    <x-forms.select label="Ctznship Type" name="citizenship_type" cols="2" :value="$employee ?? null" :options="['BB' => 'by birth', 'BN' => 'by naturalization']"/>
                                    <x-forms.input label="If (Dual Citizenship)" name="dual_citizenship_country" cols="2" :value="$employee ?? null"/>
                                </div>
                                <div class="row">
                                    <x-forms.input label="Agency Employee No" name="agency_no" cols="2" :value="$employee ?? null"/>
                                    <x-forms.input label="Government Issued ID" name="gov_id" cols="2" :value="$employee ?? null"/>
                                    <x-forms.input label="ID/License/Passport No" name="license_passport_no" cols="2" :value="$employee ?? null"/>
                                    <x-forms.input label="Date/Place of Issuance" name="id_date_issue" cols="2" :value="$employee ?? null"/>
                                </div>
                            </div>
                            <style>
                                .jquery-uploader-card,.jquery-uploader-select-card{
                                    width: 100% !important;
                                    height: 215px !important;
                                    margin: 0 !important;
                                }
                                .jquery-uploader-preview-container{
                                    padding: 0 !important;
                                }
                            </style>
                            <div class="col-md-2">
                                <label>Photo:</label>
                                <input type="text" id="employee_photo" value="" />
                            </div>
                        </div>

                        <div class="alert alert-success mb-1" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Address</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                    Residential address
                                </p>
                                <fieldset id="residential_fieldset">
                                    <div class="row mb-2">
                                        <x-forms.input label="Block" name="res_address_block" cols="2" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Street" name="res_address_street" cols="5" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Village" name="res_address_village" cols="5" :value="$employee->employeeAddress ?? null"/>
                                    </div>
                                    <div class="row mb-2">
                                        <x-forms.input label="Barangay" name="res_address_barangay" cols="6" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="City" name="res_address_city" cols="6" :value="$employee->employeeAddress ?? null"/>
                                    </div>
                                    <div class="row mb-2">
                                        <x-forms.input label="Province" name="res_address_province" cols="6" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Zipcode" name="res_address_zipcode" cols="3" :value="$employee->employeeAddress ?? null"/>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <p class="page-header-sm" style="border-bottom: 1px solid #cedbe1">
                                    <span class="text-info text-strong">Permanent address</span>

                                    <span class="checkbox float-end no-margin text-b">
                                      <label>
                                        <input type="checkbox" id="fill_perm" value=""> the same as Residential Address
                                      </label>
                                    </span>
                                </p>
                                <fieldset id="permanent_fieldset">
                                    <div class="row mb-2">
                                        <x-forms.input label="Block" name="perm_address_block" cols="2" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Street" name="perm_address_street" cols="5" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Village" name="perm_address_village" cols="5" :value="$employee->employeeAddress ?? null"/>
                                    </div>
                                    <div class="row mb-2">
                                        <x-forms.input label="Barangay" name="perm_address_barangay" cols="6" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="City" name="perm_address_city" cols="6" :value="$employee->employeeAddress ?? null"/>
                                    </div>
                                    <div class="row mb-2">
                                        <x-forms.input label="Province" name="perm_address_province" cols="6" :value="$employee->employeeAddress ?? null"/>
                                        <x-forms.input label="Zipcode" name="perm_address_zipcode" cols="3" :value="$employee->employeeAddress ?? null"/>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-2" role="tabpanel">
                        <div class="alert alert-warning mb-1" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Parents' Information</strong>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                    Father's Information
                                </p>
                                <div class="row">
                                    <x-forms.input label="Last name" name="father_lastname" cols="3" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="First name" name="father_firstname" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Middle name" name="father_middlename" cols="3" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Name ext" name="father_name_ext" cols="2" :value="$employee->employeeFamilyDetail ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                    Mother's Information
                                </p>
                                <div class="row">
                                    <x-forms.input label="Last name" name="mother_lastname" cols="3" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="First name" name="mother_firstname" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Middle name" name="mother_middlename" cols="3" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Name ext" name="mother_name_ext" cols="2" :value="$employee->employeeFamilyDetail ?? null"/>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="alert alert-info mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Spouse's Information</strong>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Last name" name="spouse_lastname" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="First name" name="spouse_firstname" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Middle name" name="spouse_middlename" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.select label="Name ext" name="spouse_name_ext" cols="3" :value="$employee->employeeFamilyDetail ?? null" :options="\App\Swep\Helpers\Arrays::name_extensions()"/>
                                    <x-forms.input label="Occupation" name="spouse_occupation" cols="4" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Employer/Business Name" name="spouse_employer" cols="5" :value="$employee->employeeFamilyDetail ?? null"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Business Address" name="spouse_business_address" cols="6" :value="$employee->employeeFamilyDetail ?? null"/>
                                    <x-forms.input label="Telephone No" name="spouse_tel_no" cols="6" :value="$employee->employeeFamilyDetail ?? null"/>
                                </div>

                            </div>
                            <div class="col-6">
                                <div class="alert alert-success mb-3" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Children Information</strong>
                                    </div>
                                </div>

                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Fullname *</th>
                                        <th>Date of Birth</th>
                                        <th style="width: 40px">
                                            <button id="children_add_row" type="button" class="btn btn-outline-secondary btn-sm"><i class="fa fw fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    <tbody id="children_table_body">
                                    @foreach($employee->employeeChildren as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_children['. $key .'][fullname]', 'Fullname', $data->fullname, '') !!}
                                            </td>

                                            <td>
                                                {!! __form::textbox_for_dt('row_children['. $key .'][date_of_birth]', $data->date_of_birth, $data->date_of_birth,'','date') !!}
                                            </td>

                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-3" role="tabpanel">
                        <div class="alert alert-primary mb-2" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Appointment Details</strong>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <x-forms.input label="Employee No." name="employee_no" cols="2" :value="$employee ?? null"/>
                            <x-forms.select label="Item No" name="item_no" id="item-no" cols="3" :value="$employee ?? null" :options="[]"/>
                            <x-forms.input label="Position" name="position" cols="3" :value="$employee ?? null"/>
                            <x-forms.select label="Appt. Status" name="appointment_status" cols="2" :value="$employee ?? null" :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeApptStatus(),'option','value')"/>
                            <x-forms.select label="JG" name="salary_grade" class="sgXsi" cols="1" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::jobGradeLevels()"/>
                            <x-forms.select label="SI" name="step_inc" class="sgXsi" cols="1" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
                        </div>

                        <div class="row mb-2">
                            <x-forms.select label="Responsibility Center" name="resp_center" cols="4" id="resp_center" class="select2-parent-card" :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::groupedRespCodes('all')"/>
                            <x-forms.input label="Monthly Basic" name="monthly_basic" cols="2" id="monthly_basic" :value="$employee ?? null"/>
                            <x-forms.input label="Food Subsidy" name="food_subsidy" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="Date of Original Appointment" name="firstday_gov" cols="2" type="date" :value="$employee ?? null"/>
                            <x-forms.input label="First Day in SRA" name="firstday_sra" cols="2" type="date" :value="$employee ?? null"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Appointment Date" name="appointment_date" cols="2" type="date" :value="$employee ?? null"/>
                            <x-forms.input label="Date of Last Promotion" name="adjustment_date" cols="2" type="date" :value="$employee ?? null"/>
                            <x-forms.select label="Station" name="station" cols="2" :value="$employee ?? null" :options="['QC' => 'QC', 'VIS' => 'VIS']"/>
                            <x-forms.select label="Groupings" name="locations" cols="2"  :value="$employee ?? null" :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeGroupings(),'value','option')"/>
                            <x-forms.select label="Assignment" name="assignment" cols="2"  :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::employeeAssignments()"/>
                            <x-forms.select label="Payroll Group" name="payroll_group" cols="2"  :value="$employee ?? null" :options="\App\Swep\Helpers\Arrays::payrollGroups()"/>
                        </div>
                        <div class="row mb-3">
                            <x-forms.select label="Status" name="is_active" cols="2" id="is_active" :value="$employee ?? null" :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeStatus(),'value','option')"/>
                            <x-forms.input label="Date of Separation" name="date_of_separation" type="date" :container-class="'is_active_toggle '.($employee?->is_active == 'ACTIVE' ? 'visually-hidden' : '')" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="Reason of Separation" name="reason_of_separation" cols="2" :container-class=" 'is_active_toggle '.($employee?->is_active == 'ACTIVE' ? 'visually-hidden' : '')" :value="$employee ?? null"/>

                        </div>

                        <div class="alert alert-success mb-2" role="alert">
                            <div class="alert-message p-1 text-center">
                                <strong>Personal IDs</strong>
                            </div>
                        </div>

                        <div class="row">
                            <x-forms.input label="GSIS BP No." name="gsis" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="PHILHEALTH" name="philhealth" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="TIN" name="tin" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="SSS" name="sss" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="HDMF" name="hdmf" cols="2" :value="$employee ?? null"/>
                            <x-forms.input label="HDMF Premiums" name="hdmfpremiums" cols="2" :value="$employee ?? null"/>

                        </div>


                    </div>
                    <div class="tab-pane" id="tab-4" role="tabpanel">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="alert alert-info mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Voluntary Works</strong>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Name of Organization *</th>
                                        <th>Address</th>
                                        <th>Date from *</th>
                                        <th>Date to *</th>
                                        <th>Hours</th>
                                        <th>Position</th>
                                        <th style="width: 40px">
                                            <button id="vw_add_row" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fw fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    <tbody id="vw_table_body">

                                    @forelse($employee->employeeVoluntaryWork as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][name]', 'Name of Organization', $data->name, '') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][address]', 'Address of Organization', $data->address,'') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][date_from]', '',$data->date_from,'','date') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][date_to]', '',$data->date_to,'','date') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][hours]', 'Hours', $data->hours,'') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_vw['. $key .'][position]', 'Position', $data->position,'') !!}
                                            </td>
                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4">
                                <div class="alert alert-warning mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Recognitions</strong>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Title *</th>
                                        <th style="width: 40px">
                                            <button id="recognition_add_row" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    <tbody id="recognition_table_body">
                                    @forelse($employee->employeeRecognition as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_recognition['. $key .'][title]', 'Title', $data->title, '') !!}
                                            </td>
                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-4">
                                <div class="alert alert-primary mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Organizations</strong>
                                    </div>
                                </div>

                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Name of Organization *</th>
                                        <th style="width: 40px">
                                            <button id="org_add_row" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                        </th>
                                    </tr>

                                    <tbody id="org_table_body">

                                    @forelse($employee->employeeOrganization as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_org['. $key .'][name]', 'Name of Organization', $data->name, '') !!}
                                            </td>
                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-4">
                                <div class="alert alert-success mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>Special Skills</strong>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Special Skills or Hobies *</th>
                                        <th style="width: 40px">
                                            <button id="ss_add_row" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    <tbody id="ss_table_body">

                                    @forelse($employee->employeeSpecialSkill as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_ss['. $key .'][description]', 'Special Skills or Hobies', $data->description, '') !!}
                                            </td>
                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-secondary mb-1" role="alert">
                                    <div class="alert-message p-1 text-center">
                                        <strong>References</strong>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <tr>
                                        <th>Fullname *</th>
                                        <th>Address *</th>
                                        <th>Tel No. *</th>
                                        <th style="width: 40px">
                                            <button id="reference_add_row" type="button" class="btn btn-sm btn-outline-secondary"><i class="fa fw fa-plus"></i></button>
                                        </th>
                                    </tr>
                                    <tbody id="reference_table_body">

                                    @forelse($employee->employeeReference as $key => $data)
                                        <tr>
                                            <td>
                                                {!! __form::textbox_for_dt('row_reference['. $key .'][fullname]', 'Fullname', $data->fullname, '') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_reference['. $key .'][address]', 'Address', $data->address, '') !!}
                                            </td>
                                            <td>
                                                {!! __form::textbox_for_dt('row_reference['. $key .'][tel_no]', 'Telephone No.', $data->tel_no, '') !!}
                                            </td>
                                            <td>
                                                <button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-5" role="tabpanel">
                        <h3>Please answer the following questions:</h3>
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-message">
                                Are you related by consanguinity or affinity to the appointing or recommending authority, or to the
                                chief of bureau or office or to the person who has immediate supervision over you in the Office,
                                Bureau or Department where you will be apppointed,
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. within the third degree?" name="q_34_a" cols="6" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                                <div class="row">
                                    <x-forms.select label="b. within the fourth degree (for Local Government Unit - Career Employees)?" name="q_34_b" cols="6" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details:" name="q_34_b_yes_details" cols="12"  :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Have you ever been found guilty of any administrative offense?" name="q_35_a" cols="6" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details:" name="q_35_a_yes_details" cols="12"  :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="b. Have you been criminally charged before any court?" name="q_35_b" cols="6" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details (Date Filed)" name="q_35_b_yes_details_1" cols="4" type="date" :value="$employee->employeeOtherQuestion ?? null"/>
                                    <x-forms.input label="(Status of Case/s)" name="q_35_b_yes_details_2" cols="8"  :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by any court or tribunal?" name="q_36" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details" name="q_36_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Have you ever been separated from the service in any of the following modes: resignation, retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) in the public or private sector?" name="q_37" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details" name="q_37_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Have you ever been a candidate in a national or local election held within the last year (except Barangay election)?" name="q_38_a" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details" name="q_38_a_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="b. Have you resigned from the government service during the three (3)-month period before the last election to promote/actively campaign for a national or local candidate?" name="q_38_b" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details" name="q_38_b_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Have you acquired the status of an immigrant or permanent resident of another country?" name="q_39" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details (Country)" name="q_39_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <div class="alert alert-secondary" role="alert">
                            <div class="alert-message">
                                Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="a. Are you a member of any indigenous group?" name="q_40_a" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details" name="q_40_a_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="b. Are you a person with disability?" name="q_40_b" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details (ID No.)" name="q_40_b_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.select label="c. Are you a solo parent?" name="q_40_c" cols="12" :options="[0 => 'NO', 1 => 'YES']" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <x-forms.input label="If YES, give details (ID No.)" name="q_40_c_yes_details" cols="12" :value="$employee->employeeOtherQuestion ?? null"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>

        <div class="card">
            <div class="card-body p-2">
                <button type="submit" class="btn btn-primary float-end"><i class="fa fa-check"></i> Save</button>
            </div>
        </div>
    </form>


@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#employee_photo").uploader({
            defaultValue: [
                    @if($employee->photo != null && File::exists(public_path('symlink/employee_pics/uploaded/'.$employee->photo)))
                {
                    name: "employeePhoto",
                    url: "/symlink/employee_pics/uploaded/{{$employee->photo}}",
                },
                @endif
            ],
            ajaxConfig: {
                url: "{{route('dashboard.employee.photo',$employee->slug)}}",
                method: "post",
                paramsBuilder: function (uploaderFile) {
                    let form = new FormData();
                    form.append("file", uploaderFile.file)
                    return form
                },
                ajaxRequester: function (config, uploaderFile, progressCallback, successCallback, errorCallback) {
                    $.ajax({
                        url: config.url,
                        contentType: false,
                        processData: false,
                        method: config.method,
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        data: config.paramsBuilder(uploaderFile),
                        success: function (response) {
                            toast('success','Photo successfully uploaded.');
                            successCallback();
                        },
                        error: function (response) {
                            console.error("Error", response)
                            errorCallback("Error")
                        },
                        xhr: function () {
                            let xhr = new XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function (e) {
                                let progressRate = (e.loaded / e.total) * 100;
                                progressCallback(progressRate)
                            })
                            return xhr;
                        }
                    })
                },
                responseConverter: function (uploaderFile, response) {
                    return {
                        url: response.data,
                        name: null,
                    }
                },
            },
        }).on("file-remove", function(e) {
            Swal.fire({
                title: 'Remove photo?',
                html: 'Are you sure you want to delete this photo?',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash"></i> Remove',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    return $.ajax({
                        url : '{{route('dashboard.employee.photo',$employee->slug)}}',
                        type: 'DELETE',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                    })
                        .then(response => {
                            return  response;
                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    Swal.fire({
                        title: result.value,
                        icon : 'success',
                    })
                }else{
                    location.reload();
                }
            })
        });

        @if(\Illuminate\Support\Facades\Request::get("page") != null)
            const page = '{{\Illuminate\Support\Facades\Request::get("page")}}';
        @else
            const page = 0;
        @endif
        $("#edit-employee-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{ route('dashboard.employee.update', $employee->slug) }}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    unmark_required(form)
                    form.get(0).reset();
                    remove_loading_btn(form);
                    markTabs(form);
                    @if($employee->locations == 'COS-VISAYAS' || $employee->locations == 'COS-LUZMIN')
                    window.location.replace('{{route("dashboard.employee.index_cos")}}?toPage='+page+'&mark='+res.slug);
                    @else
                    window.location.replace('{{route("dashboard.employee.index")}}?toPage='+page+'&mark='+res.slug);
                    @endif
                },
                error: function (res) {
                    errored(form,res);
                    markTabs(form);
                }
            })
        })


        var data = {!! \App\Swep\Helpers\Arrays::payPlantillasWithItemNumberAndDetails() !!};
        $("#item-no").select2({
            data: data,
            dropdownParent: $(".card"),
        });
        $('#item-no').on('select2:select', function (e) {
            var data = e.params.data;
            $("input[name='position']").val(data.position);
            $("select[name='salary_grade']").val(data.salary_grade);
            $("select[name='step_inc']").val(data.step_inc);
            $('.sgXsi').trigger('change');
        });

        $('#item-no').val({{$employee->item_no}});
        $('#item-no').trigger('change');



        $("#children_add_row").on("click", function() {
            var i = $("#children_table_body").children().length;
            var content ='<tr>' +

                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_children[' + i + '][fullname]" class="form-control" placeholder="Fullname">' +
                '</div>' +
                '</td>' +

                '<td>' +
                '<div class="form-group no-margin">' +
                '<div class="input-group">' +
                '<input name="row_children[' + i + '][date_of_birth]" type="date" class="form-control datepicker" placeholder="mm/dd/yy">' +
                '</div>' +
                '</div>' +
                '</td>' +

                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';

            $("#children_table_body").append($(content));

        });
        $("#vw_add_row").on("click", function() {
            var i = $("#vw_table_body").children().length;
            var content ='<tr>' +

                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_vw[' + i + '][name]" class="form-control" placeholder="Name">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_vw[' + i + '][address]" class="form-control" placeholder="Address">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<div class="input-group">' +
                '<input name="row_vw[' + i + '][date_from]" type="date" class="form-control">' +
                '</div>' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<div class="input-group">' +
                '<input name="row_vw[' + i + '][date_to]" type="date" class="form-control">' +
                '</div>' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_vw[' + i + '][hours]" class="form-control" placeholder="Hours">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_vw[' + i + '][position]" class="form-control" placeholder="Position">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';

            $("#vw_table_body").append($(content));
        });
        $("#recognition_add_row").on("click", function() {
            var i = $("#recognition_table_body").children().length;
            var content ='<tr>' +

                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_recognition[' + i + '][title]" class="form-control" placeholder="Title">' +
                '</div>' +
                '</td>' +

                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';
            $("#recognition_table_body").append($(content));
        });
        $("#org_add_row").on("click", function() {
            var i = $("#org_table_body").children().length;
            var content ='<tr>' +

                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_org[' + i + '][name]" class="form-control" placeholder="Name">' +
                '</div>' +
                '</td>' +

                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';

            $("#org_table_body").append($(content));

        });
        $("#ss_add_row").on("click", function() {
            var i = $("#ss_table_body").children().length;
            var content ='<tr>' +
                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_ss[' + i + '][description]" class="form-control" placeholder="Special Skills or Hobies">' +
                '</div>' +
                '</td>' +

                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';
            $("#ss_table_body").append($(content));
        });
        $("#reference_add_row").on("click", function() {
            var i = $("#reference_table_body").children().length;
            var content ='<tr>' +
                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_reference[' + i + '][fullname]" class="form-control" placeholder="Fullname">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_reference[' + i + '][address]" class="form-control" placeholder="Address">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<div class="form-group no-margin">' +
                '<input type="text" name="row_reference[' + i + '][tel_no]" class="form-control" placeholder="Telephone No.">' +
                '</div>' +
                '</td>' +


                '<td>' +
                '<button id="delete_row" type="button" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>' +
                '</td>' +

                '</tr>';
            if(i < 3){
                $("#reference_table_body").append($(content));
            }else{
                toast('warning','You can only add a maximum of 3 references.','Warning!');
            }
        });

        $("#is_active").change(function (){
            let val = $(this).val();
            if(val === 'ACTIVE'){
                $(".is_active_toggle").addClass('visually-hidden');
            }else{
                $(".is_active_toggle").removeClass('visually-hidden');
            }
        })

        $("body").on('change','.sgXsi',function(){
            var jobGrades = {!! \App\Swep\Helpers\Arrays::jobGrades() !!};
            $("#monthly_basic").val($.number(jobGrades[$('select[name="salary_grade"]').val()][$('select[name="step_inc"]').val()],2));
        });

        $("#fill_perm").change(function () {
            let prop = $(this).prop('checked');
            if(prop == true){
                $("#residential_fieldset input").each(function () {
                    let this_name = $(this).attr('name');
                    let perm_counterpart = this_name.replaceAll('res_','perm_');
                    $("input[name="+perm_counterpart+"]").val($(this).val());
                })
            }
        })
    </script>
@endsection