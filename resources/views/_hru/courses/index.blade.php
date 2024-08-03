@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Courses</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title class="pb-1 pt-3">
            <button type="button" class="btn btn-primary btn-sm float-end" data-intro="Click here." data-bs-target="#add-course-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> Add course</button>
        </x-slot:title>
        <div class="courses-table-container">
            <table class="table table-bordered table-sm" id="courses-table">
                <thead>
                <tr>
                    <th style="width: 10%;">Acronym</th>
                    <th>Name</th>
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
    <x-adminkit.html.modal-template id="add-course-modal" form-id="add-course-form" size="sm">
        <x-slot:title>Add Course</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Acronym" name="acronym" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Name" name="name" cols="12"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-course-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        coursesTbl = $("#courses-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.course.index')}}',
            columns: [
                { data : "acronym" },
                { data : "name" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[

            ],
            order:[[0,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        coursesTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#add-course-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.course.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    coursesTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-course-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.course.edit","slug")}}';
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