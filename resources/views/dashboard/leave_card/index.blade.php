@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Leave Cards</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Leave Cards</h3>
            </div>

            <div class="box-body">
                <div id="la_table_container" style="">
                    <table class="table table-bordered table-striped table-hover" id="la_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Employee</th>
                            <th >VL</th>
                            <th >SL</th>
                            <th >Other</th>
                            <th class="action">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </section>

@endsection


@section('modals')
    {!! __html::blank_modal('edit_leave_card_modal','') !!}
@endsection

@section('scripts')
    <script type="text/javascript">

        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        employees_tbl = $("#la_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.leave_card.index')}}',
            "columns": [
                { "data": "lastname" },
                { "data": "vlRemaining" },
                { "data": "slRemaining" },
                { "data": "details" },
                { "data": "action"}
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 4,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'action4'
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
                // console.log(employees_tbl.page.info().page);
                $("#la_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+employees_tbl.page.info().page);
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
                employees_tbl.search(this.value).draw();
            }
        });

        $("body").on("click",".print-btn-dialog",function (){
            let href = $(this).attr('href');
            window.open(href, "popupWindow", "width=1200, height=600, scrollbars=yes");
        })

        $("body").on("click",".edit_leave_card_btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.leave_card.edit","slug")}}';
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
    </script>
@endsection