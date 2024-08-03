@extends('adminkit.master')


@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Plantilla</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <table class="table table-bordered table-striped table-hover table-sm" id="plantilla-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th class="th-20">Item No.</th>
                <th >Position</th>
                <th >Original JG-SI</th>
                <th >Incumbent Employee</th>
                <th class="" style="width: 50px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal id="edit-plantilla-modal" />
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        plantillaTbl = $("#plantilla-table").DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.plantilla.index')}}',
            "columns": [
                { "data": "item_no" },
                { "data": "position" },
                { "data": "orig_jg_si" },
                { "data": "incumbent" },
                { "data": "action" }
            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : '_all',
                    "class" : 'align-top',
                },
                {
                    "targets" : [0,2],
                    "class" : 'w-8p text-center',
                },
                {
                    "targets" : 1,
                    "class" : 'w-40p',
                },

            ],
            "order":[[0,'asc']],
            "responsive": false,
            "initComplete": function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        plantillaTbl.search(this.value).draw();
                    }
                });
            },
            "drawCallback": function(settings){
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $("body").on("click",".edit-plantilla-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            $.ajax({
                url : btn.attr('uri'),
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn, res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })
    </script>
@endsection