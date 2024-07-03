@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Payroll</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Prepared Payroll</h3>
            </div>
        
            <div class="box-body">
                <table class="table table-bordered table-striped table-hover dt" id="payroll_table" style="width: 100%">
                    <thead>
                    <tr class="">
                        <th >Payroll Date</th>
                        <th >Payroll Type</th>
                        <th >Employees</th>
                        <th >Details</th>
                        <th >Amount</th>
                        <th class="action">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        payrollTbl = $("#payroll_table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.payroll_preparation.index')}}',
            "columns": [
                { "data": "date" },
                { "data": "type" },
                { "data": "payroll_master_employees_count" },
                { "data": "details" },
                { "data": "total_amount" },
                { "data": "action"}
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 5,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'action4'
                },
                {
                    "targets" : 4,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'text-right'
                },

            ],
            "responsive": true,
            "initComplete": function( settings, json ) {

            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                // console.log(payrollTbl.page.info().page);
                $("#payroll_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+payrollTbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#payroll_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#payroll_table");

        //Need to press enter to search
        $('#payroll_table_filter input').unbind();
        $('#payroll_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                payrollTbl.search(this.value).draw();
            }
        });
    </script>
@endsection