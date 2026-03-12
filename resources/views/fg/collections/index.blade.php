@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Collection Receipts</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <table class="table table-bordered table-striped table-hover table-sm" id="collections-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th style="width: 110px;">Ref. No.</th>
                <th style="width: 120px;">Date</th>
                <th>Payor</th>
                <th>Remarks</th>
                <th style="width: 150px;">Total Amount Paid</th>
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
        collectionsTbl = $("#collections-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "ref_no" },
                {
                    data : "date",
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                { data : "payor" },
                { data : "remarks" },
                {
                    data : "total_paid",
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
                    targets : 4,
                    class : 'text-end',
                },
                {
                    targets : 5,
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
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

    </script>
@endsection