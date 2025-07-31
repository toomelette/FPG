@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Request for Certifications and Other HR Documents</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div id="logs-table-container" class="table-responsive">
            <table class="table table-bordered table-sm" id="logs-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th>Date of Request</th>
                    <th>Requester</th>
                    <th>Requested Document</th>
                    <th>Tracking No.</th>
                    <th>Staus</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="update-status-modal" size="lg"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        requestsTbl = $("#logs-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.hr_requests.index')}}',
            columns: [
                {data: 'created_at', name: 'created_at'},
                {data: 'employee.full.LFEMi', name: 'employee.fullname'},
                {data: 'document', name: 'document'},
                {data: 'tracking_no', name: 'tracking_no'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'}
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top',
                }
            ],
            order:[[3,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        requestsTbl.search(this.value).draw();
                    }
                });

                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    requestsTbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
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

        $("body").on("click",".update-status-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.hr_requests.edit","slug")}}';
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