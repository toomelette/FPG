@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>New Leave Application</h1>
    </section>
@endsection
@section('content2')

    @php
        $employee = Auth::user()->employee;

    @endphp
    <section class="content">

        <div class="box box-solid">
            <form id="create_leave_form">
                <div class="box-header with-border">
                    <h3 class="box-title">Create a Leave Application</h3>
                    <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
                </div>

                <div class="box-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::select('department',[
                            'label' => 'Department:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::departmentList()
                        ]) !!}
                        {!! \App\Swep\ViewHelpers\__form2::select('employee_slug',[
                            'label' => 'Employee:',
                            'cols' => 2,
                            'options' => [],
                            'id' => 'employee_slug',
                        ],Auth::user()->employee->slug ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('lastname',[
                            'label' => 'Last Name:',
                            'cols' => 2,
                        ],$employee->lastname) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('firstname',[
                            'label' => 'First Name:',
                            'cols' => 2,
                        ],$employee->firstname) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('middlename',[
                            'label' => 'Middle Name:',
                            'cols' => 1,
                        ],$employee->middlename) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ],$employee->position) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
                            'label' => 'Salary:',
                            'cols' => 1,
                            'class' => 'text-right autonum',
                        ],$employee->monthly_basic) !!}
                    </div>
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Leave application details
                    </p>
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date_of_filing',[
                            'label' => 'Date of filing:',
                            'cols' => 2,
                            'type' => 'date',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('leave_type',[
                            'label' => 'Type of leave to be availed:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::leaveTypes(),
                            'id' => 'leave-type',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('leave_type_specify',[
                            'label' => 'Specify Leave Type:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::leaveTypes(),
                            'id' => 'leave-type-specify',
                            'container_class' => 'hidden',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('leave_details',[
                            'label' => 'Details of leave:',
                            'cols' => 2,
                            'options' => [],
                            'id' => 'leave-details',
                            'disabled' => 'disabled',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('leave_specify',[
                            'label' => 'Specify:',
                            'cols' => 2,
                            'options' => [],
                            'id' => 'leave-specify',
                            'disabled' => 'disabled',
                        ]) !!}


                    </div>

                    <div class="row">
                        <div class="form-group  col-md-4 inclusive_dates">
                            <label for="inclusive_dates">Inclusive Dates:</label>
                            <input type="text" id="datepicker" name="inclusive_dates" class="form-control" value="" autocomplete="off">
                        </div>

                        {!! \App\Swep\ViewHelpers\__form2::textbox('no_of_days',[
                            'label' => 'No. of Days applied for:',
                            'cols' => 2,
                            'id' => 'no-of-days',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('commutation',[
                            'label' => 'Commutation:',
                            'cols' => 2,
                            'options' => [
                                'Not requested' => 'Not requested',
                                'Requested' => 'Requested',
                            ],
                        ]) !!}
                    </div>
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Recommendation and Approval
                    </p>
                    <div class="row">

                        {!! \App\Swep\ViewHelpers\__form2::textbox('recommended_by',[
                            'label' => 'Recommending Officer:',
                            'cols' => 2,

                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('recommended_by_position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('approved_by',[
                            'label' => 'Approved by:',
                            'cols' => 2,

                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('approved_by_position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ]) !!}
                    </div>

                </div>
            </form>
        </div>

    </section>

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

        let link = '';
        $("#create_leave_form").submit(function (e) {
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

        var employees = {!! \App\Swep\Helpers\Json::activeEmployeesSelect2()  !!};

        $("#employee_slug").select2({ data: employees });
        $("#employee_slug").val('{{Auth::user()->employee->slug}}').trigger('change');

        $('#employee_slug').on('select2:select', function (e) {
            let employee = e.params.data;

            $("#create_leave_form input[name='lastname']").val(employee.lastname);
            $("#create_leave_form input[name='firstname']").val(employee.firstname);
            $("#create_leave_form input[name='middlename']").val(employee.middlename);
            $("#create_leave_form input[name='position']").val(employee.position);
            $("#create_leave_form input[name='salary']").val(employee.monthly_basic);

        });
    </script>
@endsection