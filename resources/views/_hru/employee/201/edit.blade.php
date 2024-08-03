@php
    $rand = Str::random();
    /** @var \App\Models\EmployeeFile201 $file **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-file-form-'.$rand,
    'slug' => $file->slug,
])

@section('modal-header')
    {{$file->title}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Title" name="title" cols="12" :value="$file ?? null"/>
        <x-forms.input label="Description" name="description" cols="12" :value="$file ?? null"/>
        <x-forms.input label="Date" name="date" cols="6" type="date" :value="$file ?? null"/>
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
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-file-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.employee.201", $file->slug)}}',
                data : formData,
                type: 'PUT',
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
        var url1 = '{{route("dashboard.view_document.index",[$file->slug,'view_201File'])}}';
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
                    caption: "{{$file->original_filename}}",
                    downloadUrl: url1,
                    type : '{{($file->file_ext == "pdf")? "pdf" : "image"}}',
                },
            ],
        }).on('fileloaded', function(event, previewId, index, fileId) {
            $("#edit_file201_form_{{$rand}} input[name='_changed']").val('true');
        })
    </script>
@endsection