@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>DMS Archived Documents</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1">
        <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3" state="0">
            <x-slot:title>
                <i class="fas fa fa-filter"></i> Advanced Filters
            </x-slot:title>
            <form id="filter_form">
                <div class="row mb-2">
                    @php
                        $document = App\Models\RECORDS\DMSDocuments::query()->orderBy('document_date','asc')->first();
                        $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        if(!empty($document)){
                            $date = \Illuminate\Support\Carbon::parse($document->document_date)->format('Y-m-d');
                        }
                    @endphp
                </div>
                <div class="row mb-2">
                    <x-forms.input label="Documents starting and after" cols="2" container-class="dt_filter-parent-div" name="date_after" class="dt_filter " type="date" min="{{$date}}" min-original="{{$date}}"/>

                    @php
                        $document = App\Models\RECORDS\DMSDocuments::query()->orderBy('document_date','desc')->first();
                        $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        if(!empty($document)){
                            $date = \Illuminate\Support\Carbon::parse($document->document_date)->format('Y-m-d');
                        }
                    @endphp
                    <x-forms.input label="Documents until and before" cols="2" container-class="dt_filter-parent-div" name="date_before" class="dt_filter " type="date" min="{{$date}}" min-original="{{$date}}"/>
                </div>
            </form>
        </x-adminkit.html.accordion>
        <div id="documents-table-container" class="table-responsive">
            <table class="table table-bordered table-striped table-sm" id="documents-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th style="width: 20px"></th>
                    <th style="width: 150px;">Date</th>
                    <th style="width: 100px;">Control No.</th>
                    <th style="width: 150px;">Title</th>
                    <th class="action">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <iframe id="print-qr-iframe" src="" style="display: none"></iframe>
    </x-adminkit.html.card>

@endsection
@section('modals')
    <x-adminkit.html.modal id="add-document-modal" size="70"/>
@endsection
@section('scripts')
    <script type="text/javascript">
        $("body").on("change",".dt_filter",function () {
            let form = $(this).parents('form');
            filterDT(documentsTbl);
        })
        let active = '';
        add_loader = $("#add_document_modal .modal-content").html();

        documentsTbl = $("#documents-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.dms_document.index')}}',
            columns: [
                { data : "view_file" },
                { data : "document_date" },
                { data : "document_control_no" },
                { data : "document_title" },
                { data : "action" },

            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets : '_all',
                    class : 'align-top',
                },
                {
                    targets : 0,
                    class : 'align-middle',
                },
                {
                    responsivePriority : 10001,
                    targets: [1,2,3],
                },
                {

                    targets: [0, 4],
                    searchable: false
                }

            ],
            order:[['1', 'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        documentsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $('.select2-folder-code').select2({
            dropdownParent: $('#add-document-modal')
        });


        $("body").on("click",".add-document-btn",function () {
            let btn = $(this);
            let uri = '{{route("dashboard.dms_document.add","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
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