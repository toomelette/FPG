@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>My Cash Advances</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" id="intro" data-intro='Click here.' data-bs-target="#add-cash-advance-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> Make Request</button>
        </x-slot:title>
        <table class="table table-bordered table-striped table-hover table-sm" id="cash-advances-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Date</th>
                <th>Type</th>
                <th>Requested By</th>
                <th>Reason</th>
                <th>Requested Amount</th>
                <th>Approved Amount</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-cash-advance-modal" size="sm" form-id="add-cash-advance-form">
        <x-slot:title>Make Cash Advance Request</x-slot:title>
        <div class="row">
            <x-forms.input label="Date" name="date" cols="6" type="date"/>
        </div>

        <div class="row mt-2">
            <x-forms.select :options="\App\Swep\Helpers\Arrays::cashAdvanceTypes()" label="Type" name="type" cols="12" />
        </div>

        <div class="row mt-2">
            <x-forms.textarea label="Reason" name="reason" cols="12" />
        </div>
        <div class="row mt-2">
            <x-forms.input label="Requested by" name="requested_by" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Amount requested" name="amount_requested" cols="6" class="autonum"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-cash-advance-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        cashAdvancesTbl = $("#cash-advances-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{route('cash-advances.my')}}',
            columns : [
                { data : "date" },
                { data : "type" },
                { data : "requested_by" },
                { data : "reason" },
                { data : "amount_requested" },
                { data : "amount_approved" },
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
                    targets: 0,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MM/DD/YYYY');
                    }
                },
                {
                    targets : 6,
                    orderable : false,
                    class : ''
                },
                {
                    targets: [4,5],
                    class : 'text-end',
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2);
                    }
                }
            ],
            order:[[0,'desc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        cashAdvancesTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        
        $("#add-cash-advance-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("cash-advances.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.uuid;
                    cashAdvancesTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        });

        $("body").on("click",".edit-cash-advance-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("cash-advances.edit","slug")}}';
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