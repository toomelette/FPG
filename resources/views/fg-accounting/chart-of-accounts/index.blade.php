@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Chart of Accounts</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" id="intro" data-intro="Click here." data-bs-target="#add-account-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="accounts-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th >Account Code</th>
                <th>Account Title</th>
                <th >Nature Id</th>
                <th >Is Header</th>
                <th >Subsidiary</th>
                <th style="width: 80px;">Action</th>

            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-account-modal" size="sm" form-id="add-account-form">
        <x-slot:title>New Account</x-slot:title>
        <div class="row">
            <x-forms.input label="Account Code" name="account_code" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Account Title" name="account_title" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.select label="Nature" name="nature_id" cols="12" :options="\App\Swep\Helpers\Arrays::accountNatures()"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-account-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        accountsTbl = $("#accounts-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{Request::getUri()}}',
            columns : [
                { data : "account_code" },
                { data : "account_title" },
                { data : "nature_id" },
                { data : "is_header" },
                { data : "subsidiaries_count" },
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
                    targets : 0,
                    class : 'w-20p'
                },
                {
                    targets : 0,
                    class : 'w-20p'
                },

                {
                    targets : 4,
                    render: function (data) {
                       if(data !== 0){
                           return data;
                       }else{
                           return  '';
                       }
                    }
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
                        accountsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-account-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("chart-of-accounts.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.id;
                    accountsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-account-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("chart-of-accounts.edit","slug")}}';
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