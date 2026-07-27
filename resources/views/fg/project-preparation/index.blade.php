@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Project Preparation</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <table class="mt-2 table table-bordered table-striped table-hover table-sm" id="project-preparation-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th style="width: 150px;">Control No</th>
                <th>Project</th>
                <th>Client</th>
                <th>Remarks</th>
                <th style="width: 150px">Total Amount</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        projectPreprartionTbl = $("#project-preparation-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "control_no" },
                {
                    data : "invoice.remarks",
                    name : "invoice.remarks",
                },
                {
                    data : "invoice.client.name",
                    name : "invoice.client.name",
                },
                { data : "remarks" },
                {
                    data : "details_sum_amount",
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2);
                    }
                },
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
                    targets: 4,
                    orderable : false,
                    searchable : false,
                    class : 'text-end'
                },
                {
                    targets : 5,
                    orderable : false,
                    searchable : false,
                    class : ''
                },
            ],
            order:[[0,'desc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        projectPreprartionTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

    </script>
@endsection