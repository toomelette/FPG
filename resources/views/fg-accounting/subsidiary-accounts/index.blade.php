@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$account->account_title}} | {{$account->account_code}}</x-slot:title>
        <x-slot:subtitle>Subsidiary Accounts</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
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
                <th >Address</th>
                <th >Contact Person</th>
                <th >Contact No.</th>
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
        <x-slot:title>New Account | {{$account->account_title}}</x-slot:title>
        <div class="row">
            <x-forms.input label="Account Code" id="updating-account-code" name="account_code" cols="12" :value="$account->account_code.'-'"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Account Title" name="account_title" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Address" name="account_address" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Contact Person" name="contact_person" cols="12"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Contact No" name="contact_no" cols="12"/>
        </div>
        @if($account->account_code == '11000')
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" checked name="create_account">
                    <span class="form-check-label">
                    Create a client profile
                </span>
                </label>
            </div>
        </div>
        @endif
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-account-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let accountCode = '{{$account->account_code}}';
        let last = {{Str::of($account->lastSubsidiary->account_code ?? '0')->replace($account->account_code.'-','')->toString() * 1}};
        function updateAccountCode(){
            let stringLast = String(last + 1).padStart(4, '0');
            let newAccountCode = String(accountCode)+'-'+stringLast;
            $("#updating-account-code").val(newAccountCode);
        }

        $(document).ready(function (){
            updateAccountCode();
        })

        let active = '';
        accountsTbl = $("#accounts-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{Request::getUri()}}',
            columns : [
                { data : "account_code" },
                { data : "account_title" },
                { data : "account_address" },
                { data : "contact_person" },
                { data : "contact_no" },
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
                    targets : 5,
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
                url : '{{route("subsidiary-accounts.store",$account->account_code)}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.id;
                    accountsTbl.draw(false);
                    last = res.end;
                    succeed(form,true,true);
                    updateAccountCode();
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-account-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("subsidiary-accounts.edit","slug")}}';
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