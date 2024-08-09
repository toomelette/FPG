@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Dashboard</x-slot:title>
    </x-adminkit.html.page-title>

    <div class="row mb-3">
        <div class="col-md-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Active Organic Employees</h5>
                    </div>

                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($activeOrganicMaleEmployees + $activeOrganicFemaleEmployees)}}</h1>
                <div class="mb-0">
                    <span class="badge badge-primary-light">{{number_format($activeOrganicMaleEmployees)}} MALE</span>
                    <span class="badge badge-success-light">{{number_format($activeOrganicFemaleEmployees)}} FEMALE</span>
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Active COS Employees</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($activeCosMaleEmployees + $activeCosFemaleEmployees)}}</h1>
                <div class="mb-0">
                    <span class="badge badge-primary-light">{{number_format($activeCosMaleEmployees)}} MALE</span>
                    <span class="badge badge-success-light">{{number_format($activeCosFemaleEmployees)}} FEMALE</span>
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Applicants</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($all_applicants)}}</h1>
                <div class="mb-0">
                    <br>
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-3">
            <x-adminkit.html.card>
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Vacant Planitlla</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{number_format($vacantPlantilla)}}</h1>
                <div class="mb-0">
                    <span class="badge badge-success-light">Filled {{number_format($filledPlantilla)}} of {{number_format($allPlantilla,)}}</span>
                </div>
            </x-adminkit.html.card>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-5">
            <x-adminkit.html.card style="min-height: 460px">
                <x-adminkit.html.alert type="info mb-1" body-class="p-1 text-center text-strong" :dismissible="false" :with-icon="false">
                    <span for="month_name">August 2024</span> Birthday Celebrants
                </x-adminkit.html.alert>
                <div class="clearfix mb-1">
                    <div class="btn-group float-end">
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->subMonth(1)->firstOfMonth()->format('Y-m-d')}}" id="prev_btn" class="btn btn-outline-secondary btn-sm nav_month_btn"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->addMonth(1)->firstOfMonth()->format('Y-m-d')}}" id="next_btn" class="btn btn-outline-secondary btn-sm nav_month_btn"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>

                <hr class="no-margin">
                <div style="height: 355px;overflow-x: hidden; overflow-y: auto" id="bday_celebrants_container">
                    {!! $bday_celebrants_view !!}
                </div>
            </x-adminkit.html.card>
        </div>
        <div class="col-md-7">
            <x-adminkit.html.card style="min-height: 460px">
                <x-adminkit.html.alert type="primary mb-1" body-class="p-1 text-center text-strong" :dismissible="false" :with-icon="false">
                    <span for="month_name_adj">{{Carbon::now()->format('F Y')}}</span> | Step Increment Adjustments
                </x-adminkit.html.alert>
                <div class="clearfix mb-1">
                    <div class="btn-group float-end">
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->startOfMonth()->subMonth(1)->format('Y-m')}}-01" id="prev_btn_step" class="btn btn-outline-secondary btn-sm nav_month_btn_step"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->startOfMonth()->addMonth(1)->format('Y-m')}}-01" id="next_btn_step" class="btn btn-outline-secondary btn-sm nav_month_btn_step"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>


                <div style="max-height: 355px;overflow-x: hidden; padding-top: 3px" id="adjustments_container" >
                    {!! $step_increments_view !!}
                </div>
            </x-adminkit.html.card>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-adminkit.html.card style="min-height: 460px">
                <x-adminkit.html.alert type="warning mb-1" body-class="p-1 text-center text-strong" :dismissible="false" :with-icon="false">
                    <span for="year_name">{{Carbon::now()->format('Y')}}</span> | Employees' Milestone
                </x-adminkit.html.alert>
                <div class="clearfix mb-1">
                    <div class="btn-group float-end">
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->format('Y')-1}}" id="prev_btn_milestone" class="btn btn-outline-secondary btn-sm nav_month_btn_milestone"><i class="fa fa-chevron-left"></i></button>
                        <button type="button" data="{{\Illuminate\Support\Carbon::now()->format('Y')+1}}" id="next_btn_milestone" class="btn btn-outline-secondary btn-sm nav_month_btn_milestone"><i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>


                <div style="max-height: 355px;overflow-x: hidden;" id="" >
                    <div id="milestoneContainer">
                        {!! $loyaltys !!}
                    </div>

                </div>
            </x-adminkit.html.card>
        </div>
    </div>
@endsection


@section('modals')

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
    </script>
@endsection