@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title><i class="fa fa-folder-open"></i> | {{$folder->folder_code}}</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end"  data-bs-target="#add-folder-modal" data-bs-toggle="modal"><i class="fa fa-folder-plus"></i> New Folder</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="folders-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Folder Code</th>
                <th>Description</th>
                <th>Branch</th>
                <th>Details</th>
                <th>Created at</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-folder-modal" size="sm" form-id="add-folder-form">
        <x-slot:title>New Folder</x-slot:title>
        <input name="parent_folder_uuid" value="{{$folder->uuid}}" hidden="" readonly/>
        <div class="row">
            <x-forms.input label="Folder Code" name="folder_code" cols="12"/>
        </div>

        <div class="row mt-2">
            <x-forms.input label="Description" name="description" cols="12"/>
        </div>

        <div class="row mt-2">
            <x-forms.select label="Branch" name="project_id" cols="12" :options="\App\Swep\Helpers\Arrays::projectIds()"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-folder-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        foldersTbl = $("#folders-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "folder_code" },
                { data : "description" },
                { data : "project_id" },
                { data : "details" },
                { data : "created_at"},
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
                    targets: 4,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MMM. DD, YYYY | hh:mm A');
                    }
                }
            ],
            order:[[0,'asc']],
            responsive : false,
            initComplete : function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        foldersTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
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
                url : '{{route("costing-folder.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.uuid;
                    foldersTbl.draw(false);
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
            let uri = '{{route("costing-folder.edit","slug")}}';
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