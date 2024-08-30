@php
/** @var \App\Models\BiometricDevices $device **/
 $rand = Str::random();
 @endphp
@extends('adminkit.modal')

@section('modal-header')
    {{$device->name}}
@endsection

@section('modal-body')
    <table class="table table-sm table-striped" id="logs-table-{{$rand}}" style="width: 100%;">
    <thead>
    <tr>

        <th>Name</th>
        <th>Action</th>
        <th>Time</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>


    </tbody>
    </table>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal"> Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">

        logsTbl = $("#logs-table-{{$rand}}").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route("dashboard.biometric_devices.attendances")}}?device={{$device->serial_no}}',
            columns: [
                {data: 'fullname',name:'employee.fullname'},
                {data: 'type' },
                {data: 'timestamp' },
                {data: 'user' },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : 3,
                    visible : false,
                }
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