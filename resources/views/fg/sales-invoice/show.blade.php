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
                { data : "control_no" },
                { data : "date" },
                { data : "remarks" },
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
                    data : 'collection.payor',
                    name : 'collection.payor',
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
    </script>
@endsection