@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content',["form_id" => "edit_file201_form_".$rand, "slug" => $file201->slug])

@section('modal-header')
    {{$file201->title}}
@endsection

@section('modal-body')
    <input name="_method" value="PATCH" hidden>
    <input name="_changed" value="false" hidden readonly>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('title',[
            'cols' => 12,
            'label' => 'Title:'
        ],$file201) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('description',[
            'cols' => 12,
            'label' => 'Description:'
        ],$file201) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
            'cols' => 6,
            'label' => 'Date:',
            'type' => 'date',
        ],$file201) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::file('doc_file[]',[
            'label' => 'Upload File:',
            'cols' => 12,
            'id' => 'doc_file_'.$rand,
        ]) !!}
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">

        $("#edit_file201_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.file201.update", $file201->slug)}}',
                data : formData,
                type: 'POST',
                processData: false,
                contentType: false,
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form, true, true);
                    notify('201 File successfully updated.');
                    file201_active = res.slug;
                    file_201_tbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        var url1 = '{{route("dashboard.view_document.index",[$file201->slug,'view_201File'])}}';
        uploader = $("#doc_file_{{$rand}}").fileinput({
            // uploadUrl: "",
            enableResumableUpload: false,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            uploadExtraData: {

            },
            maxFileCount: 1,
            minFileCount: 0,
            showCancel: true,
            theme: 'fa',
            browseOnZoneClick: true,
            showBrowse: true,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            uploadAsync: false,
            initialPreview: [url1],
            overwriteInitial: true,
            initialPreviewAsData: true,
            initialPreviewConfig: [
                {
                    caption: "{{$file201->original_filename}}",
                    downloadUrl: url1,
                    type : '{{($file201->file_ext == "pdf")? "pdf" : "image"}}',
                },
            ],
        }).on('fileloaded', function(event, previewId, index, fileId) {
           $("#edit_file201_form_{{$rand}} input[name='_changed']").val('true');
        })
    </script>
@endsection

