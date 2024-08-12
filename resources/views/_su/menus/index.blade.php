@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Menus</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title>
            <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-menu-modal"><i class="fa fa-plus"></i> Add</button>
        </x-slot:title>

        <div class="menus-table-container">
            <table class="table table-bordered table-sm" id="menus-table">
                <thead>
                <tr>
                    <th >Name</th>
                    <th>Route</th>
                    <th style="width: 40%;">Submenus</th>
                    <th>Category</th>
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
    <x-adminkit.html.modal-template id="add-menu-modal" form-id="add-menu-form">
        <x-slot:title>Add menu</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Name" name="name" cols="6"/>
            <x-forms.input label="Route" name="route" cols="6"/>

        </div>
        <div class="row mb-2">
            <x-forms.input label="Category" name="category" cols="6"/>
            <x-forms.checkbox name="is_menu" cols="3" label="Is Menu" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
            />
            <x-forms.checkbox name="is_dropdown" cols="3" label="Is Dropdown" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
            />
        </div>
        <div class="row mb-3">
            <x-forms.select label="Portal" name="portal" cols="4" :options="\App\Swep\Helpers\Arrays::portals()"/>
        </div>
        <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
            Auto include known submenus
        </x-adminkit.html.alert>
        <x-forms.checkbox name="submenus" cols="12" label="Submenus" type="checkbox"  each-class="3" :options="\App\Swep\Helpers\Arrays::knownSubmenus()"
        />
        <x-slot:footer>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-menu-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        menusTbl = $("#menus-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.menu.index')}}',
            columns: [
                { data : "name" },
                { data : "route" },
                { data : "submenus" },
                { data : "category" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[

            ],
            order:[[0,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        menusTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-menu-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.menu.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    // active = res.slug;
                    // menusTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-menu-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.menu.edit","slug")}}';
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