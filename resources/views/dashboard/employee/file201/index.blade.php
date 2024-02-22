@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content')

@section('modal-header')
    <i class="fa fa-folder"></i> {{$employee->lastname}}, {{$employee->firstname}} - 201 File
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-primary btn-sm pull-right" id="add_file201_btn_{{$rand}}" data-toggle="modal" data-target="#add_file201_modal"><i class="fa fa-plus"></i> Add</button>
        </div>
    </div>
    <br>
    <div id="file201_table_container" style="display: none">
        <table class="table table-bordered table-striped table-hover file_201_{{$rand}}" id="file_201_table_{{$rand}}" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Date</th>
                <th >Title</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="tbl_loader_file201">
        <center>
            <img style="width: 100px" src="{{asset('images/loader.gif')}}">
        </center>
    </div>
@endsection

@section('modal-footer')

@endsection

@section('scripts')
    <script type="text/javascript">
        file201_active = '';
        $("#add_file201_btn_{{$rand}}").click(function () {
            let btn = $(this);
            load_modal2(btn);
            $.ajax({
                url : '{{route("dashboard.file201.create")}}',
                data : {employee : '{{$employee->slug}}'},
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

        file_201_tbl = $("#file_201_table_{{$rand}}").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route("dashboard.file201.index")}}?employee={{$employee->slug}}',
            "columns": [
                { "data": "date" },
                { "data": "title" },
                { "data": "description" },
                { "data": "filename" },
                { "data": "action" },
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 4,
                    "orderable" : false,
                    "class" : 'action-10p'
                },
            ],
            "order":[[0,'desc']],
            "responsive": false,
            "initComplete": function( settings, json ) {
                $('#tbl_loader_file201').fadeOut(function(){
                    $("#file201_table_container").fadeIn();
                });
            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(file201_active != ''){
                    $("#file_201_table_{{$rand}} #"+file201_active).addClass('success');
                }
            }
        })

        $('#file_201_table_{{$rand}}_filter input').unbind();
        $('#file_201_table_{{$rand}}_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                file_201_tbl.search(this.value).draw();
            }
        });

        $("body").on("click",'#file_201_table_{{$rand}} .edit_file201_btn',function () {
            let btn = $(this);
            let uri = btn.attr('uri');
            load_modal2(btn);
            $.ajax({
                url : uri,
                // data : 'GET',
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
    </script>
@endsection

