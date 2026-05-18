@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$salesInvoice->remarks}}</x-slot:title>
        <x-slot:subtitle>{{$salesInvoice->client->name}} - {{$salesInvoice->client->account_no}}</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Project Expense Liquidation</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Collections</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-3" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Project Preparation</a></li>
            <li class="nav-item" role="presentation"><a class="nav-link" href="#tab-4" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">Delivery Receipts</a></li>

        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1" role="tabpanel">
                <h4 class="tab-title">Projects/Invoices</h4>
                <table class="table table-bordered table-striped table-hover table-sm" id="project-expense-liquidation-table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th>Control No.</th>
                        <th>Date</th>
                        <th>Remarks</th>
                        <th>Details</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab-2" role="tabpanel">
                <h4 class="tab-title">Collections</h4>
                <table class="table table-bordered table-striped table-hover table-sm" id="collections-table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th style="width: 110px;">Collection Date</th>
                        <th>Ref No.</th>
                        <th style="width: 120px;">Payor</th>
                        <th>Amount distributed</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab-3" role="tabpanel">
                <h4 class="tab-title">Project Preparation</h4>
                <table class="mt-2 table table-bordered table-striped table-hover table-sm" id="project-preparation-table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th style="width: 150px;">Control No</th>
                        <th>Remarks</th>
                        <th style="width: 150px">Total Amount</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab-4" role="tabpanel">
                <h4 class="tab-title">Delivery Receipts</h4>
                <table class="mt-2 table table-bordered table-striped table-hover table-sm" id="delivery-receipt-table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th style="width: 100px;">DR No</th>
                        <th style="width: 100px;">DR Type</th>
                        <th>Terms</th>
                        <th>Remarks</th>
                        <th style="width: 150px">Total Amount</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">

        let active = '';
        projectExpenseLiquidationTbl = $("#project-expense-liquidation-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}?liquidationsTable',
            columns : [
                {
                    data : "liquidation.control_no",
                    name : "liquidation.control_no"
                },
                {
                    data : "liquidation.date",
                    name : "liquidation.date"
                },
                {
                    data : "liquidation.remarks",
                    name : "liquidation.remarks"
                },
                { data : "details" },
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
                    targets : 4,
                    orderable : false,
                    class : ''
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
                        projectExpenseLiquidationTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        });

        let collectionsActive = '';
        collectionsTbl = $("#collections-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}?collectionsTable',
            columns : [
                {
                    data : 'collection.date',
                    name : 'collection.date',
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                {
                    data : 'collection.ref_no',
                    name : 'collection.ref_no',
                },
                {
                    data : "collection.client.name",
                    name : "collection.client.name"
                },
                {
                    data : "amount" ,
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
                    targets : 3,
                    class : 'text-end',
                },
                {
                    targets : 4,
                    orderable : false,
                    class : ''
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
                        collectionsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(collectionsActive != ''){
                    $("#"+settings.sTableId+" #"+collectionsActive).addClass('table-success');
                }
            }
        })

        let preparationActive = '';
        projectPreprartionTbl = $("#project-preparation-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}?preparationsTable',
            columns : [
                { data : "control_no" },
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
                    targets: 2,
                    orderable : false,
                    searchable : false,
                    class : 'text-end'
                },
                {
                    targets : 3,
                    orderable : false,
                    searchable : false,
                    class : ''
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
                        projectPreprartionTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+preparationActive).addClass('table-success');
                }
            }
        })

        let deliveryActive = '';
        deliveryReceiptTbl = $("#delivery-receipt-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}?deliveriesTable',
            columns : [
                { data : "control_no" },
                { data : "type" },
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
            order:[[0,'asc']],
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
                    $("#"+settings.sTableId+" #"+deliveryActive).addClass('table-success');
                }
            }
        })
    </script>
@endsection