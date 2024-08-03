@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>My Requests</h1>
    </section>

    <section class="content">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">MIS Service Requests</h3>
                <button type="button" class="btn btn-primary pull-right" data-target="#new_request_modal" data-toggle="modal"><i class="fa fa-plus"></i> Make request</button>
            </div>
            <div class="box-body">
                <div id="requests_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="requests_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Request No.</th>
                            <th >Nature of Request</th>
                            <th >Request Details</th>
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
    <div class="modal fade" id="new_request_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div id="create_form_container">
                    <form id="create_request_form">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Create service request</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">

                                {!! \App\Swep\ViewHelpers\__form2::select('department',[
                                    'cols' => 12,
                                    'label' => 'Department',
                                    'options' => \App\Swep\Helpers\Arrays::departmentList(),
                                ]) !!}

                                {!! __form::select_static2(
                                    '12 nature_of_request', 'nature_of_request', 'Nature of Request:', '', \App\Swep\Helpers\Helper::mis_request_nature(), '', '', '', ''
                                ) !!}

                            </div>
                            <div class="row">
                                {!! __form::textarea('12 details', 'details', 'Details: ', '', '', '', '', '') !!}
                            </div>
                            <div class="row">
                                {!! \App\Swep\ViewHelpers\__form2::textbox('email',[
                                    'cols' => '6',
                                    'label' => 'Email address:',
                                ]) !!}
                                {!! \App\Swep\ViewHelpers\__form2::textbox('Contact No.',[
                                    'cols' => '6',
                                    'label' => 'Contact No.:',
                                ]) !!}
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create</button>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div id="confirmation" style="display: none; margin-bottom: 20px">
                            <center>
                                <img src="{{asset('images/check.gif')}}" width="300">
                                <p>Request has been created.</p>
                                <label style="font-size: larger" id="req_no"></label>
                                <br>
                                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close"><i class="fa fa-check"></i> Done</button>
                                <button type="button" class="btn btn-primary" id="print_request_after_submit" data=""><i class="fa fa-print"></i>  Print</button>
                            </center>
                        </div>
                    </div>
                </div>
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
          "ajax" : '{{route("dashboard.mis_requests.my_requests")}}',
          "columns": [
            { "data": "request_no" },
            { "data": "nature_of_request" },
            { "data": "request_details" },
              { "data": "created_at" },
            { "data": "status" },
            { "data": "action" },
          ],
          "buttons": [
            {!! __js::dt_buttons() !!}
          ],
          "columnDefs":[

            {
              "targets" : 5,
              "orderable" : false,
              "class" : 'action4'
            },
          ],
          "responsive": false,
            "order" : [[3,'desc'],[1,'asc']],
          "initComplete": function( settings, json ) {
            $('#tbl_loader').fadeOut(function(){
              $("#requests_table_container").fadeIn();
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
        $("#create_request_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.mis_requests.store")}}',
                data :  form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   succeed(form,true,false);
                   notify('Service request has been created.','success');
                   $("#create_form_container").slideUp();
                   $("#confirmation").slideDown();
                   $("#req_no").html('Ticket no: '+res.request_no);
                    let uri = '{{route("dashboard.mis_requests.print_request_form","slug")}}';
                    uri = uri.replace('slug',res.slug);
                    // $("#print_frame").attr('src',uri);
                    $("#print_request_after_submit").attr('data',res.slug);
                   active = res.slug;
                   requests_tbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                    console.log(res);
                }
            })
        })

        $("#new_request_modal").on('hidden.bs.modal', function () {
            $("#create_form_container").show();
            $("#confirmation").hide();
        })
        $("body").on("click",".cancel_request_btn", function () {
            btn = $(this);
            var id = btn.attr('data');
            Swal.fire({
                title: 'Cancel request?',
                // input: 'text',
                html: btn.attr('text'),
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-times"></i> Cancel Request',
                cancelButtonText: 'No',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return $.ajax({
                        url : '{{route('dashboard.mis_requests.cancel_request')}}',
                        type: 'POST',
                        data: {'id':id},
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            active = id;
                            requests_tbl.draw(false);
                        }
                    })
                        .then(response => {
                            return  response;

                        })
                        .catch(error => {
                            console.log(error);
                            Swal.showValidationMessage(
                                'Error : '+ error.responseJSON.message,
                            )
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    Swal.fire({
                        title: result.value,
                        icon : 'success',
                    })

                }

            })
        })

        $("body").on("click",".print_request_btn",function () {

            btn = $(this);
            wait_this_button(btn);
            let uri = '{{route("dashboard.mis_requests.print_request_form","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $("#print_frame").attr('src',uri);
        })
        $("#print_frame").on("load",function () {
            $(this).get(0).contentWindow.print();
            $(".print_request_btn").each(function () {
                btn = $(this);
                unwait_this_button(btn);
            })
        })

        $("#print_request_after_submit").click(function () {
            let uri = '{{route("dashboard.mis_requests.print_request_form","slug")}}';
            uri = uri.replace('slug', $(this).attr('data'));
            $("#print_frame").attr('src',uri);
        })

        $("body").on("click",".status_btn",function () {
            btn = $(this);
            let uri = '{{route("dashboard.mis_requests_status.index_open")}}';
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
                    populate_modal2_error(res);
                    notify('Ajax error.','danger');
                }
            })
        })
    </script>

@endsection