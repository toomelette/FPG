@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Manage PAP</h1>
    </section>

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Projects Activities and Programs</h3>
                <div class="pull-right">
                    <div class="btn-group">
                        <button class="btn btn-default btn-sm hidden" data-target="#adjustment_modal" data-toggle="modal"> Budget Adjustment</button>
                        <button class="btn btn-primary btn-sm" data-target="#add_modal" data-toggle="modal"><i class="fa fa-plus"></i> Add PAP</button>
                    </div>
                </div>
            </div>
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
                                    {!! \App\Swep\ViewHelpers\__form2::select('resp_center',[
                                        'label' => 'Resp Center:',
                                        'cols' => '4 dt_filter-parent-div',
                                        'class' => 'dt_filter filters',
                                        'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                                    ]) !!}

                                </div>
                            </form>
                        </div>

                    </div>
                </div>


                <div id="pap_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="pap_table" style="width: 100% !important">
                        <thead>
                        <tr class="">
                            <th style="width: 10%;">RESP CENTER/DEPT</th>
                            <th class="th-20" style="width: 10%;">PAP Code</th>
                            <th style="width: 20%;">PAP Title</th>
                            <th style="width: 10%;">CO</th>
                            <th style="width: 10%;">MOOE</th>
                            <th style="width: 10%;">Total budget</th>
                            <th style="width: 10%;">Procurement</th>
                            <th style="width: 10%;">Action</th>
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
    <div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-labelledby="add_modalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="add_pap_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="add_modalLabel">New PAP</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::select('year',[
                                'label' => 'Year:',
                                'cols' => 6,
                                'options' => 'year',
                            ]) !!}
                            {!! \App\Swep\ViewHelpers\__form2::select('budget_type',[
                                'label' => 'Budget Type:',
                                'cols' => 6,
                                'options' => \App\Swep\Helpers\Arrays::fundSources(),
                            ]) !!}

                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::select('resp_center',[
                                'label' => 'Responsibility Center:',
                                'cols' => 12,
                                'options' => \App\Swep\Helpers\Arrays::groupedRespCodes(),
                            ]) !!}
                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('pap_code',[
                                'label' => 'PAP Code:*',
                                'cols' => 12,
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('pap_title',[
                                'label' => 'PAP Title:*',
                                'cols' => 12,
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textarea('pap_desc',[
                                'label' => 'PAP Description:*',
                                'cols' => 12,
                            ]) !!}
                        </div>

                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('ps',[
                                'label' => 'PS:',
                                'cols' => 4,
                                'class' => 'text-right autonum'
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('co',[
                                'label' => 'Capital Outlay:',
                                'cols' => 4,
                                'class' => 'text-right autonum'
                            ]) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('mooe',[
                                'label' => 'MOOE:',
                                'cols' => 4,
                                'class' => 'text-right autonum'
                            ]) !!}
                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('pcent_share',[
                                'label' => 'Percent Share:*',
                                'cols' => 4,
                                'type' => 'number',
                                'step' => '0.01',
                            ]) !!}
                            {!! \App\Swep\ViewHelpers\__form2::select('type',[
                                'label' => 'Type:',
                                'cols' => 4,
                                'options' => \App\Swep\Helpers\Arrays::papTypes()
                            ]) !!}
                            {!! \App\Swep\ViewHelpers\__form2::select('status',[
                                'label' => 'Status:',
                                'cols' => 4,
                                'options' => \App\Swep\Helpers\Arrays::activeInactive()
                            ]) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="adjustment_modal" tabindex="-1" role="dialog" aria-labelledby="adjustment_modal_label">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Budget Adjustment</h4>
          </div>
          <div class="modal-body">
            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
                Realignment
            </p>
              <form id="realign_form">
                  <div class="row">
                      {!! \App\Swep\ViewHelpers\__form2::select('source_pap',[
                        'label' => 'Source PAP',
                        'cols' => 12,
                        'options' => $papCodes,
                        'class' => 'pap_code',
                        'id' => 'asrttrrre',
                        ])  !!}
                      {!! \App\Swep\ViewHelpers\__form2::select('destination_pap',[
                        'label' => 'Destination PAP',
                        'id' => 'saa',
                        'cols' => 12,
                        'options' => $papCodes,
                        'class' => 'pap_code',
                        ])  !!}
                      {!! \App\Swep\ViewHelpers\__form2::select('type',[
                        'label' => 'Type:',
                        'cols' => 6,
                        'options' => \App\Swep\Helpers\Arrays::budgetTypes(),
                        ])  !!}
                      {!! \App\Swep\ViewHelpers\__form2::textbox('amount',[
                        'label' => 'Amount',
                        'cols' => 6,
                        ])  !!}
                  </div>
                  <div class="row">
                      <div class="col-md-2 col-md-offset-10">
                          <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Realign</button>
                      </div>
                  </div>
              </form>


            <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
              Supplemental
            </p>
              <form id="supplement_form">
                  <div class="row">
                      {!! \App\Swep\ViewHelpers\__form2::select('destination_pap',[
                        'label' => 'Destination PAP',
                        'cols' => 12,
                        'options' => $papCodes,
                        'class' => 'pap_code',
                        'id' => 'asrttr',
                        ])  !!}
                      {!! \App\Swep\ViewHelpers\__form2::select('type',[
                        'label' => 'Type:',
                        'cols' => 6,
                        'options' => \App\Swep\Helpers\Arrays::budgetTypes(),
                        ])  !!}
                      {!! \App\Swep\ViewHelpers\__form2::textbox('amount',[
                        'label' => 'Amount',
                        'cols' => 6,
                        ])  !!}
                  </div>
                  <div class="row">
                      <div class="col-md-3 col-md-offset-9">
                          <button type="submit" class="btn btn-sm btn-primary col-md-12"><i class="fa fa-check"></i> Supplement</button>
                      </div>
                  </div>
              </form>
          </div>

        </div>
      </div>
    </div>
    {!! \App\Swep\ViewHelpers\__html::blank_modal('ppmp_modal',90) !!}
    {!! \App\Swep\ViewHelpers\__html::blank_modal('edit_ppmp_modal',95,'200px') !!}
    {!! \App\Swep\ViewHelpers\__html::blank_modal('edit_pap_modal','') !!}
    {!! __html::blank_modal('realignmentAndSupplementalModal','lg') !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#add_pap_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.projects.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    active = res.slug;
                    pap_tbl.draw(false);
                    toast('success','PAP created successfully.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })


        $(document).ready(function () {
            //-----DATATABLES-----//
            modal_loader = $("#modal_loader").parent('div').html();
            //Initialize DataTable
            active = '';
            pap_tbl = $("#pap_table").DataTable({
                "ajax" : '{{\Illuminate\Support\Facades\Request::url()}}',
                "columns": [
                    { "data": "resp_center" },
                    { "data": "pap_code" },
                    { "data": "pap_title" },
                    { "data": "co" },
                    { "data": "mooe" },
                    { "data": "totalBudget" },
                    { "data": "procurements" },
                    { "data": "action" }
                ],
                "columnDefs":[
                    {
                        "targets" : 0,
                        "class" : 'w-16p'
                    },
                    {
                        "targets" : [1],
                        "class" : 'w-8p'
                    },
                    {
                        "targets" : [3,4,5,6],
                        "class" : 'w-10p text-right'
                    },
                    {
                        "targets" : 7,
                        "orderable" : false,
                        "class" : 'action4'
                    },
                ],
                "responsive": false,
                'dom' : 'lfrtip',
                "processing": true,
                "serverSide": true,
                "initComplete": function( settings, json ) {
                    style_datatable("#"+settings.sTableId);
                    $('#tbl_loader').fadeOut(function(){
                        $("#"+settings.sTableId+"_container").fadeIn();
                        if(find != ''){
                            pap_tbl.search(find).draw();
                        }
                    });
                    //Need to press enter to search
                    $('#'+settings.sTableId+'_filter input').unbind();
                    $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                        if (e.keyCode == 13) {
                            pap_tbl.search(this.value).draw();
                        }
                    });
                },

                "language":
                    {
                        "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                    },
                "drawCallback": function(settings){
                    $('[data-toggle="tooltip"]').tooltip();
                    $('[data-toggle="modal"]').tooltip();
                    if(active != ''){
                        $("#"+settings.sTableId+" #"+active).addClass('success');
                    }
                }
            });
        })

        $("body").on("click",".edit_pap_btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.projects.edit","slug")}}';
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
        });

        $(".dt_filter").change(function () {
            filterDT(pap_tbl);
        })

        $("body").on("click",".realignmentAndSupplementalModal_btn",function (){
            let btn = $(this);
            let slug = btn.attr('data');
            let uri = '{{route('dashboard.projects.rs','slug')}}';
            uri = uri.replace('slug',slug);
            load_modal2(btn);
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

        $(".pap_code").select2({
            dropdownParent : $("#adjustment_modal"),
        });
        
        $("#realign_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.projects.adjustment","realignment")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    pap_tbl.draw(false);
                    succeed(form,true,false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#supplement_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.projects.adjustment","supplemental")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    pap_tbl.draw(false);
                    succeed(form,true,false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection