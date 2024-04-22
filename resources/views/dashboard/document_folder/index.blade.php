@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Document Folders</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Folders</h3>
            </div>
            <div class="box-body">
                <div id="df_table_container" style="">
                    <table class="table table-bordered table-striped table-hover" id="df_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >Folder Code</th>
                            <th >Folder Name</th>
                            <th >Documents</th>
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
        df_tbl = $("#df_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.document_folder.index')}}',
            "columns": [
                { "data": "folder_code" },
                { "data": "description" },
                { "data": "documents" },
                { "data": "action"}
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 3,
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
                // console.log(df_tbl.page.info().page);
                $("#df_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+df_tbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#df_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#df_table");

        //Need to press enter to search
        $('#df_table_filter input').unbind();
        $('#df_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                df_tbl.search(this.value).draw();
            }
        });
    </script>
@endsection