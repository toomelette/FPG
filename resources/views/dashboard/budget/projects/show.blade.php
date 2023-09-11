@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>{{$pap->pap_code}} <i class="fa fa-caret-right"></i> <span style="font-size: 18px">{{$pap->pap_title}}</span></h1>
        <hr class="no-margin">
        <small>{{$pap->pap_desc}}</small>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <dl>
                            <dt>Responsibility Center:</dt>
                            <dd>{{$pap->responsibilityCenter->desc ?? 'N/A'}}</dd>
                        </dl>
                    </div>
                    <div class="col-md-1">
                        <dl>
                            <dt>Budget Type:</dt>
                            <dd>{{$pap->budget_type}}</dd>
                        </dl>
                    </div>
                    <div class="col-md-1">
                        <dl>
                            <dt>PS:</dt>
                            <dd>{{\App\Swep\Helpers\Helper::toNumber($pap->ps,2,'0.00')}}</dd>
                        </dl>
                    </div>
                    <div class="col-md-2">
                        <dl>
                            <dt>CO:</dt>
                            <dd><table style="width: 100%;">
                                    <tr>
                                        <td>Amount: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->co,2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Utilized: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->orsAppliedProjects->sum('co'),2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="b-top">Balance: </td>
                                        <td class="text-right text-strong b-top" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->co - $pap->orsAppliedProjects->sum('co'),2,'0.00')}}</td>
                                    </tr>
                                </table></dd>
                        </dl>
                    </div>
                    <div class="col-md-2">
                        <dl>
                            <dt>MOOE:</dt>
                            <dd>
                                <table style="width: 100%;">
                                    <tr>
                                        <td>Amount: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->mooe,2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Utilized: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->orsAppliedProjects->sum('mooe'),2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="b-top">Balance: </td>
                                        <td class="text-right text-strong b-top" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($pap->mooe - $pap->orsAppliedProjects->sum('mooe'),2,'0.00')}}</td>
                                    </tr>
                                </table>
                            </dd>
                        </dl>
                    </div>

                    <div class="col-md-2">
                        <dl>
                            <dt>UNOBLIGATED:</dt>
                            <dd>
                                <table style="width: 100%;">
                                    <tr>
                                        <td>Total budget: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($totalBudget = $pap->co + $pap->mooe,2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td>PR: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($prs = $pap->procurementsPr->sum('abc'),2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td>JR: </td>
                                        <td class="text-right text-strong" style="font-family: Consolas">{{\App\Swep\Helpers\Helper::toNumber($jrs = $pap->procurementsJr->sum('abc'),2,'0.00')}}</td>
                                    </tr>
                                    <tr>
                                        <td class="b-top">Balance: </td>
                                        @php
                                            $totalProcurements = $prs + $jrs;
                                            $totalProcurements = $prs + $jrs;
                                            $totalUnobligated = $totalBudget - $totalProcurements;
                                        @endphp
                                        <td class="text-right text-strong b-top {{$totalUnobligated < 0 ? 'text-danger' : ''}}" style="font-family: Consolas">
                                            {{\App\Swep\Helpers\Helper::toNumber($totalUnobligated,2,'0.00')}}
                                        </td>
                                    </tr>
                                </table>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>


        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">ORS</a></li>
                <li><a href="#tab_2" data-toggle="tab">Procurements</a></li>
{{--                <li><a href="#tab_3" data-toggle="tab">Tab 3</a></li>--}}
            </ul>
            <div class="tab-content">

                <div class="tab-pane active" id="tab_1">
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

                                        <div class="col-md-4 dt_filter-parent-div">
                                            <label>Account Entries:</label>
                                            {!! \App\Swep\ViewHelpers\__form2::selectOnly('account_entry',[
                                                'class' => 'select2_clear select2_account_entry dt_filter filters',
                                                'container_class' => 'select2-md',
                                                'options' => [],
                                                'select2_preSelected' => '' ,
                                            ],$data->pap_code ?? null) !!}
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

                <div class="tab-pane" id="tab_2">
                    <div id="procurements_table_container" style="display: none">
                        <table class="table table-bordered table-striped table-hover" id="procurements_table" style="width: 100%">
                            <thead>
                            <tr class="">
                                <th >Ref Book</th>
                                <th class="th-20">Ref No</th>
                                <th class="th-20">Date</th>
                                <th >Requested by</th>
                                <th >Purpose</th>
                                <th >Amount</th>
                                <th >Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="tbl_loader2">
                        <center>
                            <img style="width: 100px" src="{{asset('images/loader.gif')}}">
                        </center>
                    </div>
                </div>

                <div class="tab-pane" id="tab_3">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
                </div>

            </div>

        </div>

    </section>


@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        ors_tbl = $("#ors_table").on('xhr.dt', function (e, settings, json, xhr){
            if(xhr.status > 500){
                alert('Error '+xhr.status+': '+xhr.responseJSON.message);
            }
        }).DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.projects.show',$pap->slug)}}?table=ors',
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
                {
                    extend : 'excel',
                    text: '<i class="fa fa-file-excel-o fa-fw"></i> Excel',
                    className : 'buttons-excel btn-sm',
                    action : function (e, dt, button, config){
                        var self = this;
                        let val = ors_tbl.page.len();
                        let swal = Swal.fire({
                            title: '<strong> Processing </strong>',
                            icon: 'info',
                            html:
                                '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>',
                            showCloseButton: false,
                            showCancelButton: false,
                            showConfirmButton: false,
                            focusConfirm: false,
                        })

                        ors_tbl.page.len(-1).draw();
                        ors_tbl.one('draw',function (){
                            $.fn.DataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                            swal.close();
                            ors_tbl.page.len(val).draw();
                        });
                    },
                    exportOptions: {
                        columns: [ 0,1,2,3,5 ]
                    }
                }
            ],
            "columnDefs":[
                {
                    "targets" : 7,
                    "orderable" : false,
                    "class" : 'action2'
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
                    'targets' : [4,5],
                    'class' : 'w-16p',
                },

            ],
            "order" : [[1, 'desc'],[2,'desc']],
            "responsive": true,
            "initComplete": function( settings, json ) {
                // console.log(settings);
                style_datatable("#"+settings.sTableId);
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
                        // window.history.pushState({}, document.title, "/dashboard/employee");
                    }

                });
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        ors_tbl.search(this.value).draw();
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
                $("#totalCo").html(settings.json.totalCo);
                $("#totalMooe").html(settings.json.totalMooe);
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#ors_table #"+active).addClass('success');
                }
            }
        })


        procurements_tbl = $("#procurements_table").on('xhr.dt', function (e, settings, json, xhr){
            if(xhr.status > 500){
                alert('Error '+xhr.status+': '+xhr.responseJSON.message);
            }
        }).DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.projects.show',$pap->slug)}}?table=procurements',
            "columns": [
                { "data": "ref_book" },
                { "data": "ref_no" },
                { "data": "date" },
                { "data": "requested_by" },
                { "data": "purpose" },
                { "data": "abc"},
                { "data": "action"},

            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 6,
                    "orderable" : false,
                    "visible" : false,
                    "class" : 'action2'
                },
                {
                    'targets' : [0,1,2],
                    "class" : 'w-10p',
                },
                {
                    'targets' : 5,
                    'class' : 'w-10p text-right',
                },

            ],
            "order" : [[1, 'desc'],[2,'desc']],
            "responsive": true,
            "initComplete": function( settings, json ) {
                // console.log(settings);
                style_datatable("#"+settings.sTableId);
                setTimeout(function () {
                    $("#filter_form select[name='is_active']").val('ACTIVE');
                    $("#filter_form select[name='is_active']").trigger('change');
                },100);

                setTimeout(function () {
                    // $('a[href="#advanced_filters"]').trigger('click');
                    // $('.advanced_filters_toggler').trigger('click');
                },1000);

                $('#tbl_loader2').fadeOut(function(){
                    $("#procurements_table_container").fadeIn(function () {
                        @if(request()->has('initiator') && request('initiator') == 'create')
                        introJs().start();
                        @endif
                    });
                    if(find != ''){
                        procurements_tbl.search(find).draw();
                        setTimeout(function(){
                            active = '';
                        },3000);
                        // window.history.pushState({}, document.title, "/dashboard/employee");
                    }

                });
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        procurements_tbl.search(this.value).draw();
                    }
                });
                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    procurements_tbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
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
                // console.log(procurements_tbl.page.info().page);
                $("#procurements_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+procurements_tbl.page.info().page);
                });
                $("#totalCo").html(settings.json.totalCo);
                $("#totalMooe").html(settings.json.totalMooe);
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#procurements_table #"+active).addClass('success');
                }
            }
        })

        $("#select2_payee").select2();

        $(".select2_account_entry").select2({
            ajax: {
                url: "{{route('dashboard.ajax.get','account')}}?add_null=true",
            },
            placeholder: 'Select item',
        });

        $(".dt_filter").change(function (){
            let datatable_object = ors_tbl;
            let data = $("#filter_form").serialize();
            datatable_object.ajax.url("{{Request::url()}}"+"?table=ors&"+data).load();

            $(".dt_filter").each(function (index,el) {
                if ($(this).val() != '' && $(this).val() != 'NULL'){
                    $(this).parent("div").addClass('has-success');
                    $(this).siblings('label').addClass('text-green');
                } else {
                    $(this).parent("div").removeClass('has-success');
                    $(this).siblings('label').removeClass('text-green');
                }
            });
            let withSuccess = $('.dt_filter-parent-div.has-success');
            if(withSuccess.length > 0){
                $("#filter-notifier").html(withSuccess.length+' filter(s) currently active');
            }else{
                $("#filter-notifier").html('');
            }
        })
    </script>
@endsection