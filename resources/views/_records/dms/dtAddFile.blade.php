@php
    $rand = Str::random();
    /** @var \App\Models\Document $document  **/
@endphp
@extends('adminkit.modal',[
    'id' => 'add-document-form-'.$rand,
    'slug' => $document->slug,
])

@section('modal-header')
    {{$document->document_control_no}}
@endsection

@section('modal-body')
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
                <x-forms.select label="Folder Code" name="folder_code" class="select2-folder-code-{{$rand}}" cols="6" :options="$folderCodes"/>
                <x-forms.select label="2nd Folder Code (If Cross-File)" name="folder_code2" class="select2-folder-code-{{$rand}}" cols="6" :options="$folderCodes"/>
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
                    <label>Select File to be saved:</label>
                    <div class="row">
                        @if($document->documentFiles->isNotEmpty())
                            @php $File = 1; @endphp
                            @foreach($document->documentFiles as $data)
                                <label>
                                    <input type="radio" name="selected_file" id="dms-file-{{$File}}" value="file:{{$data->slug}}" @if($loop->first) checked @endif>
                                    <a href="{{route("dashboard.dms_document.show", $data->slug)}}" target="_blank">
                                        {{$data->file_name}}
                                    </a>
                                </label>
                                @php $File++; @endphp
                            @endforeach
                        @endif
                    </div>
                    @if($document->AttachmentFiles->isNotEmpty())
                    <label>Select Attachment to be saved:</label>
                    @endif
                    <div class="row">
                        @if($document->AttachmentFiles->isNotEmpty())
                            @php $File = 1; @endphp
                            @foreach($document->AttachmentFiles as $data)
                                <label>
                                    <input type="radio" name="selected_file" id="dms-file-{{$File}}" value="attachment:{{$data->slug}}" >
                                    <a href="{{route("dashboard.dms_document.showAttachment", $data->slug)}}" target="_blank">
                                        {{$data->document_attachment_file}}
                                    </a>
                                </label>
                                @php $File++; @endphp
                            @endforeach
                        @endif
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
        $("#add-document-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route('dashboard.dms_document.update','slug')}}';
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