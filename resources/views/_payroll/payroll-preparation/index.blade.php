@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Payroll</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="payroll-table-container">
            <table class="table table-bordered table-sm" id="payroll-table">
                <thead>
                <tr>
                    <th>Payroll Date</th>
                    <th>Payroll Type</th>
                    <th>Employees.</th>
                    <th>Details</th>
                    <th>Amount</th>
                    <th style="width: 80px">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        payrollTbl = $("#payroll-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.payroll_preparation.index')}}',
            columns: [
                { data : "date" },
                { data : "type" },
                { data : "payroll_master_employees_count" },
                { data : "details" },
                { data : "total_amount" },
                { data : "action"}
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : 5,
                    orderable : false,
                    searchable: false,
                },
                {
                    targets : 4,
                    orderable : false,
                    searchable: false,
                    class : 'text-end'
                },
                {
                    targets : [1,2],
                    orderable : false,
                    searchable: false,
                    class : 'text-center'
                },
            ],
            order:[[0,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        payrollTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

    </script>
@endsection