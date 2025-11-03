@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Manage News</h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">News</h3>
            <div class="pull-right">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary btn-sm" data-target="#add_news_modal" data-toggle="modal"><i class="fa fa-edit"></i> Create</button>
                </div>
            </div>
        </div>

{{--        <div class="panel">--}}
{{--            <div class="box-header with-border">--}}
{{--                <h4 class="box-title">--}}
{{--                    <a data-toggle="collapse" data-parent="#accordion" href="#advanced_filters" aria-expanded="true" class="">--}}
{{--                        <i class="fa fa-filter"></i>  Advanced Filters <i class=" fa  fa-angle-down"></i>--}}
{{--                    </a>--}}
{{--                </h4>--}}
{{--            </div>--}}
{{--            <div id="advanced_filters" class="panel-collapse collapse" aria-expanded="true" style="">--}}
{{--                <div class="box-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-md-1 col-sm-2 col-lg-2">--}}
{{--                            <label>Status:</label>--}}
{{--                            <select name="status" aria-controls="scholars_table" class="form-control input-sm filter_status filters">--}}
{{--                                <option value="">All</option>--}}
{{--                                <option value="online">Online</option>--}}
{{--                                <option value="offline">Offline</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-1 col-sm-2 col-lg-2">--}}
{{--                            <label>Account Status:</label>--}}
{{--                            <select name="account" aria-controls="scholars_table" class="form-control input-sm filter_account filters">--}}
{{--                                <option value="">All</option>--}}
{{--                                <option value="active">Active</option>--}}
{{--                                <option value="inactive">Inactive</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}



        <div class="box-body">
            <div id="news_table_container" style="display: none">
                <table class="table table-bordered table-striped table-hover" id="news_table" style="width: 100% !important">
                    <thead>
                    <tr class="">
                        <th>Title</th>
                        <th>Details</th>
                        <th>Expiration</th>
                        <th>Attachments</th>
                        <th>Action</th>
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
    <div class="modal fade" id="add_news_modal" tabindex="-1" role="dialog" aria-labelledby="add_news_modalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form id="add_news_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="add_news_modalLabel">Create an announcement/news</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('title',[
                                'label' => 'Title:*',
                                'cols' => 9,
                            ]) !!}
                            {!! \App\Swep\ViewHelpers\__form2::textbox('expires_on',[
                                'label' => 'Expires on:*',
                                'type' => 'datetime-local',
                                'cols' => 3,
                            ]) !!}
                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textarea('details',[
                                'label' => 'Details:*',
                                'cols' => 12,
                                'id' => 'editor',
                            ]) !!}
                        </div>
                        <div class="row">
                            {!! \App\Swep\ViewHelpers\__form2::textbox('author',[
                                'label' => 'Author:*',
                                'cols' => 6,
                            ],
                            \Illuminate\Support\Facades\Auth::user()->employee->firstname.' '.\Illuminate\Support\Facades\Auth::user()->employee->lastname
                            ) !!}

                            {!! \App\Swep\ViewHelpers\__form2::textbox('author_position',[
                                'label' => 'Position:',
                                'cols' => 6,
                            ],
                            \Illuminate\Support\Facades\Auth::user()->employee->position) !!}
                        </div>
                        <div class="row">
                            {!! __form::file(
                                 '12', 'doc_file[]', 'Upload File:', $errors->has('doc_file'), $errors->first('doc_file'), ''
                              ) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            CKEDITOR.replace('editor',{
                customConfig: '',
                toolbarGroups: [
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align' ] },
                    { name: 'links', groups: [ 'links' ] },
                    { name: 'insert', groups: [ 'insert' ] },
                    { name: 'tools', groups: [ 'tools' ] }
                ]
            });
        });
    })

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




    //-----DATATABLES-----//
    modal_loader = $("#modal_loader").parent('div').html();
    //Initialize DataTable
    var active = '';
    news_tbl = $("#news_table").DataTable({
        "ajax" : '{{\Illuminate\Support\Facades\Request::url()}}',
        "columns": [
            { "data": "title" },
            { "data": "details" },
            { "data": "expires_on" },
            { "data": "attachments" },
            { "data": "action" }
        ],
        "order" : [[2,'desc']],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 0,
                "class" : 'w-12p'
            },
            {
                "targets" : 3,
                "class" : 'w-12p'
            },
            {
                "targets" : 2,
                "class" : 'w-14p'
            },
            {
                "targets" : 4,
                "orderable" : false,
                "class" : 'action2'
            },
        ],
        "responsive": false,
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "initComplete": function( settings, json ) {
            style_datatable("#"+settings.sTableId);
            $('#tbl_loader').fadeOut(function(){
                $("#"+settings.sTableId+"_container").fadeIn();
                if(find != ''){
                    news_tbl.search(find).draw();
                }
            });
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    news_tbl.search(this.value).draw();
                }
            });
        },

        "language":
            {
                "processing": "<center><img style='width: 70px' src='{{asset("images/loader.gif")}}'></center>",
            },
        "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(active != ''){
                $("#"+settings.sTableId+" #"+active).addClass('success');
            }
        }
    });

    $("#add_news_form").submit(function (e) {
        e.preventDefault();
        CKEDITOR.instances.editor.updateElement();
        let form = $(this);
        let formData = new FormData(this);
        loading_btn(form);
        $.ajax({
            url : '{{route("dashboard.news.store")}}',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,false);
                notify('Item was published successfully');
                CKEDITOR.instances.editor.setData('');
                active = res.slug;
                news_tbl.draw(false);
            },
            error: function (res) {
                errored(form,res)
            }
        })
    })

    // $("#doc_file").fileinput({
    //     theme: "fa",
    //     allowedFileExtensions: ["pdf", "jpeg", "jpg", "png"],
    //     maxFileCount: 3,
    //     showUpload: false,
    //     showCaption: false,
    //     overwriteInitial: true,
    //     fileType: "pdf",
    //     browseClass: "btn btn-primary btn-md",
    //     multiple :true,
    // });
    // $(".kv-file-remove").hide();
</script>

@endsection