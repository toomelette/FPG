@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Payroll Adjustments</x-slot:title>

    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" data-bs-target="#add-adjustment-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>
        <table class="table table-bordered table-striped table-hover table-sm" id="adjustments-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th >Code</th>
                <th>Description</th>
                <th>Type</th>
                <th>Priority</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-adjustment-modal" size="sm" form-id="add-adjustment-form">
        <x-slot:title>New Adjustment</x-slot:title>
        <div class="row">
            <x-forms.input label="Code" name="code" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Description" name="description" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.select label="Type" name="type" cols="12" :options="\App\Swep\Helpers\Arrays::payrollAdjustmentTypes()"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Priority" name="priority" cols="12"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    
    <x-adminkit.html.modal id="edit-adjustment-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        adjustmentsTbl = $("#adjustments-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "code" },
                { data : "description" },
                { data : "type" },
                { data : "priority" },
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
                    orderable : false,
                    class : ''
                },

            ],
            order:[[2,'desc'],[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        adjustmentsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-adjustment-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("payroll-adjustments.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.id;
                    adjustmentsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-adjustment-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("payroll-adjustments.edit","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
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
    </script>
@endsection