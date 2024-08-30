@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>{{$employee->full['LFEMi']}} - {{strtoupper($leaveType)}}</h1>
    </section>
@endsection
@section('content2')

    <section class="content">

        <div class="row">
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Leave Credits</h3>
                        <button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#add-credit-modal"><i class="fa fa-plus"></i> Add Credits</button>
                    </div>
                    <div class="box-body">
                        <div id="lc_table_container" style="">
                            <table class="table table-bordered table-striped table-hover" id="lc_table" style="width: 100%">
                                <thead>
                                <tr class="">
                                    <th >Date</th>
                                    <th >Credits</th>
                                    <th class="action">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Leave Applications</h3>
                    </div>
                    <div class="box-body">
                        <div id="la_table_container" style="">
                            <table class="table table-bordered table-striped table-hover" id="la_table" style="width: 100%">
                                <thead>
                                <tr class="">
                                    <th >Date</th>
                                    <th class="action">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection


@section('modals')
<div class="modal fade" id="add-credit-modal" tabindex="-1" role="dialog" aria-labelledby="add-credit-modal_label">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form id="add-credit-form">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Add Credits</h4>
          </div>
          <div class="modal-body">
              <div class="row">
                  <x-forms.input cols="12" label="Date" name="month" type="date"/>
                  <x-forms.input cols="12" label="Credits (in days)" name="credits" type="number"/>
                  <x-forms.input cols="12" label="Remarks" name="remarks"/>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#add-credit-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.leave_card.view_per_leave_type",[$employee->slug,$leaveType])}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    leaveCreditsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        active = '';
        leaveCreditsTbl = $("#lc_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route("dashboard.leave_card.view_per_leave_type",[$employee->slug,$leaveType])}}?for=leaveCredits',
            "columns": [
                { "data": "month" },
                { "data": "credits" },

                { "data": "action"}
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 2,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'action'
                },

            ],
            "responsive": true,
            "initComplete": function( settings, json ) {

            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                // console.log(leaveCreditsTbl.page.info().page);
                $("#lc_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+leaveCreditsTbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#lc_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#lc_table");

        //Need to press enter to search
        $('#lc_table_filter input').unbind();
        $('#lc_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                leaveCreditsTbl.search(this.value).draw();
            }
        });



        leaveApplicationsTbl = $("#la_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route("dashboard.leave_card.view_per_leave_type",[$employee->slug,$leaveType])}}?for=leaveApplications',
            "columns": [
                { "data": "date" },
                { "data": "action" },
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 1,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'action1'
                },

            ],
            "responsive": true,
            "initComplete": function( settings, json ) {

            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                // console.log(leaveApplicationsTbl.page.info().page);
                $("#la_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+leaveApplicationsTbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#la_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#la_table");

        //Need to press enter to search
        $('#la_table_filter input').unbind();
        $('#la_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                leaveApplicationsTbl.search(this.value).draw();
            }
        });
    </script>
@endsection