@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Petty Cash Liquidation</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">

        <table class="table table-bordered table-striped table-hover table-sm" id="pcl-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Date</th>
                <th>Station</th>
                <th>Attachments</th>
                <th>Amount</th>
                <th>Status</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="show-files-modal" size="lg"/>
    <x-adminkit.html.modal id="pcl-action-modal" size="lg"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        pclTbl = $("#pcl-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "date" },
                { data : "project_id" },
                { data : "attachments_view" },
                { data : "total_amount" },
                { data : "status" },
                { data : "action" },
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets: '_all',
                    class : 'align-top'
                },
                {
                    targets : 4,
                    orderable : false,
                    class : ''
                },
                {
                    targets : 0,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                {
                    targets : 3,
                    class : 'text-end',
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2)
                    }
                },

            ],
            order:[[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        pclTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("body").on("click",".show-files-button",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("petty-cash-liquidations.show","slug")}}?showFiles';
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

        $("body").on("click",".pcl-action-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("petty-cash-liquidations.edit","slug")}}?takeAction';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    autonum_init_modal_new(btn)
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

    </script>
@endsection