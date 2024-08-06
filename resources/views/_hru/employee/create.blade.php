@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Add Employee</x-slot:title>
    </x-adminkit.html.page-title>


    <form id="add-employee-form" autocomplete="off">
        <div class="tab mb-1">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Personal Information</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Family Information</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Appointment Details</a></li>
          </ul>

            <div class="tab-content">
                <div class="tab-pane active show" id="tab-1" role="tabpanel">
                    <div class="alert alert-primary" role="alert">
                        <div class="alert-message p-1 text-center">
                            <strong>Personal Information</strong>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="row mb-2">
                                <x-forms.input label="Last Name" name="lastname" cols="3" />
                                <x-forms.input label="First Name" name="firstname" cols="3" />
                                <x-forms.input label="Middle Name" name="middlename" cols="2" />
                                <x-forms.select label="Name Ext" name="name_ext" cols="1"  :options="\App\Swep\Helpers\Arrays::name_extensions()"/>
                                <x-forms.input label="Birthday" name="date_of_birth" cols="3"  type="date"/>
                            </div>
                            <div class="row mb-2">
                                <x-forms.select label="Sex" name="sex" cols="1"  :options="\App\Swep\Helpers\Arrays::sex()"/>
                                <x-forms.input label="Place of Birth" name="place_of_birth" cols="5" />
                                <x-forms.select label="Civil Status" name="civil_status" cols="2"  :options="\App\Swep\Helpers\Arrays::civil_status()"/>
                                <x-forms.input label="Height" name="height" cols="1" />
                                <x-forms.input label="Weight" name="weight" cols="1" />
                                <x-forms.input label="Blood Type" name="blood_type" cols="2" />
                            </div>
                            <div class="row mb-2">
                                <x-forms.input label="Telephone No" name="tel_no" cols="2" />
                                <x-forms.input label="Cellphone No" name="cell_no" cols="2" />
                                <x-forms.input label="Email Address" name="email" cols="3" />
                                <x-forms.select label="Ctznship" name="citizenship" cols="1"  :options="['Filipino' => 'Filipino', 'Dual Citizenship' => 'Dual Citizenship']"/>
                                <x-forms.select label="Ctznship Type" name="citizenship_type" cols="2"  :options="['BB' => 'by birth', 'BN' => 'by naturalization']"/>
                                <x-forms.input label="If (Dual Citizenship)" name="dual_citizenship_country" cols="2" />
                            </div>
                            <div class="row">
                                <x-forms.input label="Agency Employee No" name="agency_no" cols="2" />
                                <x-forms.input label="Government Issued ID" name="gov_id" cols="2" />
                                <x-forms.input label="ID/License/Passport No" name="license_passport_no" cols="2" />
                                <x-forms.input label="Date/Place of Issuance" name="id_date_issue" cols="2" />
                            </div>
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
                                    <x-forms.input label="Block" name="res_address_block" cols="2" />
                                    <x-forms.input label="Street" name="res_address_street" cols="5" />
                                    <x-forms.input label="Village" name="res_address_village" cols="5" />
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Barangay" name="res_address_barangay" cols="6" />
                                    <x-forms.input label="City" name="res_address_city" cols="6" />
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Province" name="res_address_province" cols="6" />
                                    <x-forms.input label="Zipcode" name="res_address_zipcode" cols="3" />
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
                                    <x-forms.input label="Block" name="perm_address_block" cols="2" />
                                    <x-forms.input label="Street" name="perm_address_street" cols="5" />
                                    <x-forms.input label="Village" name="perm_address_village" cols="5" />
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Barangay" name="perm_address_barangay" cols="6" />
                                    <x-forms.input label="City" name="perm_address_city" cols="6" />
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Province" name="perm_address_province" cols="6" />
                                    <x-forms.input label="Zipcode" name="perm_address_zipcode" cols="3" />
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
                                <x-forms.input label="Last name" name="father_lastname" cols="3" />
                                <x-forms.input label="First name" name="father_firstname" cols="4" />
                                <x-forms.input label="Middle name" name="father_middlename" cols="3" />
                                <x-forms.input label="Name ext" name="father_name_ext" cols="2" />
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                                Mother's Information
                            </p>
                            <div class="row">
                                <x-forms.input label="Last name" name="mother_lastname" cols="3" />
                                <x-forms.input label="First name" name="mother_firstname" cols="4" />
                                <x-forms.input label="Middle name" name="mother_middlename" cols="3" />
                                <x-forms.input label="Name ext" name="mother_name_ext" cols="2" />
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
                                <x-forms.input label="Last name" name="spouse_lastname" cols="4" />
                                <x-forms.input label="First name" name="spouse_firstname" cols="4" />
                                <x-forms.input label="Middle name" name="spouse_middlename" cols="4" />
                            </div>
                            <div class="row mb-2">
                                <x-forms.select label="Name ext" name="spouse_name_ext" cols="3"  :options="\App\Swep\Helpers\Arrays::name_extensions()"/>
                                <x-forms.input label="Occupation" name="spouse_occupation" cols="4" />
                                <x-forms.input label="Employer/Business Name" name="spouse_employer" cols="5" />
                            </div>
                            <div class="row mb-2">
                                <x-forms.input label="Business Address" name="spouse_business_address" cols="6" />
                                <x-forms.input label="Telephone No" name="spouse_tel_no" cols="6" />
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
                        <x-forms.input label="Employee No." name="employee_no" cols="2" />
                        <x-forms.select label="Item No" name="item_no" id="item-no" cols="3"  :options="[]"/>
                        <x-forms.input label="Position" name="position" cols="3" />
                        <x-forms.select label="Appt. Status" name="appointment_status" cols="2"  :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeApptStatus(),'option','value')"/>
                        <x-forms.select label="JG" name="salary_grade" class="sgXsi" cols="1"  :options="\App\Swep\Helpers\Arrays::jobGradeLevels()"/>
                        <x-forms.select label="SI" name="step_inc" class="sgXsi" cols="1"  :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
                    </div>

                    <div class="row mb-2">
                        <x-forms.select label="Responsibility Center" name="resp_center" cols="4" id="resp_center"  :options="\App\Swep\Helpers\Arrays::groupedRespCodes('all')"/>
                        <x-forms.input label="Monthly Basic" name="monthly_basic" cols="2" id="monthly_basic" />
                        <x-forms.input label="Food Subsidy" name="food_subsidy" cols="2" />
                        <x-forms.input label="Date of Original Appointment" name="firstday_gov" cols="2" type="date" />
                        <x-forms.input label="First Day in SRA" name="firstday_sra" cols="2" type="date" />
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Appointment Date" name="appointment_date" cols="2" type="date" />
                        <x-forms.input label="Adjustment Date" name="adjustment_date" cols="2" type="date" />
                        <x-forms.select label="Station" name="station" cols="2"  :options="['QC' => 'QC', 'VIS' => 'VIS']"/>
                        <x-forms.select label="Groupings" name="locations" cols="2"   :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeGroupings(),'value','option')"/>
                        <x-forms.select label="Assignment" name="assignment" cols="2"   :options="\App\Swep\Helpers\Arrays::employeeAssignments()"/>
                        <x-forms.select label="Payroll Group" name="payroll_group" cols="2"  :options="\App\Swep\Helpers\Arrays::payrollGroups()"/>

                    </div>
                    <div class="row mb-3">
                        <x-forms.select label="Status" name="is_active" cols="2" id="is_active"  :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::employeeStatus(),'value','option')"/>
                        <x-forms.input label="Date of Separation" name="date_of_separation" type="date" container-class="is_active_toggle" cols="2" />
                        <x-forms.input label="Reason of Separation" name="reason_of_separation" cols="2" container-class="is_active_toggle" />
                    </div>

                    <div class="alert alert-success mb-2" role="alert">
                        <div class="alert-message p-1 text-center">
                            <strong>Personal IDs</strong>
                        </div>
                    </div>

                    <div class="row">
                        <x-forms.input label="GSIS BP No." name="gsis" cols="2" />
                        <x-forms.input label="PHILHEALTH" name="philhealth" cols="2" />
                        <x-forms.input label="TIN" name="tin" cols="2" />
                        <x-forms.input label="SSS" name="sss" cols="2" />
                        <x-forms.input label="HDMF" name="hdmf" cols="2" />
                        <x-forms.input label="HDMF Premiums" name="hdmfpremiums" cols="2" />

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
        $("#add-employee-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.employee.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    unmark_required(form)
                    form.get(0).reset();
                    toast('success','Employee successfully added.','Success!');
                    remove_loading_btn(form);
                    markTabs(form);
                },
                error: function (res) {
                    errored(form,res);
                    markTabs(form);
                }
            })
        })

        var data = {!! \App\Swep\Helpers\Arrays::payPlantillasWithItemNumberAndDetails() !!};
        $("#item-no").select2({data: data});
        $('#item-no').on('select2:select', function (e) {
            var data = e.params.data;
            $("input[name='position']").val(data.position);
            $("select[name='salary_grade']").val(data.salary_grade);
            $("select[name='step_inc']").val(data.step_inc);
            $('.sgXsi').trigger('change');
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
    </script>
@endsection