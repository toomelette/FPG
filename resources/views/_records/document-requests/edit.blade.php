@php
$rand = Str::random();
/** @var \App\Models\RECORDS\DocumentRequests $documentRequest **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-document-request-form-'.$rand,
    'slug' => $documentRequest->slug,
])

@section('modal-header')
Edit Request
@endsection

@section('modal-body')

    <div class="row mb-2">
        <x-forms.checkbox type="radio" label="Requesting party" name="requesting_party" cols="12" :options="\App\Swep\Helpers\Arrays::documentRequestingParty()" each-class="6" :value="[$documentRequest->requesting_party]"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Specify requesting party" name="requesting_party_specify" cols="md-12" container-class="{{$documentRequest->requesting_party != 'Other Government Agencies' ? 'visually-hidden' : ''}}" :value="$documentRequest ?? null"/>
    </div>
    <div class="row mb-3">
        <x-forms.textarea label="Requested records/documents" name="requested_records" cols="md-12" :Value="$documentRequest ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.checkbox type="radio" label="Purpose" name="purpose" cols="md-12" :options="\App\Swep\Helpers\Arrays::documentRequestPurpose()" each-class="12 mb-1" :value="[$documentRequest->purpose]"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Specify purpose" name="purpose_specify" cols="md-12" container-class="{{$documentRequest->purpose != 'Others' ? 'visually-hidden' : ''}}" :value="$documentRequest->purpose_specify"/>
    </div>

    <div class="row mb-3">
        <x-forms.input label="Requested by" name="requested_by" cols="6" :value="$documentRequest ?? null"/>
        <x-forms.input label="Position" name="requested_by_position" cols="6" :value="$documentRequest ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-document-request-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.document_request.update","slug")}}';
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
                    succeed(form,true,true);
                    active = res.slug;
                    requestsTbl.draw(false);
                    toast('info','Request successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection