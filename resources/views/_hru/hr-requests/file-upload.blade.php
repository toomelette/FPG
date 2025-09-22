@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'upload-file-form-'.$rand,
    'slug' => $hrRequest->slug,
])
@section('modal-header')
    Upload scanned file
@endsection

@section('modal-body')

    <div class="row">
        <div class="col-md-12 doc_file">
            <div class="file-loading ">
                <input id="doc-file" name="doc_file" type="file" multiple>
            </div>
        </div>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        let url1_{{$rand}} = {!! !empty($hrRequest->file_path) ? '"'.route("dashboard.hr_requests.file",$hrRequest->slug).'?view"' : 'false' !!};
        uploader = $("#doc-file").fileinput({
            // uploadUrl: "",
            enableResumableUpload: false,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            deleteExtraData: {

            },
            maxFileCount: 1,
            minFileCount: 0,
            initialPreviewAsData: true,
            overwriteInitial: true,
            theme: 'fa',
            deleteUrl: '{{route('dashboard.hr_requests.file',$hrRequest->slug)}}',
            browseOnZoneClick: true,
            showBrowse: true,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            showCancel: false,
            uploadAsync: false,
            initialPreview: url1_{{$rand}},
            initialPreviewConfig: [
                {
                    caption: "{{$hrRequest->filename}}",
                    downloadUrl: url1_{{$rand}},
                    type : 'pdf',
                    extra: {
                        _method: 'DELETE',
                        _token : $('meta[name="csrf-token"]').attr('content'),
                        key : '{{$hrRequest->slug}}',
                    }
                },
            ],
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

        }).on('fileerror',function(event,data,msg){

        });


        $("#upload-file-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form)
            $.ajax({
                url : '{{route("dashboard.hr_requests.file",$hrRequest->slug)}}',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Document was uploaded successfully.','success');
                    active = res.slug;
                    setTimeout(function () {
                        requestsTbl.draw(false);
                    },500)
                    $(".select2").val(null).trigger("change");
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        });
    </script>
@endsection