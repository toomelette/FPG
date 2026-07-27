@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>My Petty Cash Liquidations</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" data-bs-target="#add-liquidation-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="liquidations-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Date</th>
                <th>Attachments</th>
                <th>Amount</th>
                <th>Status</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="show-files-modal" size="lg"/>
<x-adminkit.html.modal-template id="add-liquidation-modal" size="lg" form-id="add-liquidation-form">
    <x-slot:title>New Liquidation</x-slot:title>
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <x-forms.input label="Date" name="date" cols="12" type="date"/>
            </div>
            <div class="row mt-2">
                <x-forms.input label="Total Amount" name="total_amount" cols="12" class="autonum text-end"/>
            </div>
        </div>
        <div class="col-md-9">
            <input id="attachments" name="attachments[]" type="file" class="file fi" multiple
                   data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
        </div>
    </div>
    <x-slot:footer>
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
    </x-slot:footer>
</x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-petty-cash-liquidations-modal" size="lg"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("body").on("click",".show-files-button",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("petty-cash-liquidations.show","slug")}}?showFiles';
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


        let active = '';
        pettyCashLiquidationsTbl = $("#liquidations-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{Request::getUri()}}',
            columns : [
                { data : "date" },
                { data : "attachments_view" },
                { data : "total_amount" },
                { data : "status" },
                { data : "action" },
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets: '_all',
                    class: 'align-top'
                },
                {
                    targets : 0,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                {
                    targets : 1,
                    orderable : false,
                    class : ''
                },
                {
                    targets : 2,
                    class : 'text-end',
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2);
                    }
                },
            ],
            order:[[0,'desc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        pettyCashLiquidationsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-liquidation-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("petty-cash-liquidations.store")}}',
                data : formData,
                type: 'POST',
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.uuid;
                    pettyCashLiquidationsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-petty-cash-liquidations-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("petty-cash-liquidations.edit","slug")}}';
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