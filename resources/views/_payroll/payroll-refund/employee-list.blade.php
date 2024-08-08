@php
    $rand = \Illuminate\Support\Str::random();
@endphp
<h4><strong>{{$deductionCode}}</strong> <small>{{$deduction->description ?? ''}}</small></h4>

<div class="employees-table-container">
    <table class="table table-bordered table-sm" id="employees-table-{{$rand}}" style="width: 100%">
        <thead>
        <tr>
            <th>Employee</th>
            <th>Ded. Code</th>
            <th>Amount</th>
            <th>Refund Amt</th>
            <th>Refund Date</th>
            <th>Remarks</th>
            <th style="width: 40px"></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<script type="text/javascript">
    activeTable = '{{$rand}}';
    dataTablesArray["{{$rand}}"]= $("#employees-table-{{$rand}}").DataTable({
        dom : 'lBrtip',
        processing: true,
        serverSide: true,
        ajax : '{{route('dashboard.payroll_refund.index',$payMasterSlug)}}?deductionCode={{$deductionCode}}&show',
        columns: [
            { data : "employee"},
            { data : "code" },
            { data : "amount" },
            { data : "refund_amount" },
            { data : "refund_date" },
            { data : "refund_remarks" },
            { data : "action" }
        ],
        buttons: [
            {!! __js::dt_buttons() !!}
        ],
        columnDefs:[
            {
                targets: [2,3],
                class: 'text-end',
            },
            {
                targets : [1],
                visible : false,
            }
        ],
        pageLength: 25,
        order:[[1,'desc']],
        responsive: false,
        initComplete: function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    employeesTbl{{$rand}}.search(this.value).draw();
                }
            });
        },
        drawCallback: function(settings){
            if(active != ''){
                $("#"+settings.sTableId+" #"+active).addClass('table-success');
            }
        }
    })
</script>