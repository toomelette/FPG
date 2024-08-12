@php
    /** @var \App\Models\Employee $employee  **/
@endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Leave Application</x-slot:title>
    </x-adminkit.html.page-title>
    <form id="add-leave-application-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Applicant details
            </x-adminkit.html.alert>

            <div class="row mb-2">
                <x-forms.select label="Department" name="department" cols="2" :options="\App\Swep\Helpers\Arrays::departmentList()" :value="$employee?->responsibilityCenter?->description?->rc ?? null"/>
                <x-forms.select label="Employee" name="employee_slug" cols="2" id="employee_slug" :value="Auth::user()->employee->slug ?? null"/>
                <x-forms.input label="Last Name" name="lastname" cols="2" :value="$employee ?? null"/>
                <x-forms.input label="First Name" name="firstname" cols="2" :value="$employee ?? null"/>
                <x-forms.input label="Middle Name" name="middlename" cols="1" :value="$employee ?? null"/>
                <x-forms.input label="Position" name="position" cols="2" :value="$employee->plantilla->position ?? $employee->position ?? null"/>
                <x-forms.input label="Salary" name="salary" cols="1" class="autonum text-right" :value="\App\Swep\Helpers\Arrays::jobGrades()[$employee->salary_grade][$employee->step_inc] ?? null"/>
            </div>

            <x-adminkit.html.alert type="info mt-5" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Leave application details
            </x-adminkit.html.alert>

            <div class="row mb-2">
                <x-forms.input label="Date of filing" name="date_of_filing" cols="2" type="date"/>
                <x-forms.select label="Type of leave to be availed" name="leave_type" cols="2" id="leave-type" :options="\App\Swep\Helpers\Arrays::leaveTypes()"/>
                <x-forms.input label="Specify Leave Type" name="leave_type_specify" id="leave-type-specify" cols="2" container-class="visually-hidden"/>
                <x-forms.select label="Details of leave" name="leave_details" id="leave-details" cols="2" :disabled="true"/>
                <x-forms.input label="Specify " name="leave_specify" id="leave-specify" cols="2" :disabled="false"/>
            </div>
            <div class="row mb-2">
                <div class="form-group  col-md-4 inclusive_dates">
                    <label for="inclusive_dates">Inclusive Dates:</label>
                    <input type="text" id="datepicker" name="inclusive_dates" class="form-control" value="" autocomplete="off">
                </div>

                <x-forms.input label="No. of Days applied for" name="no_of_days" id="leave-specify" cols="2" id="no-of-days"/>
                <x-forms.select label="Commutation" name="commutation" id="leave-specify" cols="2" id="no-of-days" :options="[
                    'Not requested' => 'Not requested',
                    'Requested' => 'Requested',
                ]"/>
            </div>


            <x-adminkit.html.alert type="warning mt-5" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Recommendation and Approval
            </x-adminkit.html.alert>

            <div class="row mb-2">
                <x-forms.input label="Recommending Officer" name="recommended_by" cols="2"/>
                <x-forms.input label="Position" name="recommended_by_position" cols="2"/>
                <x-forms.input label="Approved by" name="approved_by" cols="2"/>
                <x-forms.input label="Position" name="approved_by_position" cols="2"/>
            </div>
        </x-adminkit.html.card>
    </form>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $('#datepicker').datepicker({
            multidate : true,
            daysOfWeekDisabled : [0,6],
        }).on('changeDate', function(e) {
            $("#no-of-days").val(e.dates.length);
        });

        var leaveTypes = {!! json_encode(\App\Swep\Helpers\Arrays::leaveTypesJson())  !!};
        $('#leave-type').change(function (){
            let t = $(this);
            let specifyTextbox = $("#leave-specify");
            let detailsTextbox = $("#leave-details");
            if(leaveTypes[t.val()] === 1){
                specifyTextbox.removeAttr('disabled');
                detailsTextbox.attr('disabled','disabled');
            }else{
                detailsTextbox.removeAttr('disabled');
                specifyTextbox.attr('disabled','disabled');
            }

            if(leaveTypes[t.val()] !== null && leaveTypes[t.val()] != ''){
                if(Object.keys(leaveTypes[t.val()]).length > 0){
                    selectHtml = '<option value="">Select</option>';
                    $.each(leaveTypes[t.val()],function (i,item){
                        selectHtml = selectHtml + '<option value="'+i+'">'+i+'</option>';
                    })
                    $("#leave-details").html(selectHtml);
                }else{

                }
            }else{
                $("#leave-details").html('');
                detailsTextbox.attr('disabled','disabled');
            }

            if(t.val() === 'Others'){
                $("#leave-type-specify").removeAttr('disabled');
                $("#leave-type-specify").parent('div').removeClass('hidden');
            }else{
                $("#leave-type-specify").attr('disabled','disabled');
                $("#leave-type-specify").parent('div').addClass('hidden');
            }

        })
        $("#leave-details").change(function (){
            let leaveType = $('#leave-type').val();
            let t = $(this);
            let leaveDetails = t.val();
            let specifyTextbox = $("#leave-specify");
            if(leaveTypes[leaveType][leaveDetails] === 1){
                specifyTextbox.removeAttr('disabled');
            }else{
                specifyTextbox.attr('disabled','disabled');
            }
        })


        var employees = {!! \App\Swep\Helpers\Json::activeEmployeesSelect2()  !!};

        $("#employee_slug").select2({ data: employees });
        $("#employee_slug").val('{{Auth::user()->employee->slug}}').trigger('change');

        $('#employee_slug').on('select2:select', function (e) {
            let employee = e.params.data;
            $("#add-leave-application-form input[name='lastname']").val(employee.lastname);
            $("#add-leave-application-form input[name='firstname']").val(employee.firstname);
            $("#add-leave-application-form input[name='middlename']").val(employee.middlename);
            $("#add-leave-application-form input[name='position']").val(employee.position);
            $("#add-leave-application-form input[name='salary']").val(employee.monthly_basic);
        });

        $("#add-leave-application-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.leave_application.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    link = res.myLeaveApplicationsRoute;
                    Swal.fire({
                        title: "Done!",
                        text: "Leave application successfully created.",
                        icon: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#3cbc71",
                        confirmButtonText: " <i class='fa fa-print'></i>Print",
                        cancelButtonText: "My Leave Applications",
                        allowOutsideClick: false,
                        closeOnConfirm: false,
                        preConfirm: (e) => {
                            window.open(res.printRoute, "popupWindow", "width=1200, height=600, scrollbars=yes");
                            return false;
                        },
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            window.open(link, "_self");
                        }
                    });
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection