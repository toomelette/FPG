@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Edit Leave Application</h1>
    </section>
@endsection
@section('content2')

    @php
        $employee = Auth::user()->employee;
    @endphp
    <section class="content">
        <div class="box box-solid">
            <form id="edit_leave_form">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Leave Application</h3>
                    <button type="submit" class="btn btn-sm btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
                </div>

                <div class="box-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::select('department',[
                            'label' => 'Department:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::departmentList()
                        ],$la ?? null) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('lastname',[
                            'label' => 'Last Name:',
                            'cols' => 2,
                        ],$la ?? null) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('firstname',[
                            'label' => 'First Name:',
                            'cols' => 2,
                        ],$la ?? null) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('middlename',[
                            'label' => 'Middle Name:',
                            'cols' => 2,
                        ],$la ?? null) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ],$la ?? null) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
                            'label' => 'Position:',
                            'cols' => 2,
                            'class' => 'text-right autonum',
                        ],$la ?? null) !!}
                    </div>
                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Details of Leave
                    </p>
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date_of_filing',[
                            'label' => 'Date of filing:',
                            'cols' => 2,
                            'type' => 'date',
                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('leave_type',[
                            'label' => 'Type of leave to be availed:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::leaveTypes(),
                            'id' => 'leave-type',
                        ], $la ?? null) !!}



                        {!! \App\Swep\ViewHelpers\__form2::select('leave_details',[
                            'label' => 'Details of leave:',
                            'cols' => 2,
                            'options' => \App\Swep\Helpers\Arrays::leaveTypesTree()[$la->leave_type] ?? [],
                            'id' => 'leave-details',
                            'disabled' => 'disabled',
                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('leave_specify',[
                            'label' => 'Specify:',
                            'cols' => 2,
                            'options' => [],
                            'id' => 'leave-specify',
                            'disabled' => 'disabled',
                        ], $la ?? null) !!}


                    </div>

                    <div class="row">
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

                        {!! \App\Swep\ViewHelpers\__form2::textbox('no_of_days',[
                            'label' => 'No. of Days applied for:',
                            'cols' => 2,
                            'id' => 'no-of-days',
                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('commutation',[
                            'label' => 'Commutation:',
                            'cols' => 2,
                            'options' => [
                                'Not requested' => 'Not requested',
                                'Requested' => 'Requested',
                            ],
                        ], $la ?? null) !!}
                    </div>

                    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                        Recommendation and Approval
                    </p>
                    <div class="row">

                        {!! \App\Swep\ViewHelpers\__form2::textbox('recommended_by',[
                            'label' => 'Recommending Officer:',
                            'cols' => 2,

                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('recommended_by_position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('approved_by',[
                            'label' => 'Approved by:',
                            'cols' => 2,

                        ], $la ?? null) !!}

                        {!! \App\Swep\ViewHelpers\__form2::textbox('approved_by_position',[
                            'label' => 'Position:',
                            'cols' => 2,
                        ], $la ?? null) !!}
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

        $("#edit_leave_form").submit(function (e) {
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
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection