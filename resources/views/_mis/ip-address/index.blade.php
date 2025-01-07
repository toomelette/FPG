@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>IP Address</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-ip-address-modal"><i class="fa fa-plus"></i> Add IP Address</button>
        </x-slot:title>
        <div id="ip-address-table-container">
            <table class="table table-bordered table-striped table-sm" id="ip-address-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >IP Address</th>
                    <th >Location</th>
                    <th >User</th>
                    <th >Employee No.</th>
                    <th >Property No.</th>
                    <th style="width: 120px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-ip-address-modal"/>
    <x-adminkit.html.modal-template id="add-ip-address-modal" form-id="add-ip-address-form">
        <x-slot:title>Make Request</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="User" name="user" cols="8"/>
            <x-forms.input label="Employee No" name="employee_no" cols="4"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Property No" name="property_no" cols="6"/>
            <x-forms.select label="Location" name="location" cols="6 col-xs-6" :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::ipAddressLocations(),'option','value')"/>
        </div>
        IP ADDRESS:
        <div class="row mb-2">
            <x-forms.input label="1st Octet" name="octet_1" cols="3 col-sm-3 col-xs-3" type="number" :value="10"/>
            <x-forms.input label="2nd Octet" name="octet_2" cols="3 col-sm-3 col-xs-3" type="number" :value="36"/>
            <x-forms.input label="3rd Octet" name="octet_3" cols="3 col-sm-3 col-xs-3" type="number" />
            <x-forms.input label="4th Octet" name="octet_4" cols="3 col-sm-3 col-xs-3" type="number" />
        </div>

        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        ipAddressTbl = $("#ip-address-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.ip_address.index')}}',
            columns: [
                { data: "ip_address", "name": "ip_address" },
                { data: "location", "name": "location" },
                { data: "user", "name": "user" },
                { data: "employee_no", "name": "employee_no" },
                { data: "property_no", "name": "property_no" },
                { data: "action", "name": "action" },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top'
                },
                {
                    targets : 5,
                    orderable : false,
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
                        ipAddressTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-ip-address-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.ip_address.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    ipAddressTbl.draw(false);
                    succeed(form,true,true);
                    toast('success','Ip address successfully added.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-ip-address-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.ip_address.edit","slug")}}';
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