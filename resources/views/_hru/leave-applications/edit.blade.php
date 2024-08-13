@php
/** @var \App\Models\LeaveApplication $la  **/
 @endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Edit Leave Application</x-slot:title>
    </x-adminkit.html.page-title>

    <form id="edit-leave-application-form">
        <x-adminkit.html.card header-class="pb-1 pt-3">
            <x-slot:title>
                <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>
            <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Applicant details
            </x-adminkit.html.alert>
            <div class="row mb-2">
                <x-forms.select label="Department" name="department" cols="lg-2 col-md-6" :options="\App\Swep\Helpers\Arrays::departmentList()" :value="$la ?? null"/>
                <x-forms.select label="Employee" name="employee_slug" cols="lg-2 col-md-6" id="employee_slug" :value="$la ?? null"/>
                <x-forms.input label="Last Name" name="lastname" cols="lg-2 col-md-3" :value="$la ?? null"/>
                <x-forms.input label="First Name" name="firstname" cols="lg-2 col-md-3" :value="$la ?? null"/>
                <x-forms.input label="Middle Name" name="middlename" cols="lg-1 col-md-2" :value="$la ?? null"/>
                <x-forms.input label="Position" name="position" cols="lg-2 col-md-4" :value="$la ?? null"/>
                <x-forms.input label="Salary" name="salary" cols="lg-1 col-md-3" class="autonum text-right" :value="$la ?? null"/>
            </div>

            <x-adminkit.html.alert type="info mt-5" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Leave application details
            </x-adminkit.html.alert>
            <div class="row mb-2">
                <x-forms.input label="Date of filing" name="date_of_filing" cols="lg-3 col-md-4" type="date" :value="$la ?? null"/>
                <x-forms.select label="Type of leave to be availed" name="leave_type" cols="lg-3 col-md-4" id="leave-type" :options="\App\Swep\Helpers\Arrays::leaveTypes()" :value="$la ?? null"/>
                <x-forms.input label="Specify Leave Type" name="leave_type_specify" id="leave-type-specify" cols="lg-3 col-md-4" :value="$la ?? null"/>
                <x-forms.select label="Details of leave" name="leave_details" id="leave-details" cols="lg-3 col-md-4" :disabled="true" :options="\App\Swep\Helpers\Arrays::leaveTypesTree()[$la->leave_type] ?? []" :value="$la ?? null"/>
                <x-forms.input label="Specify " name="leave_specify" id="leave-specify" cols="lg-3 col-md-4" :disabled="false" :value="$la ?? null"/>
            </div>

            <div class="row mb-2">
                @php
                    $dates = $la->dates->map(function ($d){
                                return Carbon::parse($d->date)->format('m/d/Y');
                            })->toArray();
                    $dateString = join(',',$dates);
                @endphp
                <div class="form-group  col-md-4 inclusive_dates">
                    <label for="inclusive_dates">Inclusive Dates:</label>
                    <input type="text" id="datepicker" name="inclusive_dates" class="form-control" value="{{$dateString}}" autocomplete="off">
                </div>

                <x-forms.input label="No. of Days applied for" name="no_of_days"  cols="lg-2 col-md-4" id="no-of-days" :value="$la ?? null"/>
                <x-forms.select label="Commutation" name="commutation" id="leave-specify" cols="lg-2 col-md-4" id="no-of-days" :options="[
                        'Not requested' => 'Not requested',
                        'Requested' => 'Requested',
                    ]" :value="$la ?? null"/>
            </div>

            <x-adminkit.html.alert type="warning mt-5" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                Recommendation and Approval
            </x-adminkit.html.alert>

            <div class="row mb-2">
                <x-forms.input label="Recommending Officer" name="recommended_by" cols="lg-2 col-md-3" :value="$la ?? null"/>
                <x-forms.input label="Position" name="recommended_by_position" cols="lg-2 col-md-3" :value="$la ?? null"/>
                <x-forms.input label="Approved by" name="approved_by" cols="lg-2 col-md-3" :value="$la ?? null"/>
                <x-forms.input label="Position" name="approved_by_position" cols="lg-2 col-md-3" :value="$la ?? null"/>
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

            if(leaveTypes[t.val()] !== null){
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

        @if(\Illuminate\Support\Facades\Request::get("page") != null)
        const page = '{{\Illuminate\Support\Facades\Request::get("page")}}';
        @else
        const page = 0;
        @endif

        $("#edit-leave-application-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.leave_application.update",$la->slug)}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    Swal.fire({
                        title: "Updated success!",
                        text: "Redirecting... ",
                        icon: "success"
                    });
                    window.location.replace('{{route("dashboard.leave_application.user_index")}}?toPage='+page+'&mark='+res.slug);

                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        var employees = {!! \App\Swep\Helpers\Json::activeEmployeesSelect2()  !!};

        $("#employee_slug").select2({ data: employees });
        $("#employee_slug").val('{{Auth::user()->employee->slug}}').trigger('change');

        $('#employee_slug').on('select2:select', function (e) {
            let employee = e.params.data;
            $("#edit-leave-application-form input[name='lastname']").val(employee.lastname);
            $("#edit-leave-application-form input[name='firstname']").val(employee.firstname);
            $("#edit-leave-application-form input[name='middlename']").val(employee.middlename);
            $("#edit-leave-application-form input[name='position']").val(employee.position);
            $("#edit-leave-application-form input[name='salary']").val(employee.monthly_basic);
        });
    </script>
@endsection