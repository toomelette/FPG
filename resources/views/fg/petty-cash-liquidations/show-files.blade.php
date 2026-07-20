@php
    $rand = randString();
 @endphp
@extends('adminkit.modal')

@section('modal-header')
    Files | {{$pcl->project_id}} -  {{\App\Swep\Helpers\Helper::dateFormat($pcl->date,'m/d/Y')}}
@endsection

@section('modal-body')
    <input id="attachments-{{$rand}}" name="attachments[]" type="file" class="file fi" multiple
           data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#attachments-{{$rand}}').fileinput({
            showUpload: false,
            showRemove: false,
            showBrowse: false,   // hides browse button
            showCaption: false,
            browseOnZoneClick: false,
            dropZoneEnabled: false,
            overwriteInitial: false,
            initialPreviewAsData: true,

            initialPreview: [
                @forelse($pcl->attachments as $attachment)
                    '{{route("petty-cash-liquidations.show",$pcl->uuid)}}?showAttachment&id={{Crypt::encryptString($attachment->id)}}',
                @empty
                @endforelse
            ],

            initialPreviewAsData: true,

            initialPreviewConfig: [
                    @forelse($pcl->attachments as $attachment)
                {
                    type: "{{\App\Swep\Helpers\Helper::krajeeFileType($attachment->mime_type)}}", // 🔥 REQUIRED for first file
                    caption: "{{$attachment->original_filename}}",
                    size: {{$attachment->size ?? 0}},
                    url: "{{route("petty-cash-liquidations.destroy",$pcl->uuid)}}?deleteAttachment",
                    key: '{{Crypt::encryptString($attachment->id)}}',
                },
                @empty
                @endforelse

            ],
            fileActionSettings: {
                showRemove: false,
                showUpload: false,
                showDrag: false,
                showZoom: true   // optional: allow zoom only
            }
        });

        $("#show-files-modal .kv-file-remove").remove();
    </script>
@endsection