@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Dashboard</h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{number_format($all_employees)}}</h3>
                        <p>Active Regular Employees</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
{{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{number_format($all_jo_employees)}}</h3>

                        <p>COS Personnel</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-ioxhost"></i>
                    </div>
{{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{number_format($all_applicants)}}</h3>
                        <p>No. of Applicants on record</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-file-text-o"></i>
                    </div>
                    {{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{number_format($all_ps)}}</h3>

                        <p>Permission Slips</p>
                    </div>
                    <div class="icon">
                        <i class="fa  fa-hand-o-right"></i>
                    </div>
{{--                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>--}}
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="row">
            <div class="col-md-3 col-xs-12">
                <div class="panel">
                    <div class="panel-body">
                        <center><label>Regular Employees by Sex</label></center>
                        <hr class="no-margin">
                        <canvas id="employee_by_gender" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12">
                <div class="panel">
                    <div class="panel-body">
                        <center><label>COS Personnel by Sex</label></center>
                        <hr class="no-margin">
                        <canvas id="jo_employee_by_gender" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel">
                    <div class="panel-body">
                        <center><label><span for="month_name">{{Carbon::now()->format('F')}}</span> Birthday Celebrants</label>
                            <div class="btn-group pull-right">
{{--                                {{str_pad(Carbon::now()->format('m')-1,2,0,STR_PAD_LEFT)}}--}}
{{--                                {{str_pad(Carbon::now()->format('m')+1,2,0,STR_PAD_LEFT)}}--}}
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->subMonth(1)->firstOfMonth()->format('Y-m-d')}}" id="prev_btn" class="btn btn-default btn-xs nav_month_btn"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->addMonth(1)->firstOfMonth()->format('Y-m-d')}}" id="next_btn" class="btn btn-default btn-xs nav_month_btn"><i class="fa fa-chevron-right"></i></button>
                            </div></center>

                        <hr class="no-margin">
                        <div style="height: 355px;overflow-x: hidden" id="bday_celebrants_container">
                            {!! $bday_celebrants_view !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.home.announcement')

        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <center><label><span for="month_name_adj">{{Carbon::now()->format('F Y')}}</span> | Step Increment Adjustments</label>
                            <div class="btn-group pull-right">
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->startOfMonth()->subMonth(1)->format('Y-m')}}-01" id="prev_btn_step" class="btn btn-default btn-xs nav_month_btn_step"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->startOfMonth()->addMonth(1)->format('Y-m')}}-01" id="next_btn_step" class="btn btn-default btn-xs nav_month_btn_step"><i class="fa fa-chevron-right"></i></button>
                            </div></center>

                        <hr class="no-margin">
                        <div style="max-height: 355px;overflow-x: hidden; padding-top: 15px" id="adjustments_container" >
                            {!! $step_increments_view !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <center><label><span for="year_name">{{Carbon::now()->format('Y')}}</span> | Employees' Milestone</label>
                            <div class="btn-group pull-right">
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->format('Y')-1}}" id="prev_btn_milestone" class="btn btn-default btn-xs nav_month_btn_milestone"><i class="fa fa-chevron-left"></i></button>
                                <button type="button" data="{{\Illuminate\Support\Carbon::now()->format('Y')+1}}" id="next_btn_milestone" class="btn btn-default btn-xs nav_month_btn_milestone"><i class="fa fa-chevron-right"></i></button>
                            </div></center>
                        <hr class="no-margin">
                        <div style="max-height: 355px;overflow-x: hidden; padding-top: 15px" id="" >
                            <div class="nav-tabs-custom" id="milestoneContainer">
                                   {!! $loyaltys !!}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        </div>

    </section>

@endsection





@section('scripts')
<script type="text/javascript">

    $(".nav_month_btn").click(function () {
        let get_month = $(this).attr('data');
        $.ajax({
            url : '{{Request::url()}}?bday=true',
            data : {month : get_month},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                   $("#bday_celebrants_container").html(res.view);
                   $("span[for='month_name']").html(res.month_name);
                   $("#next_btn").removeAttr('disabled');
                    $("#prev_btn").removeAttr('disabled');
                   $("#next_btn").attr('data',res.new_next);
                   $("#prev_btn").attr('data',res.new_prev);

            },
            error: function (res) {
                console.log(res);
            }
        })
    })
    $(".nav_month_btn_step").click(function () {
        let get_date = $(this).attr('data');
        $.ajax({
            url : '{{Request::url()}}?step=true',
            data : {date : get_date},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                $("#adjustments_container").html(res.view);
                $("span[for='month_name_adj']").html(res.month_name);
                $("#next_btn_step").attr('data',res.new_next);
                $("#prev_btn_step").attr('data',res.new_prev);

            },
            error: function (res) {
                console.log(res);
            }
        })
    })

    $(".nav_month_btn_milestone").click(function () {
        let get_date = $(this).attr('data');
        $.ajax({
            url : '{{Request::url()}}?milestone=true',
            data : {year : get_date},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                $("#milestoneContainer").html(res.view);
                $("span[for='year_name']").html(res.year);
                $("#next_btn_milestone").attr('data',res.new_next);
                $("#prev_btn_milestone").attr('data',res.new_prev);

            },
            error: function (res) {
                console.log(res);
            }
        })
    })


    $("document").ready(function () {

    })

    $(document).ready(function () {
        @if(request()->has('initiator') && request('initiator') != '')
        $("#hide_show_{{request('initiator')}}").trigger('click');
        setTimeout(function () {
            introJs().start();
        },500);
        @endif
    })
</script>

@endsection