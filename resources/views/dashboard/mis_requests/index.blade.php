@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Manage ICT Services Requests</h1>
    </section>

    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">MIS Service Requests</h3>
{{--                <button type="button" class="btn btn-primary pull-right" data-target="#new_request_modal" data-toggle="modal"><i class="fa fa-plus"></i> Make request</button>--}}
            </div>
            <div class="box-body">
                <div id="requests_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="requests_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Rqst #.</th>
                            <th >Requisitioner</th>
                            <th >Nature of Request</th>
                            <th >Created at</th>
                            <th >Status</th>
                            <th class="action">Action</th>
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

        <iframe src="" id="print_frame" style="display: none"></iframe>

    </section>


@endsection


@section('modals')
{!! \App\Swep\ViewHelpers\__html::blank_modal('status_modal','lg') !!}
{!! \App\Swep\ViewHelpers\__html::blank_modal('edit_request_modal','lg') !!}
<div id="update_status_modal" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="update_status_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Update Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        {!! __form::textarea('12 status', 'status', 'Status: ', '', '', '', '', '') !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Post Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        function dt_draw() {
            users_table.draw(false);
        }

        function filter_dt() {
            is_online = $(".filter_status").val();
            is_active = $(".filter_account").val();
            users_table.ajax.url("{{ route('dashboard.user.index') }}" + "?is_online=" + is_online + "&is_active=" + is_active).load();

            $(".filters").each(function (index, el) {
                if ($(this).val() != '') {
                    $(this).parent("div").addClass('has-success');
                    $(this).siblings('label').addClass('text-green');
                } else {
                    $(this).parent("div").removeClass('has-success');
                    $(this).siblings('label').removeClass('text-green');
                }
            });
        }
    </script>
    <script type="text/javascript">

        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        requests_tbl = $("#requests_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route("dashboard.mis_requests.index")}}',
            "columns": [
                { "data": "request_no", "name": "request_no" },
                { "data": "fullname", "name": "fullname" },
                { "data": "nature_of_request", "name": "nature_of_request" },
                { "data": "created_at", "name": "created_at" },
                { "data": "status", "name": "status" },
                { "data": "action", "name": "action" },
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
                    "targets" : 3,
                    "class" : 'w-10p'
                },
                {
                    "targets" : 5,
                    "orderable" : false,
                    "class" : 'action4'
                },
            ],
            "responsive": false,
            "order" : [[0,'desc']],
            "initComplete": function( settings, json ) {
                $('#tbl_loader').fadeOut(function(){
                    $("#requests_table_container").fadeIn();
                    if(find != ''){
                        requests_tbl.search(find).draw();
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
                    $("#requests_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#requests_table");

        //Need to press enter to search
        $('#requests_table_filter input').unbind();
        $('#requests_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                requests_tbl.search(this.value).draw();
            }
        });

        $("body").on("click",".status_btn",function () {
            btn = $(this);
            let uri = '{{route("dashboard.mis_requests_status.index")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
            $.ajax({
                url : uri,
                data :{slug:btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   populate_modal2(btn,res);
                },
                error: function (res) {
                    notify('Ajax error.','danger');
                }
            })
        })
        $("#update_status_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.mis_requests_status.store")}}?request_slug='+form.attr('data'),
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form, true,true);
                },
                error: function (res) {
                    errored(form,res);
                    console.log(res);
                }
            })
        })

        $("body").on("click",".update_status_btn",function () {
            let r = $(this).attr('slug');
            let uri = "{{route('dashboard.mis_requests.update','slug')}}?update_status=true";
            uri = uri.replace('slug',$(this).attr('data'));
            Swal.fire({
                title: 'Update status',
                html: 'Request no: <b>'+$(this).attr('request_no')+'</b>',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: 'Save',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    return $.ajax({
                        url : uri,
                        data : {'status':text , 'request_slug' : r},
                        type: 'PUT',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            active = res.slug;
                            requests_tbl.draw(false);
                            notify('Status was successfully updated.','success');
                        },
                        error: function (res) {
                            if(res.status == 422){
                                var message = res.responseJSON.errors.biometric_user_id;
                            }else{
                                var message = res.responseJSON.message;
                            }
                            Swal.showValidationMessage(
                                'Request failed: ' + message
                            );
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                        .catch(error => {
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });

        $("body").on("click",".mark_as_done_btn",function () {
            let r = $(this).attr('slug');
            let uri = "{{route('dashboard.mis_requests.update','slug')}}?mark_as_done=true";
            uri = uri.replace('slug',$(this).attr('data'));
            Swal.fire({
                title: 'Mark as completed?',
                html: 'Request no: <b>'+$(this).attr('request_no')+'</b>',
                // input: '',
                inputAttributes: {
                    autocapitalize: 'off',
                },
                inputValue: '',
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-check"></i> Mark',
                showLoaderOnConfirm: true,
                preConfirm: (text) => {
                    return $.ajax({
                        url : uri,
                        data : {},
                        type: 'PUT',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            active = res.slug;
                            requests_tbl.draw(false);
                            notify('Status was successfully updated.','success');
                        },
                        error: function (res) {
                            if(res.status == 422){
                                var message = res.responseJSON.errors.biometric_user_id;
                            }else{
                                var message = res.responseJSON.message;
                            }
                            Swal.showValidationMessage(
                                'Request failed: ' + message
                            );
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                        .catch(error => {
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });

        $("body").on("click",".edit_request_btn", function () {
            let btn = $(this);
            let uri = '{{route("dashboard.mis_requests.edit","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
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
                    notify('Ajax error.' ,'danger');
                    console.log(res);
                }
            })
        })

        $("#print_frame").on("load",function () {
            $(this).get(0).contentWindow.print();
            $(".print_request_btn").each(function () {
                btn = $(this);
                unwait_this_button(btn);
            })
        })

        $("body").on("click",".print_request_btn",function () {

            btn = $(this);
            wait_this_button(btn);
            let uri = '{{route("dashboard.mis_requests.print_request_form","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $("#print_frame").attr('src',uri);
        })
    </script>


@endsection