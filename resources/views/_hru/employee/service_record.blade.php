@extends('layouts.modal-content')

@php($sr = \Illuminate\Support\Str::random(15))
@section('modal-header')
    <i class="fa icon-service-record"></i> {{$employee->lastname}}, {{$employee->firstname}} - Service Records
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right btn-group-sm" role="group" aria-label="...">
                <button class="btn btn-default pull-left btn-sm" data-toggle="modal" data-target="#print_sr_modal"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="add_sr_btn_{{$sr}}" data-target="#add_sr_modal"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>
    </div>
    <br>
    <div id="service_records_table_container" style="display: none">
        <table class="table table-bordered table-striped table-hover sr_{{$sr}}" id="service_records_table" style="width: 100% !important">
            <thead>
                <tr class="">
                    <th >Seq #</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Position</th>
                    <th>Appt. Status</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="tbl_loader_2">
        <center>
            <img style="width: 100px" src="{{asset('images/loader.gif')}}">
        </center>
    </div>
@endsection

@section('modal-footer')
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
@endsection

@section('scripts')
<script type="text/javascript">
    
    //-----DATATABLES-----//
    modal_loader = $("#modal_loader").parent('div').html();
    //Initialize DataTable
    sr_active = '';
    uri = "{{route('dashboard.employee.service_record','slug')}}";
    uri = uri.replace('slug','{{$employee->slug}}');
    service_records_tbl = $("#service_records_table").DataTable({
      'dom' : 'lBfrtip',
      "processing": true,
      "serverSide": true,
      "ajax" : uri,
      "columns": [
        { "data": "sequence_no" },
        { "data": "from_date" },
        { "data": "to_date" },
        { "data": "position" },
      { "data": "appointment_status" },
          { "data": "salary" },
        { "data": "action" }
      ],
      "buttons": [
        {!! __js::dt_buttons() !!}
      ],
      "columnDefs":[
          {
              "targets" : 5,
              "class" : 'text-right'
          },
        {
          "targets" : 6,
          "orderable" : false,
          "class" : 'action-10p'
        },
      ],
        "order":[[0,'desc']],
      "responsive": false,
      "initComplete": function( settings, json ) {
        $('#tbl_loader_2').fadeOut(function(){
          $("#service_records_table_container").fadeIn();
        });
      },
      "language":
              {
                "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
              },
      "drawCallback": function(settings){
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="modal"]').tooltip();
        if(sr_active != ''){
          $("#service_records_table #"+sr_active).addClass('success');
        }
      }
    })
    
    style_datatable("#service_records_table");
    
    //Need to press enter to search
    $('#service_records_table_filter input').unbind();
    $('#service_records_table_filter input').bind('keyup', function (e) {
      if (e.keyCode == 13) {
        service_records_tbl.search(this.value).draw();
      }
    });

    $("#add_sr_btn_{{$sr}}").click(function () {
        btn = $(this);
        load_modal2(btn);
        uri = "{{route('dashboard.employee.service_record','slug')}}";
        uri = uri.replace('slug','{{$employee->slug}}');

        $.ajax({
            url : uri,
            data : {add: 1},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);

            },
            error: function (res) {
                notify('Ajax error.','danger');
                console.log(res);
            }
        })
    })

    $(".sr_{{$sr}}").on('click','.edit_sr_btn',function () {
        btn = $(this);
        load_modal2(btn);
        var uri = "{{route('dashboard.employee.service_record','slug')}}";
        uri  = uri.replace("slug",'{{$employee->slug}}');
        $.ajax({
            url : uri,
            data : {edit : 1, sr : btn.attr('data')},
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                notify("Ajax error.","danger");
                console.log(res);
            }
        })
    })

    $("#print_sr_form").attr("action","{{route('dashboard.employee.service_record_print',$employee->slug)}}");
</script>
@endsection

