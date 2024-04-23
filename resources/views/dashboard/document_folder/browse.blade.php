@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1><i class="fa fa-folder"></i> {{$document_folder->folder_code}} | {{$document_folder->description}}</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <iframe id="print_qr_iframe" src="" style="display: none">
        </iframe>
        <div class="box box-info">
            <div class="box-body">
                <div class="panel">
                    <div class="box box-sm box-default box-solid collapsed-box">
                        <div class="box-header with-border">
                            <p class="no-margin"><i class="fa fa-filter"></i> Advanced Filters <small id="filter-notifier" class="label bg-blue blink"></small></p>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool advanced_filters_toggler" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body" style="display: none">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Document Type:</label>
                                        <select name="type"  class="form-control dt_filter filters">
                                            <option value="">Don't filter</option>
                                            {!! \App\Swep\Helpers\Helper::populateOptionsFromArray(\App\Swep\Helpers\__static::document_types(true)) !!}
                                        </select>
                                    </div>
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>To:</label>
                                        <select name="person_to"  class="form-control dt_filter filter_sex filters select2_person_to_ajax">
                                            <option value="" selected>Don't Filter</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>From:</label>
                                        <select name="person_from"  class="form-control dt_filter filter_locations filters select2_person_from_ajax">
                                            <option value="" selected>Don't Filter</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Documents starting and after:</label>
                                        @php
                                            $document = \App\Models\Document::query()->orderBy('date','asc')->first();
                                            $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                                            if(!empty($document)){
                                                $date = \Illuminate\Support\Carbon::parse($document->date)->format('Y-m-d');
                                            }
                                        @endphp
                                        <input name="date_after" type="date" class="form-control filters dt_filter " min="{{$date}}" min-original="{{$date}}"  value="" autocomplete="off">

                                    </div>
                                    <div class="col-md-2 dt_filter-parent-div">
                                        <label>Documents until and before:</label>
                                        @php
                                            $document = \App\Models\Document::query()->orderBy('date','desc')->first();
                                            $date = \Illuminate\Support\Carbon::now()->format('Y-m-d');
                                            if(!empty($document)){
                                                $date = \Illuminate\Support\Carbon::parse($document->date)->format('Y-m-d');
                                            }
                                        @endphp
                                        <input name="date_before" type="date" class="form-control filters dt_filter " max="{{$date}}" max-original="{{$date}}" value=""  autocomplete="off">

                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <br>
                <div id="documents_table_container" style="display: none">
                    <table class="table table-bordered table-striped table-hover" id="documents_table" style="width: 100%">
                        <thead>
                        <tr class="">
                            <th >View</th>
                            <th class="th-20">Ref. No.</th>
                            <th class="th-20">Document Date</th>
                            <th >To</th>
                            <th >From</th>
                            <th >Subject</th>
                            <th class="action">Action</th>
                            <th >Document Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="tbl_loader">
                    <center>
                        <img style="width: 100px" src="{{asset('images/loader.gif')}}">
                    </center>
                </div>
            </div>
        </div>

    </section>


@endsection


@section('modals')
    <div class="modal fade" id="add_document_modal" tabindex="-1" role="dialog" aria-labelledby="add_document_modal_label">
        <div class="modal-dialog" role="document" style="width: 65%">
            <form id="add_document_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Upload new document</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('reference_no',
                                      [
                                          'label' => 'Reference no:',
                                          'cols' => 8,
                                      ]
                                    ) !!}
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('date',
                                      [
                                          'label' => 'Document Date:',
                                          'cols' => 4,
                                          'type' => 'date',
                                      ]
                                    ) !!}
                                </div>
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('person_to',
                                      [
                                          'label' => 'To:',
                                          'cols' => 6,
                                      ]
                                    ) !!}
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('person_from',
                                      [
                                          'label' => 'From:',
                                          'cols' => 6,
                                      ]
                                    ) !!}
                                </div>
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::select('type',
                                      [
                                          'label' => 'Document type:',
                                          'cols' => 6,
                                          'options' => \App\Swep\Helpers\__static::document_types(true),
                                      ]
                                    ) !!}
                                    {!! \App\Swep\ViewHelpers\__form2::select('qr_location',[
                                        'label' => 'QR Code location:',
                                        'cols' => 6,
                                        'options' => [
                                          'UPPER_RIGHT' => 'Upper right',
                                          'UPPER_LEFT' => 'Upper left',
                                          'LOWER_RIGHT' => 'Lower Right',
                                          'LOWER_LEFT' => 'Lower left',
                                          'LOWER_LEFT_PADDED' => 'Lower Middle',
                                        ],
                                        'class' => '',
                                    ],'UPPER_RIGHT') !!}
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('subject',
                                      [
                                          'label' => 'Subject:',
                                          'cols' => 12,
                                      ]
                                    ) !!}
                                </div>
                                <div class="row">
                                    @php
                                        $folderCodes = \App\Swep\Helpers\Helper::folderCodesArray();
                                    @endphp
                                    {!! \App\Swep\ViewHelpers\__form2::select('folder_code',[
                                        'label' => 'Folder Code:',
                                        'cols' => 6,
                                        'options' => $folderCodes,
                                        'class' => 'select2',
                                    ]) !!}

                                    {!! \App\Swep\ViewHelpers\__form2::select('folder_code2',[
                                        'label' => '2nd Folder Code (If Cross-File) :',
                                        'cols' => 6,
                                        'options' => $folderCodes,
                                        'class' => 'select2',
                                    ]) !!}
                                </div>
                                <div class="row">
                                    {!! \App\Swep\ViewHelpers\__form2::textbox('remarks',[
                                        'label' => 'Remarks:',
                                        'cols' => 12,
                                    ]) !!}

                                    {!! \App\Swep\ViewHelpers\__form2::textbox('outgoing_control_no',[
                                        'label' => 'Outgoing Control No.:',
                                        'cols' => 6,
                                        'id' => 'outgoing_control_no'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="file-loading">
                                            <input id="doc_file" name="doc_file" type="file" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {!! \App\Swep\ViewHelpers\__html::blank_modal('edit_document_modal',65) !!}
    {!! \App\Swep\ViewHelpers\__html::blank_modal('show_document_modal','') !!}
@endsection

@section('scripts')
    <script type="text/javascript">
        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        documents_tbl = $("#documents_table").on('xhr.dt', function (e, settings, json, xhr){
            if(xhr.status > 500){
                alert('Error '+xhr.status+': '+xhr.responseJSON.message);
            }
        }).DataTable({
            'dom' : 'lBfrtip',
            "processing": true,
            "serverSide": true,
            "ajax" : '{{route('dashboard.document_folder.browse',$document_folder->folder_code)}}',
            "columns": [
                { "data": "view_document" },
                { "data": "reference_no" },
                { "data": "date" },
                { "data": "person_to" },
                { "data": "person_from" },
                { "data": "subject" },
                { "data": "action"},
                { "data": "updated_at"},

            ],
            "buttons": [
                {!! __js::dt_buttons() !!}
            ],
            "columnDefs":[
                {
                    "targets" : 5,
                    "class" : 'w-40p'
                },
                {
                    "targets" : 6,
                    "orderable" : false,
                    "searchable": false,
                    "class" : 'action4'
                },
                {
                    'targets' : 0,
                    'orderable': false,
                    "class" : 'w-2p',
                },
                {
                    'targets' : 2,
                    'class' : 'w-10p',
                },
                {
                    'targets' : 7,
                    'visible' : false,
                },
                {
                    'targets' : [3,4],
                    'class' : 'w-10p',
                },
                {
                    responsivePriority : 10001,
                    targets: [2,3,4,6],
                }

            ],
            "order" : [['7', 'desc'],[2,'desc']],
            "responsive": true,
            "initComplete": function( settings, json ) {
                // console.log(settings);
                setTimeout(function () {
                    $("#filter_form select[name='is_active']").val('ACTIVE');
                    $("#filter_form select[name='is_active']").trigger('change');
                },100);

                setTimeout(function () {
                    // $('a[href="#advanced_filters"]').trigger('click');
                    // $('.advanced_filters_toggler').trigger('click');
                },1000);

                $('#tbl_loader').fadeOut(function(){
                    $("#documents_table_container").fadeIn(function () {
                        @if(request()->has('initiator') && request('initiator') == 'create')
                        introJs().start();
                        @endif
                    });
                    if(find != ''){
                        documents_tbl.search(find).draw();
                        setTimeout(function(){
                            active = '';
                        },3000);
                        // window.history.pushState({}, document.title, "/dashboard/employee");
                    }

                });
                @if(\Illuminate\Support\Facades\Request::get('toPage') != null && \Illuminate\Support\Facades\Request::get('mark') != null)
                setTimeout(function () {
                    documents_tbl.page({{\Illuminate\Support\Facades\Request::get('toPage')}}).draw('page');
                    active = '{{\Illuminate\Support\Facades\Request::get("mark")}}';
                    notify('Employee successfully updated.');
                    // window.history.pushState({}, document.title, "/dashboard/employee");
                },700);
                @endif
            },
            "language":
                {
                    "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
                },
            "drawCallback": function(settings){
                // console.log(documents_tbl.page.info().page);
                $("#documents_table a[for='linkToEdit']").each(function () {
                    let orig_uri = $(this).attr('href');
                    $(this).attr('href',orig_uri+'?page='+documents_tbl.page.info().page);
                });

                $('[data-toggle="tooltip"]').tooltip();
                $('[data-toggle="modal"]').tooltip();
                if(active != ''){
                    $("#documents_table #"+active).addClass('success');
                }
            }
        })

        style_datatable("#documents_table");

        //Need to press enter to search
        $('#documents_table_filter input').unbind();
        $('#documents_table_filter input').bind('keyup', function (e) {
            if (e.keyCode == 13) {
                documents_tbl.search(this.value).draw();
            }
        });

        $(document).ready(function() {
            $('.select2').select2({
                dropdownParent: $('#add_document_modal')
            });
            $(".select22").select2();

            $(".select2_person_to_ajax").select2({
                ajax: {
                    url: '{{route("dashboard.ajax.get","document_person_to")}}',
                    dataType: 'json',
                    delay : 250,
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
            });

            $(".select2_person_from_ajax").select2({
                ajax: {
                    url: '{{route("dashboard.ajax.get","document_person_from")}}',
                    dataType: 'json',
                    delay : 250,
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
            });

            $('#date_range').daterangepicker({
                locale: { cancelLabel: 'CLEAR Date Range' }
            });
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $('#date_range').val('');
                $("#date_range").trigger('change');
            });
            $('#date_range').attr('disabled','disabled');
            uploader = $("#doc_file").fileinput({
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
        });

        function mark_required_fileinput(file_input_id,response){
            if(typeof response.responseJSON !== "undefined"){
                if(typeof response.responseJSON.errors !== "undefined"){
                    if(typeof response.responseJSON.errors.doc_file !== "undefined")
                    {
                        let parent = $("#"+file_input_id).parent('div').parent('div').parent('div');
                        parent.find('.file-input').addClass('has-errors');
                        parent.find('.file-input').append('<br> <p class="text-danger">'+response.responseJSON.errors.doc_file[0]+'</p>');
                    }
                }
            }

        }
        function unmark_required_fileinput(file_input_id){
            let parenta = $("#"+file_input_id).parent('div').parent('div').parent('div');
            parenta.find('.file-input').removeClass('has-errors');
            parenta.find('.file-input').children('p').remove();
            parenta.find('.file-input').children('br').remove();
        }

        /*
        $("#add_document_form").submit(function (e) {

            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            unmark_required_fileinput('doc_file');
            loading_btn(form);
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
                    console.log(res);
                    succeed(form,true,false);
                    notify('Document was uploaded successfully');
                    active = res.slug;
                    setTimeout(function () {
                        documents_tbl.draw(false);
                    },500)
                    $(".select2").val(null).trigger("change");
                },
                error: function (res) {

                    mark_required_fileinput('doc_file',res);
                    errored(form,res);
                }
            })
        });
        */
        $("body").on("click",".edit_document_btn",function () {
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

        $("body").on("change",".dt_filter",function () {
            let form = $(this).parents('form');
            filterDT(documents_tbl);
        })

        $("input[name='date_after']").change(function () {
            let t = $(this);
            let before =  $("input[name='date_before']");
            if(t.val() != ''){
                before.attr('min',t.val());
            }else{
                before.removeAttr('min');
            }
        })

        $("input[name='date_before']").change(function () {
            let t = $(this);
            let after =  $("input[name='date_after']");
            if(t.val() != ''){
                after.attr('max',t.val());
            }else{
                before.removeAttr('max');
            }
        })

        $("body").on("click",'.view_document_btn',function () {
            let btn = $(this);
            let uri ='{{route("dashboard.document.show","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            load_modal2(btn);
            $.ajax({
                url : uri,
                data : '',
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(btn);
                }
            })
        })

        $("body").on("click",".print_qr_btn",function () {
            let btn = $(this);
            let uri = '{{route('dashboard.document.print_qr','slug')}}';
            uri = uri.replace('slug',btn.attr('data'));
            $("#print_qr_iframe").attr('src',uri);
            var swal = Swal.fire({
                title: 'Preparing QR Code',
                html: '<div style="height: 20px"><i class="fa fa-spinner fa-spin"></i> Please wait . . . </div>',
                // timer: 3000,
                // timerProgressBar: true,
            })
        })

        $("#print_qr_iframe").on('load',function () {
            $(this).get(0).contentWindow.print();
            swal.close();
        })

        $("body").on("click",".outgoing_tag_btn",function () {
            let btn = $(this);
            let uri = '{{route('dashboard.document.print_qr','slug')}}?print_as_tag=true';
            uri = uri.replace('slug',btn.attr('data'));
            $("#print_qr_iframe").attr('src',uri);
            var swal = Swal.fire({
                title: 'Preparing QR Code',
                html: '<div style="height: 20px"><i class="fa fa-spinner fa-spin"></i> Please wait . . . </div>',
                // timer: 3000,
                // timerProgressBar: true,
            })
        })

        $("#outgoing_control_no").click(function (){
            $.ajax({
                url : '{{route("dashboard.ajax.get","documents_outgoing_control_no")}}',
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    alert(res);
                },
                error: function (res) {
                    alert(res);
                }
            })
        });
    </script>
@endsection