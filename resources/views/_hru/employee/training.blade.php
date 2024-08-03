@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content')

@section('modal-header')
    <i class="fa icon-seminar"></i> {{$employee->lastname}}, {{$employee->firstname}} - Trainings
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right btn-group-sm" role="group" aria-label="...">
                <button class="btn btn-default pull-left btn-sm" data-toggle="modal" data-target="#print_training_modal"><i class="fa fa-print"></i> Print</button>
                <button class="btn btn-primary pull-right btn-sm" data-toggle="modal" id="add_training_btn_{{$rand}}" data-target="#add_training_modal"><i class="fa fa-plus"></i> Add</button>
            </div>
        </div>
    </div>
    <br>
    <div id="training_table_container" style="display: none">
        <table class="table table-bordered table-striped table-hover training_{{$rand}}" id="training_table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Seq #</th>
                <th>Title</th>
                <th>Started</th>
                <th>Ended</th>
                <th>Detailed Period</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="tbl_loader_training">
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
    trainings_active = '';
    uri = "{{route('dashboard.employee.training','slug')}}";
    uri = uri.replace('slug','{{$employee->slug}}');
    trainings_tbl = $("#training_table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : uri,
        "columns": [
            { "data": "sequence_no" },
            { "data": "title" },
            { "data": "date_from" },
            { "data": "date_to" },
            { "data": "detailed_period" },
            { "data": "action" }
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 0,
                "class" : 'w-6p'
            },
            {
                "targets" : 1,
                "class" : 'w-50p'
            },
            {
                "targets" : [2,3],
                "class" : 'w-8p'
            },
            {
                "targets" : 4,
                "class" : 'w-20p'
            },
            {
                "targets" : 5,
                "orderable" : false,
                "class" : 'action-8p'
            },
        ],
        "order":[[0,'desc']],
        "responsive": false,
        "initComplete": function( settings, json ) {
            style_datatable("#training_table");

            //Need to press enter to search
            $('#training_table_filter input').unbind();
            $('#training_table_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    trainings_tbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(trainings_active != ''){
                $("#training_table #"+trainings_active).addClass('success');
            }
        }
    })



    $("#add_training_btn_{{$rand}}").click(function () {
        btn = $(this);
        load_modal2(btn);
        uri = "{{route('dashboard.employee.training','slug')}}";
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

    $(".training_{{$rand}}").on('click','.edit_training_btn',function () {
        btn = $(this);
        load_modal2(btn);
        var uri = "{{route('dashboard.employee.training','slug')}}";
        uri  = uri.replace("slug",'{{$employee->slug}}');
        $.ajax({
            url : uri,
            data : {edit : 1, training : btn.attr('data')},
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

    $("#print_training_form").attr("action","{{route('dashboard.employee.training_print',$employee->slug)}}");
</script>
@endsection

