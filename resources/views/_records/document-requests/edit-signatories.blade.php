@php
    $rand = Str::random();
    /** @var \App\Models\RECORDS\DocumentRequests $documentRequest **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-document-request-form-'.$rand,
    'slug' => $documentRequest->slug,
])

@section('modal-header')
    Edit Signatories
@endsection

@section('modal-body')

    <div class="alert alert-success mb-0" role="alert">
        <div class="alert-message p-1 text-center text-strong">
            Endorsed by
        </div>
    </div>
    <div class="row mb-4">
        <x-forms.input label="Name" name="endorsed_by" cols="6"  :value="$documentRequest ?? null"/>
        <x-forms.input label="Position" name="endorsed_by_position" cols="6"  :value="$documentRequest ?? null"/>
    </div>

    <div class="alert alert-info mb-0" role="alert">
        <div class="alert-message p-1 text-center text-strong">
            Approved by
        </div>
    </div>
    <div class="row mb-4">
        <x-forms.input label="Name" name="approved_by" cols="6"  :value="$documentRequest ?? null"/>
        <x-forms.input label="Position" name="approved_by_position" cols="6"  :value="$documentRequest ?? null"/>
    </div>

    <div class="alert alert-warning mb-0" role="alert">
        <div class="alert-message p-1 text-center text-strong">
            Released by
        </div>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Name" name="released_by" cols="6"  :value="$documentRequest ?? null"/>
        <x-forms.input label="Position" name="released_by_position" cols="6"  :value="$documentRequest ?? null"/>
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
            let uri = '{{route("dashboard.document_request.signatories","slug")}}';
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