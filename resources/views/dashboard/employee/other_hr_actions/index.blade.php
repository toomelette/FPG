@extends('layouts.modal-content')
@php
    $rand = \Illuminate\Support\Str::random(10);
@endphp
@section('modal-header')
    Other HR Actions
@endsection

@section('modal-body')
    <div class="nav-tabs">
        <div class="row">
            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Certificate of Employment</a></li>
                            <li role="presentation" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">COE with Compensation</a></li>
                            <li role="presentation" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Notice of Salary Adjustment</a></li>
                            <li role="presentation" class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Notice of Step Increment</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        <div class="box box-sm box-primary box-solid">
                            <div class="box-header with-border">
                                <p class="box-title-sm no-margin"><i class="fa fa-user"></i> EMPLOYEE DETAILS</p>
                            </div>
                            <div class="box-body" style="">
                                <strong>Employee no.:</strong>
                                <p class="text-muted">{{$employee->employee_no}}</p>
                                <hr class="no-margin">

                                <strong>Name:</strong>
                                <p class="text-muted">{{$employee->lastname}}, {{$employee->firstname}} {{$employee->middlename}}</p>
                                <hr class="no-margin">

                                <strong>Item no:</strong>
                                <p class="text-muted">{{$employee->item_no}}</p>
                                <hr class="no-margin">

                                <strong>Position:</strong>
                                <p class="text-muted">{{$employee->position}}</p>
                                <hr class="no-margin">

                                <strong>Sex:</strong>
                                <p class="text-muted">{{$employee->sex}}</p>
                                <hr class="no-margin">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="box box-sm box-default box-solid">
                            <div class="box-header with-border">
                                <p class="box-title-sm no-margin">CERTIFICATE OF EMPLOYMENT</p>
                            </div>
                            <div class="box-body" style="">
                                <form class="report_form_{{$rand}}" id="coe_frame_form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                                SIGNATORY
                                            </p>
                                            @php
                                                $signatory = \App\Models\Signatory::query()->where('type','=',13)->first();
                                                $s_name = '';
                                                $s_position = '';
                                                if(!empty($signatory)){
                                                    $s_name = $signatory->employee_name;
                                                    $s_position = $signatory->employee_position;
                                                }
                                            @endphp

                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('signatory_name',[
                                                    'label' => 'Name:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                ],$s_name) !!}

                                                {!! \App\Swep\ViewHelpers\__form2::textbox('signatory_position',[
                                                    'label' => 'Position:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                ],$s_position) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="height: 101px">
                                                <button type="submit" class="btn btn-success btn-sm" frame="coe_frame" style="position: absolute;bottom: 15px; right: 15px"><i class="fa fa-refresh generate_report_btn"></i> Generate COE</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <span style="font-weight: bold; font-size: 16px">Print Preview</span>
                                <button id="coe_frame_print_btn" class="btn btn-success btn-sm pull-right print_button" disabled><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="panel-body" style="height: 700px">
                                <div id="coe_frame_placeholder" style="text-align: center; margin-top: 100px">
                                    <i class="fa fa-print" style="font-size: 300px; color: grey; "></i>
                                    <br>
                                    <span class="text-info">Click <b>"Generate COE"</b> button to see print preview here</span>
                                </div>


                                <div id="coe_frame_loader" style="display: none">
                                    <center>
                                        <img style="width: 100px; margin: 140px 0;" src="{{asset('images/loader.gif')}}">
                                    </center>
                                </div>
                                <div class="row" id="coe_frame_container"  style="height: 100%; display: none">
                                    <div class="col-md-12" style="height: 100%">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="coe_frame"  style="width: 100%; height: 100%;overflow:hidden; " class="embed-responsive" src=""></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane " id="tab_2">
                        <div class="box box-sm box-default box-solid">
                            <div class="box-header with-border">
                                <p class="box-title-sm no-margin">CERTIFICATE OF EMPLOYMENT with COMPENSATION</p>
                            </div>
                            <div class="box-body" style="">
                                <form class="coec_form_{{$rand}}" id="coec_frame_form">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                                SIGNATORY
                                            </p>
                                            @php
                                                $signatory = \App\Models\Signatory::query()->where('type','=',13)->first();
                                                $s_name = '';
                                                $s_position = '';
                                                if(!empty($signatory)){
                                                    $s_name = $signatory->employee_name;
                                                    $s_position = $signatory->employee_position;
                                                }
                                            @endphp

                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('signatory_name',[
                                                    'label' => 'Name:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                ],$s_name) !!}

                                                {!! \App\Swep\ViewHelpers\__form2::textbox('signatory_position',[
                                                    'label' => 'Position:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                ],$s_position) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="height: 101px">
                                                <button type="submit" class="btn btn-success btn-sm" frame="coec_frame" style="position: absolute;bottom: 15px; right: 15px"><i class="fa fa-refresh generate_report_btn"></i> Generate COE</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <span style="font-weight: bold; font-size: 16px">Print Preview</span>
                                <button id="coec_frame_print_btn" class="btn btn-success btn-sm pull-right print_button" disabled><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="panel-body" style="height: 700px">
                                <div id="coec_frame_placeholder" style="text-align: center; margin-top: 100px">
                                    <i class="fa fa-print" style="font-size: 300px; color: grey; "></i>
                                    <br>
                                    <span class="text-info">Click <b>"Generate COE"</b> button to see print preview here</span>
                                </div>


                                <div id="coec_frame_loader" style="display: none">
                                    <center>
                                        <img style="width: 100px; margin: 140px 0;" src="{{asset('images/loader.gif')}}">
                                    </center>
                                </div>
                                <div class="row" id="coec_frame_container"  style="height: 100%; display: none">
                                    <div class="col-md-12" style="height: 100%">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="coec_frame"  style="width: 100%; height: 100%;overflow:hidden; " class="embed-responsive" src=""></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_3">
                        <form id="nosa_form_{{$rand}}">
                            <div class="box box-sm box-default box-solid">
                                <div class="box-header with-border">
                                    <p class="box-title-sm no-margin"><i class="fa fa-wrench"></i> NOTICE OF SALARY ADJUSTMENT</p>
                                </div>
                                <div class="box-body" style="">
                                    @php
                                        $savedNosa = $employee->otherNosa;

                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                                CURRENT
                                            </p>
                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('salary_grade',[
                                                    'label' => 'Job Grade:',
                                                    'cols' => 4,
                                                    'class' => 'input-sm currents_'.$rand,
                                                    'type' => 'number',
                                                    'id' => 'cur_sg_'.$rand,
                                                ], (isset($employee->otherNosa->values['salary_grade']) ? $employee->otherNosa->values['salary_grade'] : null) ?? $employee) !!}

                                                {!! \App\Swep\ViewHelpers\__form2::textbox('step_inc',[
                                                    'label' => 'Step Inc:',
                                                    'cols' => 4,
                                                    'class' => 'input-sm currents_'.$rand,
                                                    'type' => 'number',
                                                    'value' => $employee,
                                                    'id' => 'cur_si_'.$rand,
                                                ], (isset($employee->otherNosa->values['step_inc']) ? $employee->otherNosa->values['step_inc'] : null) ?? $employee) !!}
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('monthly_basic',[
                                                    'label' => 'Monthly Sal.:',
                                                    'cols' => 4,
                                                    'class' => 'input-sm',
                                                    'id' => 'cur_monthly_salary_'.$rand,
                                                    'tab_index' => -1,
                                                    'required' => 'required',
                                                ], Helper::toNumber(Helper::sanitizeAutonum(isset($employee->otherNosa->values['monthly_basic']) ? $employee->otherNosa->values['monthly_basic'] : null),2)) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid green; color: green">
                                                NEW
                                            </p>
                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('new_item_no',[
                                                    'label' => 'Item No:',
                                                    'cols' => 2,
                                                    'class' => 'input-sm',
                                                    'required' => 'required',
                                                ],(isset($employee->otherNosa->values['new_item_no']) ? $employee->otherNosa->values['new_item_no'] : null) ?? null) !!}

                                                {!! \App\Swep\ViewHelpers\__form2::textbox('new_position',[
                                                    'label' => 'Position:',
                                                    'cols' => 4,
                                                    'class' => 'input-sm',
                                                    'required' => 'required',
                                                ],(isset($employee->otherNosa->values['new_position']) ? $employee->otherNosa->values['new_position'] : null) ?? null) !!}
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('new_salary_grade',[
                                                    'label' => 'Job Grade:',
                                                    'cols' => 2,
                                                    'class' => 'input-sm news_'.$rand,
                                                    'type' => 'number',
                                                    'id' => 'new_sg_'.$rand,
                                                    'required' => 'required',

                                                ],(isset($employee->otherNosa->values['new_salary_grade']) ? $employee->otherNosa->values['new_salary_grade'] : null) ?? null) !!}
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('new_step_inc',[
                                                    'label' => 'Step Inc:',
                                                    'cols' => 2,
                                                    'class' => 'input-sm news_'.$rand,
                                                    'type' => 'number',
                                                    'id' => 'new_si_'.$rand,
                                                    'required' => 'required',
                                                ],(isset($employee->otherNosa->values['new_step_inc']) ? $employee->otherNosa->values['new_step_inc'] : null) ?? null) !!}
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('new_monthly_salary',[
                                                    'label' => 'Monthly Sal.:',
                                                    'cols' => 2,
                                                    'class' => 'input-sm news_'.$rand,
                                                    'id' => 'new_monthly_salary_'.$rand,
                                                    'tab_index' => -1,
                                                    'required' => 'required',
                                                ],Helper::toNumber(Helper::sanitizeAutonum(isset($employee->otherNosa->values['new_monthly_salary']) ? $employee->otherNosa->values['new_monthly_salary'] : null),2)) !!}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                                DATES
                                            </p>
                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('effectivity',[
                                                    'label' => 'Effectivity:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                    'type' => 'date',
                                                ],(isset($employee->otherNosa->values['effectivity']) ? $employee->otherNosa->values['effectivity'] : null) ?? null) !!}

                                                {!! \App\Swep\ViewHelpers\__form2::textbox('as_of',[
                                                    'label' => 'As of:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                    'type' => 'date',
                                                ],(isset($employee->otherNosa->values['as_of']) ? $employee->otherNosa->values['as_of'] : null) ?? null) !!}
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
                                                SIGNATORY
                                            </p>

                                            <?php
                                            $signatory = \App\Models\Signatory::query()->where('type','=',0)->first();
                                            $s_name = '';
                                            $s_position = '';
                                            if(!empty($signatory)){
                                                $s_name = $signatory->employee_name;
                                                $s_position = $signatory->employee_position;
                                            }
                                            ?>
                                            <div class="row">
                                                {!! \App\Swep\ViewHelpers\__form2::textbox('signatory_name',[
                                                    'label' => 'Name:',
                                                    'cols' => 6,
                                                    'class' => 'input-sm',
                                                ],(isset($employee->otherNosa->values['signatory_name']) ? $employee->otherNosa->values['signatory_name'] : null) ??  (($s_name == '') ? 'ATTY. BRANDO D. NOROÑA' : $s_name)) !!}

                                                <div class="col-md-6">
                                                    <label>Position:</label>
                                                    <textarea class="form-control input-sm" rows="3" name="signatory_position">{{(isset($employee->otherNosa->values['signatory_position']) ? $employee->otherNosa->values['signatory_position'] : null) ?? 'Deputy Administrator II
Administration and Finance' }}

                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div style="height: 101px">
                                                <button frame="nosa_frame" type="submit" class="btn btn-success btn-sm" style="position: absolute;bottom: 15px; right: 15px"><i class="fa fa-refresh"></i> Generate NOSA</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>



                        <div class="panel panel-default">
                            <div class="panel-heading clearfix">
                                <span style="font-weight: bold; font-size: 16px">Print Preview</span>
                                <button id="print_btn" class="btn btn-success btn-sm pull-right print_button"><i class="fa fa-print"></i> Print</button>
                            </div>
                            <div class="panel-body" style="height: 700px">
                                <div id="nosa_frame_placeholder" style="text-align: center; margin-top: 100px">
                                    <i class="fa fa-print" style="font-size: 300px; color: grey; "></i>
                                    <br>
                                    <span class="text-info">Click <b>"Generate Report"</b> button to see print preview here</span>
                                </div>


                                <div id="nosa_frame_loader" style="display: none">
                                    <center>
                                        <img style="width: 100px; margin: 140px 0;" src="{{asset('images/loader.gif')}}">
                                    </center>
                                </div>
                                <div class="row" id="nosa_frame_container" style="height: 100%; display: none">


                                    <div class="col-md-12" style="height: 100%">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe id="nosa_frame"  style="width: 100%; height: 100%;overflow:hidden; " class="embed-responsive" src=""></iframe>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_4">
                        Notice of Step Increment

                        <div class="callout callout-default">
                            <h4>We're working on it.</h4>
                            <p>Hi. This page is currently under development. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('modal-footer')

@endsection

@section('scripts')
<script type="text/javascript">
    $(".currents_{{$rand}}").change(function () {
        let cur_sg = $("#cur_sg_{{$rand}}").val();
        let cur_si = $("#cur_si_{{$rand}}").val();

        $.ajax({
            url : '{{route("dashboard.ajax.get","compute_monthly_salary")}}',
            data : {'sg' : cur_sg, 'si': cur_si},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                $("#cur_monthly_salary_{{$rand}}").val(res);
            },
            error: function (res) {
                console.log(res);
            }
        })
    })
    $(".news_{{$rand}}").change(function () {
        let new_sg = $("#new_sg_{{$rand}}").val();
        let new_si = $("#new_si_{{$rand}}").val();

        $.ajax({
            url : '{{route("dashboard.ajax.get","compute_monthly_salary")}}',
            data : {'sg' : new_sg, 'si': new_si},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                $("#new_monthly_salary_{{$rand}}").val(res);
            },
            error: function (res) {
                console.log(res);
            }
        })
    })

    $(".report_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let submit_btn = form.find('button[type="submit"]');
        let frame = submit_btn.attr('frame');
        let src = '{{route("dashboard.employee.other_hr_actions_print",["slug"=>"slug","type" => "type"])}}';
        src = src.replace('slug',"{{$employee->slug}}");
        src = src.replace("type","coe");
        $("#"+frame).attr('src',src+"?"+form.serialize());

        $("#"+frame+"_placeholder").hide();
        $("#"+frame+"_loader").fadeIn();

        loading_btn(form);
    })

    $("#coe_frame").on("load",function () {
        let frame_id = $(this).attr('id');
        $("#"+frame_id+"_loader").hide();
        $("#"+frame_id+"_container").fadeIn();
        remove_loading_btn($(".report_form_{{$rand}}"));
        $("#"+frame_id+"_print_btn").removeAttr('disabled');
    })


    $(".coec_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let submit_btn = form.find('button[type="submit"]');
        let frame = submit_btn.attr('frame');
        let src = '{{route("dashboard.employee.other_hr_actions_print",["slug"=>"slug","type" => "type"])}}';
        src = src.replace('slug',"{{$employee->slug}}");
        src = src.replace("type","coe_with_compensation");
        $("#"+frame).attr('src',src+"?"+form.serialize());

        $("#"+frame+"_placeholder").hide();
        $("#"+frame+"_loader").fadeIn();

        loading_btn(form);
    })

    $("#coec_frame").on("load",function () {
        let frame_id = $(this).attr('id');
        $("#"+frame_id+"_loader").hide();
        $("#"+frame_id+"_container").fadeIn();
        remove_loading_btn($(".coec_form_{{$rand}}"));
        $("#"+frame_id+"_print_btn").removeAttr('disabled');
    })





    $(".print_button").click(function(){
        let btn = $(this);
        let parent = btn.parent('div').parent('div');
        parent.find('iframe').get(0).contentWindow.print();
    })


    $("#nosa_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let submit_btn = form.find('button[type="submit"]');
        let frame = submit_btn.attr('frame');
        let src = '{{route("dashboard.employee.other_hr_actions_print",["slug"=>"slug","type" => "type"])}}';
        src = src.replace('slug',"{{$employee->slug}}");
        src = src.replace("type","nosa");
        $("#"+frame).attr('src',src+"?"+form.serialize());

        $("#"+frame+"_placeholder").hide();
        $("#"+frame+"_loader").fadeIn();

        loading_btn(form);
    })

    $("#nosa_frame").on("load",function () {
        let frame_id = $(this).attr('id');
        $("#"+frame_id+"_loader").hide();
        $("#"+frame_id+"_container").fadeIn();
        remove_loading_btn($("#nosa_form_{{$rand}}"));
        $("#"+frame_id+"_print_btn").removeAttr('disabled');
    })

    $(".nav-stacked li").click(function () {
        $(".tab-pane").each(function () {
            $(this).removeClass('active');
        })
        $(".tab-content "+$(this).find('a').attr('href')).addClass('active');
    })
</script>
@endsection

