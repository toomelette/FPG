@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Submenus</x-slot:title>
        <x-slot:float-end>{{$menu->name}}</x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title class="pb-0">
            <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-submenu-modal"><i class="fa fa-plus"></i> Add submenu</button>
        </x-slot:title>
        <div class="submenus-table-container">
            <table class="table table-bordered table-sm" id="submenus-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Nav Name</th>
                    <th>Route</th>
                    <th style="width: 80px">Is Nav</th>
                    <th style="width: 80px">Public</th>
                    <th style="width: 80px">Users</th>
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
    <x-adminkit.html.modal-template id="add-submenu-modal" size="sm" form-id="add-submenu-form">
        <x-slot:title>Add Submenu</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Name" name="name" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Nav Name" name="nav_name" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Route" name="route" cols="12"/>
        </div>
        <x-forms.checkbox name="is_nav" cols="12" label="Is Nav" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
        />
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-submenu-modal" size="sm"/>
    <x-adminkit.html.modal id="show-users-modal"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        submenusTbl = $("#submenus-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.submenu.index',$menu->slug)}}',
            columns: [
                { data : "name" },
                { data : "nav_name" },
                { data : "route" },
                { data : "is_nav" },
                { data : "public" },
                { data : "users_with_access_count" },
                { data : "action" },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : [3,4],
                    class: 'text-center text-strong',
                },
                {
                    targets : [5],
                    class: 'text-center text-strong',
                    searchable: false,
                }
            ],
            order:[[3,'desc'],[0,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        submenusTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-submenu-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.submenu.store",$menu->slug)}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    submenusTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-submenu-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.submenu.edit","slug")}}';
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
        $("body").on("click",".show-users-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.submenu.show","slug")}}';
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