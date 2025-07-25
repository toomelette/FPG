@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Employee Time Logs</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="logs-table-container" class="table-responsive">
            <table class="table table-bordered table-sm" id="logs-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th>Date</th>
                    <th>Employee</th>
                    <th>AM IN</th>
                    <th>PM OUT</th>
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
        logsTbl = $("#logs-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.employee_time_logs.index')}}',
            columns: [
                {data: 'date', name: 'date'},
                {data: 'employee.full.LFEMi', name: 'employee.fullname'},
                {data: 'am_in', name: 'am_in'},
                {data: 'pm_out', name: 'pm_out'}
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top',
                },
                {
                    targets : [2,3],
                    class : 'text-center',
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
                        logsTbl.search(this.value).draw();
                    }
                });

                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    logsTbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
                    active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
                    toast('info','Leave application successfully updated..','Updated!');
                    window.history.pushState({}, document.title, "/dashboard/leave_application/user_index");
                },700);
                @endif
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

    </script>
@endsection