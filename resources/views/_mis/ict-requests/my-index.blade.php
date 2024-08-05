@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>My Requests</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-request-modal"><i class="fa fa-plus"></i> Make request</button>
        </x-slot:title>
        <div id="requests_table_container" >
            <table class="table table-bordered table-striped table-sm" id="requests-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >Request No.</th>
                    <th >Nature of Request</th>
                    <th >Request Details</th>
                    <th style="width: 15%;">Created at</th>
                    <th >Status</th>
                    <th style="width: 150px;">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="status-modal"/>
    <x-adminkit.html.modal-template id="add-request-modal" form-id="add-request-form">
        <x-slot:title>Make Request</x-slot:title>
        <div class="row mb-2">
            <x-forms.select label="Department" name="department" cols="12" :options="\App\Swep\Helpers\Arrays::departmentList()"/>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Nature of Request" name="nature_of_request" cols="12" :options="\App\Swep\Helpers\Helper::mis_request_nature()"/>
        </div>

        <div class="row mb-2">
            <x-forms.textarea label="Details" name="details" cols="12" rows="3"/>
        </div>

        <div class="row mb-2">
            <x-forms.input label="Email address" name="email" cols="6"/>
            <x-forms.input label="Contact No" name="phone" cols="6"/>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        myRequestsTbl = $("#requests-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.mis_requests.my_requests')}}',
            columns: [
                { data: "request_no" },
                { data: "nature_of_request" },
                { data: "request_details" },
                { data: "created_at" },
                { data: "status" },
                { data: "action" },
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
                    targets : 0,
                    class : 'w-6p'
                },
                {
                    targets : 5,
                    orderable : false,
                },
            ],
            order:[[3,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        myRequestsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })


        $("body").on("click",".status-btn",function () {
            btn = $(this);
            let uri = '{{route("dashboard.mis_requests_status.index_open")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
            $.ajax({
                url : uri,
                data :{slug:btn.attr('data')},
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                    notify('Ajax error.','danger');
                }
            })
        })

        $("#add-request-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.mis_requests.store")}}',
                data :  form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Service request has been created.','Success');
                    Swal.fire({
                        title: "Success!",
                        text: "Request created successfully.",
                        icon: "success"
                    });

                    active = res.slug;
                    myRequestsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                    console.log(res);
                }
            })
        })
    </script>
@endsection