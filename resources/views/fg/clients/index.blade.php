@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Clients</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end"  data-bs-target="#add-client-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="clients-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Client</th>
                <th>Account No.</th>
                <th>Contact Details</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-client-modal" form-id="add-client-form">
        <x-slot:title>Add New Client</x-slot:title>
        <div class="row">
            <x-forms.input label="Account No." name="account_no" cols="5"/>
            <x-forms.input label="Client Name" name="name" cols="7"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Address" name="address" cols="8"/>
            <x-forms.input label="TIN" name="tin" cols="4"/>
        </div>
        <p class="page-header-sm text-info mt-2" style="border-bottom: 1px solid #cedbe1">
            Contact Person
        </p>
        <div class="row mt-2">
            <x-forms.input label="Name" name="contact_person" cols="7"/>
            <x-forms.input label="Contact No." name="contact_no" cols="5"/>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-client-modal" size=""/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        clientsTbl = $("#clients-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "name" },
                { data : "account_no" },
                { data : "contact_person" },
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
                        clientsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-client-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("clients.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Client successfully added.','Success');
                    active = res.uuid;
                    clientsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-client-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("clients.edit","slug")}}';
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