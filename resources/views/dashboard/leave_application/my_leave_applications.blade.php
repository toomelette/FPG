@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>My Leave Applications</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">List of leave applications</h3>
            </div>
        
            <div class="box-body">
                <div id="la_table_container" style="">
                    <table class="table table-bordered table-striped table-hover" id="la_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Date of Application</th>
                            <th class="th-20">Type of Leave</th>
                            <th >Inclusive Dates</th>
                            <th >Email</th>
                            <th >Status</th>
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
            "ajax" : '{{route('dashboard.leave_application.user_index')}}',
            "columns": [
                { "data": "date_of_filing" },
                { "data": "leave_type" },
                { "data": "inclusive_dates" },
                { "data": "email" },
                { "data": "status" },
                { "data": "action"}
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 5,
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
    </script>
@endsection