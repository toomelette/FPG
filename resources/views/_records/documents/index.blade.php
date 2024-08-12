@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Documents</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1">
        <x-slot:title>
            <button type="button" class="btn btn-sm btn-primary float-end" data-intro="Click here." data-bs-toggle="modal" data-bs-target="#add-document-modal"><i class="fa fa-plus"></i> Add document</button>
        </x-slot:title>

        <x-adminkit.html.accordion id="filter-accordion" class="accordion-sm mb-3" state="0">
            <x-slot:title>
                <i class="fas fa fa-filter"></i> Advanced Filters
            </x-slot:title>
            <form id="filter_form">
                <div class="row mb-2">
                    <x-forms.select label="Type" cols="2" container-class="dt_filter-parent-div" name="type" class="dt_filter filters" :options="\App\Swep\Helpers\__static::document_types(true)"/>
                    <x-forms.select label="To" cols="2" container-class="dt_filter-parent-div" name="person_to" class="dt_filter select2-person-to-ajax"/>
                    <x-forms.select label="From" cols="2" container-class="dt_filter-parent-div" name="person_from" class="dt_filter  select2-person-from-ajax"/>
                    <x-forms.select label="Folder Code" cols="6" container-class="dt_filter-parent-div" name="folder_code" class="dt_filter select2-parent-card" :options="\App\Swep\Helpers\Arrays::folderCodes()"/>
                    @php
                        $document = \App\Models\Document::query()->orderBy('date','asc')->first();
                        $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                        if(!empty($document)){
                            $date = \Illuminate\Support\Carbon::parse($document->date)->format('Y-m-d');
                        }
                    @endphp
                </div>
                <div class="row mb-2">
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
        <div id="documents-table-container" >
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
    <x-adminkit.html.modal-template id="add-document-modal" size="70" form-id="add-document-form">
        <x-slot:title>Add document</x-slot:title>
        <div class="row mb-2">
            <div class="col-8">
                <div class="row mb-2">
                    <x-forms.input label="Reference no" name="reference_no" cols="8"/>
                    <x-forms.input label="Document Date" name="date" cols="4" type="date"/>
                </div>
                <div class="row mb-2">
                    <x-forms.input label="To" name="person_to" cols="6"/>
                    <x-forms.input label="From" name="person_from" cols="6"/>
                </div>
                <div class="row mb-2">
                    <x-forms.select label="Document type" name="type" cols="6" :options="\App\Swep\Helpers\__static::document_types(true)"/>
                    <x-forms.select label="QR Code location" name="qr_location" cols="6" :options="[
                          'UPPER_RIGHT' => 'Upper right',
                          'UPPER_LEFT' => 'Upper left',
                          'LOWER_RIGHT' => 'Lower Right',
                          'LOWER_LEFT' => 'Lower left',
                          'LOWER_LEFT_PADDED' => 'Lower Middle',
                        ]" value="UPPER_RIGHT"/>
                </div>
                <div class="row mb-2">
                    <x-forms.input label="Subject" name="subject" cols="12"/>
                </div>

                @php
                    $folderCodes = \App\Swep\Helpers\Helper::folderCodesArray();
                @endphp

                <div class="row mb-2">
                    <x-forms.select label="Folder Code" name="folder_code" class="select2-folder-code" cols="6" :options="$folderCodes"/>
                    <x-forms.select label="2nd Folder Code (If Cross-File)" name="folder_code2" class="select2-folder-code" cols="6" :options="$folderCodes"/>
                </div>
                <div class="row mb-2">
                    <x-forms.input label="Remarks" name="remarks" cols="12"/>
                </div>
                <div class="row mb-2">
                    <x-forms.input label="Outgoing Control No" name="outgoing_control_no" cols="6" id="outgoing_control_no"/>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="file-loading">
                            <input id="doc-file" name="doc_file" type="file" multiple>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-document-modal" size="70"/>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
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
            ajax : '{{route('dashboard.document.index')}}',
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
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $('.select2-folder-code').select2({
            dropdownParent: $('#add-document-modal')
        });

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


        $("#add-document-form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form)
            $.ajax({
                url : '{{route("dashboard.document.store")}}',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    toast('success','Document was uploaded successfully.','success');
                    active = res.slug;
                    setTimeout(function () {
                        documentsTbl.draw(false);
                    },500)
                    $(".select2").val(null).trigger("change");
                },
                error: function (res) {
                    errored(form,res);
                }
            })
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



        uploader = $("#doc-file").fileinput({
            // uploadUrl: "",
            enableResumableUpload: false,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            uploadExtraData: {

            },
            maxFileCount: 5,
            minFileCount: 0,
            showCancel: true,
            initialPreviewAsData: true,
            overwriteInitial: false,
            theme: 'fa',
            deleteUrl: "http://localhost/file-delete.php",
            browseOnZoneClick: true,
            showBrowse: true,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            showCancel: false,
            uploadAsync: false
        }).on('fileloaded', function(event, previewId, index, fileId) {
            $(".kv-file-upload").each(function () {
                $(this).remove();
            })
        }).on('fileuploaderror', function(event, data, msg) {
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
            console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
        }).on('filebatchuploaderror', function(event, data, msg) {
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
            console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
        }).on('filebatchuploadsuccess', function(event, data) {
            console.log(data.response);
            var id = data.response.transaction_id;
            if(data.response.transaction_code == "PRE" || data.response.transaction_types_group == "LAB"){
                form = $("#premixProductForm");
                formData = form.serialize();
                $.ajax({
                    url : "",
                    data: formData,
                    type: 'POST',
                    success: function (res) {
                        alert(11123);
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            }
            else {
                alert('esle');
            }
            $("#transaction_id").html(data.response.transaction_id);
            $("#amountToPay").html("Amount to Pay: Php "+ data.response.amount);
            $("#timestamp").html(data.response.timestamp);
            var printRoute = "";
            var newPrintRoute = printRoute + "?transactionId=" + data.response.transaction_id;

            $("#printIframe").attr('src', newPrintRoute)

            setTimeout(function(){
                $("#done").slideDown();
                $("#content").slideUp();
            },500);
            //window.open("http://localhost:8001/dashboard/landBank/"+id, '_blank').focus();
            //data.response is the object containing the values
        }).on('fileerror',function(event,data,msg){
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
        });


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