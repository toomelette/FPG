@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Project Expense Liquidation</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <table class="table table-bordered table-striped table-hover table-sm" id="project-expense-liquidation-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th style="width: 10%">Control No.</th>
                <th style="width: 10%">Date</th>
                <th>Remarks</th>
                <th  style="width: 30%">Project</th>
                <th>Details</th>
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
        projectExpenseLiquidationTbl = $("#project-expense-liquidation-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "control_no" },
                { data : "date" },
                { data : "remarks" },
                { data : "projects_view" },

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
                    targets : 5,
                    orderable : false,
                    class : ''
                },

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
            }
        })

    </script>
@endsection