@php
    /** @var \App\Models\DocumentFolder $documentFolder  **/
@endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>
            <i class="fa fa-folder"></i>
            <strong>{{$documentFolder->folder_code}}</strong>
        </x-slot:title>
        <x-slot:subtitle>{{$documentFolder->description}}</x-slot:subtitle>
        <x-slot:float-end>Document Folder</x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3" state="0">
            <x-slot:title>
                <i class="fas fa fa-filter"></i> Advanced Filters
            </x-slot:title>
            <form id="filter_form">
                <div class="row mb-2">
                    <x-forms.select label="Type" cols="2" container-class="dt_filter-parent-div" name="type" class="dt_filter filters" :options="\App\Swep\Helpers\__static::document_types(true)"/>
                    <x-forms.select label="To" cols="2" container-class="dt_filter-parent-div" name="person_to" class="dt_filter select2-person-to-ajax"/>
                    <x-forms.select label="From" cols="2" container-class="dt_filter-parent-div" name="person_from" class="dt_filter  select2-person-from-ajax"/>
                    @php
                        $document = \App\Models\Document::query()->orderBy('date','asc')->first();
                        $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        if(!empty($document)){
                            $date = \Illuminate\Support\Carbon::parse($document->date)->format('Y-m-d');
                        }
                    @endphp
                    <x-forms.input label="Documents starting and after" cols="2" container-class="dt_filter-parent-div" name="date_after" class="dt_filter " type="date" min="{{$date}}" min-original="{{$date}}"/>

                    @php
                        $document = \App\Models\Document::query()->orderBy('date','desc')->first();
                        $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        if(!empty($document)){
                            $date = \Illuminate\Support\Carbon::parse($document->date)->format('Y-m-d');
                        }
                    @endphp
                    <x-forms.input label="Documents until and before" cols="2" container-class="dt_filter-parent-div" name="date_before" class="dt_filter " type="date" min="{{$date}}" min-original="{{$date}}"/>
                </div>
            </form>
        </x-adminkit.html.accordion>


        <div id="documents-table-container">
            <table class="table table-bordered table-striped table-sm" id="documents-table" style="width: 100%">
                <thead>
                <tr class="">
                    <th style="width: 20px"></th>
                    <th style="width: 20%">Ref. No.</th>
                    <th style="width: 100px">Date</th>
                    <th style="width: 15%">To</th>
                    <th style="width: 15%">From</th>
                    <th >Subject</th>
                    <th class="action">Action</th>
                    <th >Document Date</th>
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
    <x-adminkit.html.modal id="edit-document-modal" size="70"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("body").on("change",".dt_filter",function () {
            let form = $(this).parents('form');
            filterDT(documentsTbl);
        })

        let active = '';
        documentsTbl = $("#documents-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.document_folder.browse',$documentFolder->folder_code)}}',
            columns: [
                { data : "view_document" },
                { data : "reference_no" },
                { data : "date" },
                { data : "person_to" },
                { data : "person_from" },
                { data : "subject" },
                { data : "action"},
                { data : "updated_at"},
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
                    targets : 6,
                    orderable : false,
                    searchable: false,
                },
                {
                    targets :2,
                    class: 'text-center',
                },
                {
                    targets : 0,
                    class : 'align-middle',
                },
                {
                    targets : 7,
                    visible : false,
                },
                {
                    responsivePriority : 10001,
                    targets: [2,3,4,6],
                }
            ],
            order:[['7', 'desc'],[2,'desc']],
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
                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })

        $(".select2-person-to-ajax").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","document_person_to")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });

        $(".select2-person-from-ajax").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","document_person_from")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });

        $("body").on("click",".edit-document-btn",function () {
            let btn = $(this);
            let uri = '{{route("dashboard.document.edit","slug")}}';
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

        $("body").on("click",".print-qr-btn",function () {
            let btn = $(this);
            let uri = '{{route('dashboard.document.print_qr','slug')}}';
            uri = uri.replace('slug',btn.attr('data'));
            $("#print-qr-iframe").attr('src',uri);
            var swal = Swal.fire({
                title: 'Preparing QR Code',
                html: '<div style="height: 20px"><i class="fa fa-spinner fa-spin"></i> Please wait . . . </div>',
                // timer: 3000,
                // timerProgressBar: true,
            })
        })

        $("#print-qr-iframe").on('load',function () {
            $(this).get(0).contentWindow.print();
            swal.close();
        })

    </script>
@endsection