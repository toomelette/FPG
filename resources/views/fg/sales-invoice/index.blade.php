@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{Str::of($book)->lower()->ucfirst()}} @if($book != 'BILLING') Sales Invoice @endif</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
        </x-slot:title>
        <table class="table table-bordered table-striped table-hover table-sm" id="sales-invoice-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Control No.</th>
                <th>Date</th>
                <th>Client</th>
                <th>Remarks</th>
                <th>Amount</th>
                <th>Collections</th>
                <th style="width: 80px;">Action</th>
                <th>UUID</th>
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
    <script src="{{asset('js/fg/sales-invoice-index.js')}}"></script>
    <script type="text/javascript">
        let active = '';
        projectExpenseLiquidationTbl = $("#sales-invoice-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "invoice_no" },
                { data : "date" },
                {
                    data : "client.name",
                    name : "client.name"
                },
                {
                    data : "remarks",
                    name : "remarks"
                },
                { data : "total_amount_due" },
                {
                    data : 'distributions_sum_amount',
                    name : 'distributions_sum_amount'
                },
                { data : "action" },
                { data : "uuid" },
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
                    targets : 1,
                    class : 'w-15p',
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                {
                    targets : 6,
                    orderable : false,
                    class : ''
                },
                {
                    targets: [4],
                    class : 'text-end',
                    render: function (data,type,row,meta) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2);
                    },
                    searchable : false,
                },
                {
                    targets: [5],
                    class : 'text-end',
                    render: function (data,type,row,meta) {
                        if(!data){
                            return  '';
                        }
                        if(data === row.total_amount_due){
                            return '<span class="text-success">'+$.number(data,2)+'</span>';
                        }else{
                            return $.number(data,2);
                        }

                    },
                    searchable : false,
                },
                {
                    targets: 7,
                    visible : false,
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
                        projectExpenseLiquidationTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            },
            createdRow: function (row, data, dataIndex) {
                if (data.status === 'CANCELLED') { // your condition
                    $('td:not(:last-child)', row).addClass('text-strike');
                }
            }
        })

        $(document).ready(function (){
            findDt(projectExpenseLiquidationTbl)
        })


    </script>
@endsection