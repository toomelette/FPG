@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Delivery Receipts</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <table class="mt-2 table table-bordered table-striped table-hover table-sm" id="delivery-receipt-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th style="width: 100px;">DR No</th>
                <th style="width: 100px;">Date</th>
                <th>Project</th>
                <th>Client</th>
                <th>Terms</th>
                <th>Remarks</th>
                <th style="width: 150px">Total Amount</th>
                <th style="width: 80px;">Action</th>
                <th>Temp Name</th>
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
        deliveryReceiptTbl = $("#delivery-receipt-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "control_no" },
                { data : "date" },
                {
                    data : "invoice.remarks",
                    name : "invoice.remarks",
                },
                {
                    data : "invoice.client.name",
                    name : "invoice.client.name",
                },
                { data : "terms" },
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
                { data : "temp_name" },
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
                    targets: 3,
                    render: function (data, type, row, meta) {
                        if(data){
                            return data;
                        }
                        return row.temp_name;
                    }
                },
                {
                    targets: 6,
                    orderable : false,
                    searchable : false,
                    class : 'text-end'
                },
                {
                    targets : 7,
                    orderable : false,
                    searchable : false,
                    class : ''
                },
                {
                    targets : 8,
                    visible : false
                },
                {
                    targets: 1,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                }
            ],
            order:[[1,'desc'],[0,'desc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        deliveryReceiptTbl.search(this.value).draw();
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