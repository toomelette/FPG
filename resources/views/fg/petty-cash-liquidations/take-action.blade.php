@php
    $rand = randString();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-pcl-form-'.$rand,
    'slug' => $pcl->uuid,
])

@section('modal-header')
    Take Action
@endsection

@section('modal-body')
    <div class="row">

        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <label class="form-check">
                        <input class="form-check-input" type="radio" value="approve" name="radio">
                        <span class="form-check-label">
                        APPROVE
                    </span>
                    </label>
                </div>
            </div>

            <fieldset id="approve-{{$rand}}" disabled>
                <div class="row">
                    <x-forms.input label="Cash Voucher No." name="cv_no" cols="12"  :value="$pcl ?? null"/>
                </div>
                <div class="row mt-2">
                    <x-forms.input label="Total Amount" name="approved_amount" cols="12" class="autonum text-end" :value="$pcl->total_amount ?? null"/>
                </div>
            </fieldset>

            <div class="row mt-4">
                <div class="col-md-12">
                    <label class="form-check">
                        <input class="form-check-input" type="radio" value="disapprove" name="radio">
                        <span class="form-check-label">
                        DISAPPROVE
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <input id="attachments-{{$rand}}" name="attachments[]" type="file" class="file fi" multiple
                   data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
        </div>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">

        $("#edit-pcl-form-{{$rand}} input[name='radio']").change(function (){
            if($(this).val() === 'approve'){
                $("#approve-{{$rand}}").removeAttr('disabled');
            }else{
                $("#approve-{{$rand}}").attr('disabled','disabled');

            }
        })
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
        $("#edit-pcl-form-{{$rand}} .kv-file-remove").remove();

        $("#edit-pcl-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            formData.append('_method', 'PATCH');

            let uri = '{{route("petty-cash-liquidations.update","slug")}}?takeAction';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data: formData,
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                processData: false,
                contentType: false,
                success: function (res) {
                    succeed(form,true,true);
                    active = res.uuid;
                    pclTbl.draw(false);
                    toast('info','Action successfully taken.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection