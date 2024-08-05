@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>My Leave Applications</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="la-table-container" style="">
            <table class="table table-bordered table-striped table-sm" id="la-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >Date of Application</th>
                    <th class="th-20">Type of Leave</th>
                    <th >Inclusive Dates</th>
                    <th >Status</th>
                    <th class="action">Action</th>
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
            ajax : '{{route('dashboard.leave_application.user_index')}}',
            columns: [
                { data: "date_of_filing" },
                { data: "leave_type" },
                { data: "inclusive_dates" },
                { data: "status" },
                { data: "action"}
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
                    targets : 4,
                    orderable : false,
                    searchable: false,
                },
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

                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    leaveApplicationsTbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
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