@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Contact Lists</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title class="pt-3 pb-1">
            <button type="button" data-bs-target="#add-contact-modal" data-intro="Click here." data-bs-toggle="modal" class="btn btn-primary btn-sm float-end"><i class="fa fa-plus"></i> Add new contact</button>
        </x-slot:title>
        <div class="contacts-table-container">
            <table class="table table-bordered table-sm" id="contacts-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Contact No.</th>
                    <th>Logs</th>
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
    <x-adminkit.html.modal-template id="add-contact-modal" size="sm" form-id="add-contact-form">
        <x-slot:title>New contact</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Name" name="name" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Email address" name="email" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Contact no." name="contact_no" cols="12"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-contact-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        contactsTbl = $("#contacts-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.email_contact.index')}}',
            columns: [
                { data : "name" },
                { data : "email" },
                { data : "contact_no" },
                { data : "document_dissemination_log_count" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets: '_all',
                    class : 'align-top',
                },
                {
                    targets : 3,
                    searchable : false,
                    orderable : false,
                    class : 'text-center',
                }
            ],
            order:[[0,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        contactsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-contact-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.email_contact.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Contact successfully added.','Success!');
                    active = res.slug;
                    contactsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-contact-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.email_contact.edit","slug")}}';
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