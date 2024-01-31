@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Payroll Template</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">

                        <div id="employees_table_container" style="display: none">
                            <table class="table table-bordered table-striped table-hover table-condensed" id="employees_table" style="width: 100% !important">
                                <thead>
                                <tr class="">
                                    <th >Emp. No.</th>
                                    <th >Fullname</th>
                                    <th >Incentives</th>
                                    <th >Deductions</th>
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
        </div>

    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        var active = '';
        publication_tbl = $("#employees_table").DataTable({
            "ajax" : '{{\Illuminate\Support\Facades\Request::url()}}',
            "columns": [
                { "data": "employee_no" },
                { "data": "fullname" },
                { "data": "incentives" },
                { "data": "deductions" },
                { "data": "action" },
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[

                {
                    "targets" : 4,
                    "orderable" : false,
                    "class" : 'action1'
                },
            ],
            "responsive": false,
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "initComplete": function( settings, json ) {
                style_datatable("#"+settings.sTableId);
                $('#tbl_loader').fadeOut(function(){
                    $("#"+settings.sTableId+"_container").fadeIn();
                    if(find != ''){
                        publication_tbl.search(find).draw();
                    }
                });
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        publication_tbl.search(this.value).draw();
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

        $("body").on("click",".view-employee-btn",function (){
            let btn = $(this);
            let slug = btn.attr('data');
            let uri = btn.attr('uri');

            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#edit-view-container").html(res);
                },
                error: function (res) {

                }
            })

        })
    </script>
@endsection