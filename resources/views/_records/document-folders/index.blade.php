@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Document Folders</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card>
        <x-slot:title>
            <button type="button" class="btn btn-sm btn-primary float-end" data-intro="Click here." data-bs-toggle="modal" data-bs-target="#add-folder-modal"><i class="fa fa-plus"></i> Create folder</button>
        </x-slot:title>

        <div id="folders-table-container" style="">
            <table class="table table-bordered table-striped table-sm" id="folders-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th >Folder Code</th>
                    <th >Folder Name</th>
                    <th >Retention Period</th>
                    <th >Documents</th>
                    <th class="action">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </x-adminkit.html.card>

@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-folder-modal" size="sm" form-id="add-folder-form">
        <x-slot:title>
            Create folder
        </x-slot:title>
        <div class="row mb-2">
            <x-forms.input name="folder_code" cols="12" label="Folder Code" />
        </div>

        <div class="row mb-2">
            <x-forms.input name="description" cols="12" label="Description" />
        </div>
        <div class="row mb-2">
            <x-forms.select name="retention_period" cols="12" label="Retention Period" :options="\App\Swep\Helpers\Arrays::retentionPeriods()"/>
        </div>
        <div class="row mb-2">
            <x-forms.checkbox name="is_permanent" cols="12" label="Temporary/Permanent" type="radio" class="temp_perm" each-class="6" :options="[
                    '0' => 'Temporary',
                    '1' => 'Permanent',
                ]"
            />
        </div>
        <div class="row mb-2">
            <x-forms.input name="remarks" cols="12" label="Remarks" />
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-folder-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        foldersTbl = $("#folders-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.document_folder.index')}}',
            columns: [
                { data : "folder_code" },
                { data : "description" },
                { data : "retention_period" },
                { data : "documents" },
                { data : "action"}
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
                    targets : [3,4],
                    orderable : false,
                    searchable: false,
                },
                {
                    targets : 3,
                    class : 'text-center',
                },

            ],
            order:[[0,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        foldersTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-folder-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.document_folder.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    foldersTbl.draw(false);
                    toast('success','Document folder successfully created.','Success!');
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-folder-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.document_folder.edit","slug")}}';
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