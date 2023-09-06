@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>OBLIGATION REQUEST AND STATUS</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="panel">
                    <div class="box box-sm box-default box-solid collapsed-box">
                        <div class="box-header with-border">
                            <p class="no-margin"><i class="fa fa-filter"></i> Advanced Filters <small id="filter-notifier" class="label bg-blue blink"></small></p>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool advanced_filters_toggler" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>

                        </div>



                        <div class="box-body" style="display: none">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Fund Source:</label>
                                        <select name="funds"  class="form-control dt_filter filters">
                                            <option value="">Don't filter</option>
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromArray(\App\Swep\Helpers\Arrays::orsFunds()) !!}
                                        </select>
                                    </div>
{{--                                    <div class="col-md-1 dt_filter-parent-div">--}}
{{--                                        <label>Ref Book:</label>--}}
{{--                                        <select name="ref_book"  class="form-control dt_filter filter_sex filters select22">--}}
{{--                                            <option value="">Don't filter</option>--}}
{{--                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromArray(\App\Swep\Helpers\Arrays::orsBooks()) !!}--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
                                    <div class="col-md-4 dt_filter-parent-div">
                                        <label>Applied Projects:</label>
                                        {!! \App\Swep\ViewHelpers\__form2::selectOnly('applied_projects',[
                                            'class' => 'select2_clear select2_pap_code dt_filter filters',
                                            'container_class' => 'select2-md',
                                            'options' => [],
                                            'select2_preSelected' => '' ,
                                        ],$data->pap_code ?? null) !!}
                                    </div>

                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Ref Book:</label>
                                        <select name="ref_book"  class="form-control dt_filter filters">
                                            <option value="">Don't filter</option>
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromArray(\App\Swep\Helpers\Arrays::orsBooks()) !!}
                                        </select>
                                    </div>

                                    <div class="col-md-4 dt_filter-parent-div">
                                        <label>Payee:</label>
                                        @php
                                            $payees = \App\Models\Budget\ORS::query()
                                                    ->select('payee')
                                                    ->groupBy('payee')
                                                    ->orderBy('payee','asc')
                                                    ->get();
                                            $payees = $payees->pluck('payee')->map(function ($key,$value){
                                                return $key;
                                            });
                                        @endphp
                                        {!! \App\Swep\ViewHelpers\__form2::selectOnly('payee',[
                                            'class' => 'dt_filter filters',
                                            'container_class' => 'select2-md',
                                            'options' => \App\Swep\Helpers\Helper::flattenArray(array_values($payees->toArray())),
                                            'id' => 'select2_payee',
                                        ],'') !!}
                                    </div>


                                </div>
                            </form>
                        </div>

                    </div>
                </div>

                <div id="ors_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="ors_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >ORS No.</th>
                            <th class="th-20">Date</th>
                            <th class="th-20">Payee</th>
                            <th >Particulars</th>
                            <th >Account Entries</th>
                            <th >Applied Projects</th>
                            <th >Amount</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="tbl_loader">
                    <center>
                        <img style="width: 100px" src="{{asset('images/loader.gif')}}">
                    </center>
                </div>
            </div>
        </div>

    </section>


@endsection


@section('modals')
{!! \App\Swep\ViewHelpers\__html::blank_modal('show_ors_modal','lg') !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '{{(\Illuminate\Support\Facades\Request::has('active') && \Illuminate\Support\Facades\Request::get('active') != '') ? \Illuminate\Support\Facades\Request::get('active') : ''}}';
        ors_tbl = $("#ors_table").on('xhr.dt', function (e, settings, json, xhr){
            if(xhr.status > 500){
                alert('Error '+xhr.status+': '+xhr.responseJSON.message);
            }
        }).DataTable({
            'dom' : 'lfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.ors.index')}}',
            "columns": [
                { "data": "ors_no" },
                { "data": "ors_date" },
                { "data": "payee" },
                { "data": "particulars" },
                { "data": "account_entries" },
                { "data": "details" },
                { "data": "amount"},
                { "data": "action"},

            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 7,
                    "class" : 'action4'
                },
                {
                    'targets' : 0,
                    "class" : 'w-10p',
                },
                {
                    'targets' : [1],
                    'class' : 'w-8p',
                },
                {
                    'targets' : 6,
                    'class' : 'w-8p text-right',
                },
                {
                    'targets' : [5],
                    'class' : 'w-16p',
                },
                {
                    'targets' : 4,
                    'class' : 'w-12p',
                },
                {
                    targets : 3,
                    visible : false,
                }

            ],
            "stateSave": true,
            "stateDuration": 60 * 5,
            stateSaveCallback: function(settings,data) {
                console.log(settings);
                localStorage.setItem( 'DataTables_' + settings.sInstance, JSON.stringify(data) )
            },
            stateLoadCallback: function(settings) {
                return JSON.parse( localStorage.getItem( 'DataTables_' + settings.sInstance ) )
            },
            "order" : [[1, 'desc'],[2,'desc']],
            "responsive": true,
            "initComplete": function( settings, json ) {
                // console.log(settings);
                setTimeout(function () {
                    $("#filter_form select[name='is_active']").val('ACTIVE');
                    $("#filter_form select[name='is_active']").trigger('change');
                },100);

                setTimeout(function () {
                    // $('a[href="#advanced_filters"]').trigger('click');
                    // $('.advanced_filters_toggler').trigger('click');
                },1000);

                $('#tbl_loader').fadeOut(function(){
                    $("#ors_table_container").fadeIn(function () {
                        @if(request()->has('initiator') && request('initiator') == 'create')
                        introJs().start();
                        @endif
                    });
                    if(find != ''){
                        ors_tbl.search(find).draw();
                        setTimeout(function(){
                            active = '';
                        },3000);
                        window.history.pushState({}, document.title, "/dashboard/ors");
                    }
                    if(active != ''){
                        toast('success','Data successfully updated','Success');
                        window.history.pushState({}, document.title, "/dashboard/ors");
                    }

                });
                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    ors_tbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
                    active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
                    notify('Employee successfully updated.');
                    // window.history.pushState({}, document.title, "/dashboard/employee");
                },700);
                @endif
            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                // console.log(ors_tbl.page.info().page);
                $("#ors_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+ors_tbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#ors_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#ors_table");

        $(".dt_filter").change(function () {
            filterDT(ors_tbl);
        })

        //Need to press enter to search
        $('#ors_table_filter input').unbind();
        $('#ors_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                ors_tbl.search(this.value).draw();
            }
        });

        $("body").on("click",".show_ors_btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.ors.show","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })




        $(".select2_pap_code").select2({
            ajax: {
                url: "{{route('dashboard.ajax.get','pap')}}",
            },
            placeholder: 'Select item',
        });
        $("#select2_payee").select2();
    </script>
@endsection