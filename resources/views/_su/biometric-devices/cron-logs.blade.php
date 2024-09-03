@php
$rand = Str::random();
 @endphp
@extends('adminkit.modal')

@section('modal-header')

@endsection

@section('modal-body')
    <table class="table table-sm table-striped" id="cron-logs-table-{{$rand}}" style="width: 100%;">
        <thead>
        <tr>
            <th>Log</th>
            <th>Type</th>
            <th>Timestamp</th>
        </tr>
        </thead>
        <tbody>


        </tbody>
    </table>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        logsTbl = $("#cron-logs-table-{{$rand}}").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route("dashboard.biometric_devices.index")}}?cronLogsTable=true&deviceId={{$device->id}}',
            columns: [
                {data: 'log' },
                {data: 'type' },
                {data: 'created_at' },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
            ],
            order:[[2,'desc']],
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
            },
            drawCallback: function(settings){
            }
        })
    </script>
@endsection