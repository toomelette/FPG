@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Leave Applications</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="la-table-container" style="">
            <table class="table table-bordered table-striped table-sm" id="la-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >Date of Application</th>
                    <th >Employee</th>
                    <th class="th-20">Type of Leave</th>
                    <th >Inclusive Dates</th>
                    <th >Status</th>
                    <th class="action">Action</th>
                    <th >Last</th>
                    <th >Middle</th>
                    <th >First</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        leaveApplicationsTbl = $("#la-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.leave_application.index')}}',
            columns: [
                { data: "date_of_filing" },
                { data: "employee.full_name" },
                { data: "leave_type" },
                { data: "inclusive_dates" },
                { data: "status" },
                { data: "action"},
                { data: "lastname"},
                { data: "middlename"},
                { data: "firstname"},
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top'
                },
                {
                    targets : 5,
                    orderable : false,
                    searchable: false,
                },
                {
                    targets : 1,
                    orderable : false,
                    searchable: false,
                },
                {
                    targets: [6,7,8],
                    visible: false,
                }
            ],
            order:[[0,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        leaveApplicationsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

    </script>
@endsection