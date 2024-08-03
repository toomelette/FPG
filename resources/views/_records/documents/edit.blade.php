@php
    $rand = Str::random();
    /** @var \App\Models\Document $document  **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-document-form-'.$rand,
    'slug' => $document->slug,
])

@section('modal-header')
    {{$document->reference_no}} - {{Str::limit($document->subject,50)}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <div class="col-8">
            <div class="row mb-2">
                <x-forms.input label="Reference no" name="reference_no" cols="8" :value="$document ?? null"/>
                <x-forms.input label="Document Date" name="date" cols="4" type="date" :value="$document ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.input label="To" name="person_to" cols="6" :value="$document ?? null"/>
                <x-forms.input label="From" name="person_from" cols="6" :value="$document ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.select label="Document type" name="type" cols="6" :options="\App\Swep\Helpers\__static::document_types(true)" :value="$document ?? null"/>
                <x-forms.select label="QR Code location" name="qr_location" cols="6" :options="[
                          'UPPER_RIGHT' => 'Upper right',
                          'UPPER_LEFT' => 'Upper left',
                          'LOWER_RIGHT' => 'Lower Right',
                          'LOWER_LEFT' => 'Lower left',
                          'LOWER_LEFT_PADDED' => 'Lower Middle',
                        ]" value="UPPER_RIGHT" :value="$document ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.input label="Subject" name="subject" cols="12" :value="$document ?? null"/>
            </div>

            @php
                $folderCodes = \App\Swep\Helpers\Helper::folderCodesArray();
            @endphp

            <div class="row mb-2">
                <x-forms.select label="Folder Code" name="folder_code" class="select2-folder-code-{{$rand}}" cols="6" :options="$folderCodes" :value="$document ?? null"/>
                <x-forms.select label="2nd Folder Code (If Cross-File)" name="folder_code2" class="select2-folder-code-{{$rand}}" cols="6" :options="$folderCodes" :value="$document ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.input label="Remarks" name="remarks" cols="12" :value="$document ?? null"/>
            </div>
            <div class="row mb-2">
                <x-forms.input label="Outgoing Control No" name="outgoing_control_no" cols="6" id="outgoing_control_no"/>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="file-loading">
                        <input id="doc-file-{{$rand}}" name="doc_file_{{$rand}}" type="file" multiple>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.select2-folder-code-{{$rand}}').select2({
            dropdownParent: $('#edit-document-modal')
        });

        let url1_{{$rand}} = '{{route("dashboard.document.view_file",$document->slug)}}';
        uploader_{{$rand}} = $("#doc-file-{{$rand}}").fileinput({
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
            showCancel: false,
            theme: 'fa',
            browseOnZoneClick: false,
            showBrowse: false,
            showCaption: false,
            showRemove: false,
            showUpload: false,
            uploadAsync: false,
            initialPreview: [url1_{{$rand}}],
            overwriteInitial: false,
            initialPreviewAsData: true,
            dropZoneEnabled : false,
            initialPreviewConfig: [
                {
                    caption: "{{$document->filename}}",
                    downloadUrl: url1_{{$rand}},
                    type : '{{(strtolower(substr($document->filename, strrpos($document->filename, '.') + 1)) == "pdf")? "pdf" : "image"}}',
                },
            ],
        }).on('fileloaded', function(event, previewId, index, fileId) {
            $("#edit_document_form_{{$rand}} input[name='_changed']").val('true');
        })

        $("#edit-document-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route('dashboard.document.update','slug')}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,false,true);
                    toast('info','Document successfully updated.','Success!');
                    active = res.slug;
                    setTimeout(function () {
                        documentsTbl.draw(false);
                    },500)
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection