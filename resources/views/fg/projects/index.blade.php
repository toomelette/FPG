@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Projects</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <x-slot:title>
            <button class="btn btn-sm btn-primary float-end"  data-bs-target="#add-client-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> New</button>
        </x-slot:title>

        <table class="table table-bordered table-striped table-hover table-sm" id="projects-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Project</th>
                <th>Project ID</th>
                <th>Client</th>
                <th>Date Started</th>
                <th>Delivery Date</th>
                <th>Amount</th>
                <th style="width: 80px;">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-client-modal" form-id="add-project-form">
        <x-slot:title>Add New Client</x-slot:title>
        <div class="row">
            <x-forms.select label="Client" name="client_uuid" id="select2-clients" cols="12" :options="[]"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Project" name="project_name" cols="8"/>
            <x-forms.input label="Project Code" name="project_code" cols="4"/>
        </div>

        <div class="row mt-2">
            <x-forms.input label="Delivery Address" name="delivery_address" cols="8"/>
            <x-forms.input label="Delivery Date" name="delivery_date" cols="4" type="date"/>
        </div>
        <div class="row mt-2">
            <x-forms.input label="Date Started" name="date_started" cols="4" type="date"/>
        </div>
        <div class="row mt-2">
            <x-forms.textarea label="Details" name="details" cols="12"/>
        </div>

        <div class="row mt-2">
            <x-forms.input label="Project Amount" name="project_amount" class="autonum"  cols="6"/>
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-project-modal" size=""/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        projectsTbl = $("#projects-table").DataTable({
            dom : 'lBfrtip',
            processing : true,
            serverSide : true,
            ajax : '{{\Illuminate\Support\Facades\Request::getUri()}}',
            columns : [
                { data : "project_name" },
                { data : "project_code" },
                {
                    data : "client.name" ,
                    name : "client.name",
                },
                {
                    data : "date_started" ,
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MMM DD, YYYY');
                    }
                },
                {
                    data : "delivery_date",
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return moment(data).format('MMM DD, YYYY');
                    }
                },
                {
                    data : "project_amount",
                    render: function (data) {
                        if(!data){
                            return  '';
                        }
                        return $.number(data,2);
                    }
                },
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
                    targets: 5,
                    class : 'text-end'
                },
                {
                    targets : 6,
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
                        projectsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback : function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        
        $("#select2-clients").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","clients")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $("#select2-clients").closest('.modal'),
        });

        $("#add-project-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("projects.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Project successfully create.','Success');
                    active = res.uuid;
                    projectsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#add-client-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("projects.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Client successfully added.','Success');
                    active = res.uuid;
                    projectsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".edit-client-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("projects.edit","slug")}}';
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

        $("body").on("click",".edit-project-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("projects.edit","slug")}}';
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