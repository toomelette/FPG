@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Payroll</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title>
            <button type="button" data-bs-target="#upload-tax" data-bs-toggle="modal" class="btn btn-secondary btn-sm float-end"><i class="fa fa-upload"></i> Upload & Distribute Tax (Diff)</button>
        </x-slot:title>

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
    <x-adminkit.html.modal id="clone-payroll-modal" size="sm"/>
    <x-adminkit.html.modal-template id="upload-tax" form-id="upload-tax-form">
        <x-slot:title>Upload Excel</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="File" name="file" cols="12" type="file"/>
        </div>

        <table class="table table-bordered table-striped table-sm">
            <thead>
            <tr>
                <th style="width: 50px;"></th>
                <th>Month</th>
                <th>Type</th>
            </tr>
            </thead>
            <tbody>
            @php
                $diffs = \App\Models\HRU\PayrollMaster::query()
                    ->where('type','=','DIFF')
                    ->orderBy('date')
                    ->orderBy('type')
                    ->get();
            @endphp

            @forelse($diffs as $diff)
                <tr>
                    <td>
                        <label>
                            <input class="payroll-selector" type="checkbox" checked name="payrolls[]" value="{{$diff->slug}}">
                        </label>
                    </td>
                    <td>
                        {{Helper::dateFormat($diff->date,'Y F')}}
                    </td>
                    <td>
                        {{$diff->type}}
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>

        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
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
                    targets : [2],
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
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })


        $("body").on("click",".clone-payroll-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.payroll_preparation.index","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                data: {
                    clone : true,
                    slug : btn.attr('data'),
                },
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $("#upload-tax-form").submit(function (e){
            e.preventDefault();
            let form = $(this);
            var formData = new FormData(this);
            let uri = '{{route("dashboard.payroll_preparation.update",'slug')}}?uploadTax=true';
            loading_btn(form);
            $.ajax({
                url : uri,
                data: formData,
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Excel data successfully imported','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection