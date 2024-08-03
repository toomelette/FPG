@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Holidays</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1">
        <x-slot:title>
            <div class="btn-group float-end">
                <button id="fetch-google-btn" type="button" class="btn btn-outline-secondary btn-sm"><i class="fa fa-refresh"></i> Sync with Google Calendar</button>
                <button type="button" class="btn btn-sm btn-primary" data-bs-target="#add-holiday-modal" data-bs-toggle="modal"><i class="fa fa-plus"></i> Add holiday</button>
            </div>
        </x-slot:title>
        <div id="holidays-table_container">
            <table class="table table-bordered table-striped table-sm" id="holidays-table" style="width: 100% !important">
                <thead>
                <tr class="">
                    <th class="th-20">Year</th>
                    <th >Name</th>
                    <th class="th-10">Date</th>
                    <th class="th-10">Type</th>
                    <th style="width: 60px;">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-holiday-modal" size="sm" form-id="add-holiday-form">
        <x-slot:title>Add Holiday</x-slot:title>

        <div class="row mb-2">
            <x-forms.input label="Date" name="date" cols="12" type="date"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Name" name="name" cols="12"/>
        </div>
        <div class="row mb-2">
            <x-forms.select label="Type" name="type" cols="12" :options="\App\Swep\Helpers\Helper::holiday_types()"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-holiday-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        holidaysTbl = $("#holidays-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.holidays.index')}}?year={{\Carbon\Carbon::now()->format("Y")}}',
            columns: [
                { data : "year" },
                { data : "name" },
                { data : "date" },
                { data : "type" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    "targets" : '_all',
                    "class" : 'align-top'
                },
                {
                    "targets" : 0,
                    "orderable" : false,
                    "class" : 'w-10p'
                }
            ],
            order:[[2,'asc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        holidaysTbl.search(this.value).draw();
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
        $("#add-holiday-form").submit(function (e) {
            e.preventDefault();
            form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.holidays.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    active = res.slug;
                    holidaysTbl.draw(false);
                    toast('success','Holiday successfully added.','Succes!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-holiday-btn",function () {
            btn = $(this);
            slug = btn.attr('data');
            load_modal2(btn);
            url = '{{route("dashboard.holidays.edit","slug")}}';
            url = url.replace("slug",slug);
            $.ajax({
                url : url,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn, res);
                },
                error: function (res) {
                    populate_modal2_error(res)
                }
            })
        })
        $("#fetch-google-btn").click(function () {
            btn = $(this);
            //btn.children('i').addClass('fa-spin');
            wait_this_button(btn,'Sync with Google Calendar');
            $.ajax({
                url : '{{route("dashboard.holidays.fetch_google")}}',
                // data : ,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    unwait_this_button(btn)
                    Swal.fire(
                        'Sync Finished!',
                        'Holidays are updated',
                        'success'
                    );
                    holidays_tbl.draw(false);
                    // console.log(res);
                },
                error: function (res) {
                    unwait_this_button(btn);
                }
            })
        })
    </script>
@endsection