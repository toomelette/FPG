@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Permission Slips</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pb-1 pt-3">
        <table id="ps-table" class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>PS No.</th>
                <th>Date</th>
                <th>Name</th>
                <th>Purpose/Destination</th>
                <th>Pers./Off.</th>
                <th style="width: 80px">Action</th>
                <th>Created At</th>
            </tr>
            </thead>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-time-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        psTbl = $("#ps-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.permission_slip.index')}}',
            columns: [
                { data: "ps_no" },
                { data: "date" },
                { data: "employee_name" },
                { data: "purpose" },
                { data: "personal_official" },
                { data: "action"},
                { data: "created_at"}
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
                {
                    targets : 6,
                    visible: false,
                },
            ],
            order:[[6,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        psTbl.search(this.value).draw();
                    }
                });

                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    psTbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
                    active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
                    toast('info','Leave application successfully updated..','Updated!');
                    window.history.pushState({}, document.title, "/dashboard/permission_slip/user_index");
                },700);
                @endif
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("body").on("click",".edit-time-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.permission_slip.update_time","slug")}}';
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