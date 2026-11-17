@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title><i class="fa fa-folder-open"></i> | {{$folder->folder_code}}</x-slot:title>
        <x-slot:subtitle>{{$folder->description}}</x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end"  data-bs-target="#add-costing-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New Costing/Upload</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="costings-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Description</th>
                <th>Excel File</th>
                <th>Latest Logs (5)</th>
                <th>Created at</th>
                <th style="width: 120px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>

@endsection


@section('modals')
<x-adminkit.html.modal-template id="add-costing-modal" size="sm" form-id="add-costing-form">
    <x-slot:title>New</x-slot:title>
    <input readonly hidden="" value="{{$folder->uuid}}" name="folder_uuid"/>
    <div class="row">
        <x-forms.input label="Excel file" name="excel" cols="12" type="file"/>
    </div>

    <div class="row mt-2">
        <x-forms.input label="Description" name="description" cols="12"/>
    </div>
    <x-slot:footer>
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
    </x-slot:footer>
</x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        costingsTbl = $("#costings-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "description" },
                { data : "original_filename" },
                { data : "details" },
                { data : "created_at" },
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
                    targets: 3,
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
                        costingsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-costing-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("costing.store")}}',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.uuid;
                    costingsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

    </script>
@endsection