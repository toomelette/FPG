@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Contract of Service</x-slot:title>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end"  data-bs-target="#add-cos-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="cos-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Contract Period</th>
                <th>Memo Code</th>
                <th>Funds Available</th>
                <th>Total COS Personnel</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-cos-modal" />
    <x-adminkit.html.modal-template id="add-cos-modal" form-id="add-cos-form">
        <x-slot:title>New Contract of Service</x-slot:title>

        <div class="row">
            <x-forms.input label="Date from" name="date_from" cols="6" type="date"/>
            <x-forms.input label="Date from" name="date_to" cols="6" type="date"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Memo date" name="memo_date" cols="6" type="date"/>
            <x-forms.input label="Memo Code" name="memo_code" cols="6"/>
        </div>

        <div class="row mt-2">
            <x-forms.input label="Funds Available" name="funds_available" cols="6"/>
            <x-forms.input label="Position" name="funds_available_position" cols="6"/>
        </div>

        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">

        let active = '';
        cosTbl = $("#cos-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "date_from" },
                { data : "memo_code" },
                { data : "funds_available" },
                { data : "total_cos" },
                { data : "is_active" },
                { data : "actions" },
            ],
            buttons : [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs :[
                {
                    targets : '_all',
                    class : 'align-top',
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
                        cosTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("#add-cos-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.cos.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Contract of Service successfully created.','Success');
                    active = res.slug;
                    cosTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-cos-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.cos.edit","slug")}}';
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

        $("body").on("change",".is-active-btn",function (){
            let t = $(this);
            let checked = t.prop('checked');
            let data = t.attr('data');
            let uri = '{{route("dashboard.cos.update","slug")}}?activeInactive';
            uri = uri.replace('slug',data);
            $.ajax({
                url : uri,
                data : {
                    slug : data,
                    checked : checked,
                },
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('info','Status successfully updated.','Success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection