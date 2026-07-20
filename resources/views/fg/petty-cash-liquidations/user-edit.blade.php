@php
    $rand = randString();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-pcl-form-'.$rand,
    'slug' => $pcl->uuid,
])

@section('modal-header')
    Edit
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <x-forms.input label="Date" name="date" cols="12" type="date" :value="$pcl ?? null"/>
            </div>
            <div class="row mt-2">
                <x-forms.input label="Total Amount" name="total_amount" cols="12" class="autonum text-end" :value="$pcl ?? null"/>
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
        $('#attachments-{{$rand}}').fileinput({

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
            ajaxDeleteSettings: {
                type: "DELETE",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            overwriteInitial: false,
            showRemove: true,
            showUpload: false,
        });
        
        $("#edit-pcl-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let formData = new FormData(this);
            formData.append('_method', 'PATCH');

            let uri = '{{route("petty-cash-liquidations.update","slug")}}';
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
                    pettyCashLiquidationsTbl.draw(false);
                    toast('info','','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection