@php
    $rand = Str::random();
    /** @var \App\Models\EmailContact $contact **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-contact-form-'.$rand,
    'slug' => $contact->slug,
])

@section('modal-header')
    {{$contact->name}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Name" name="name" cols="12" :value="$contact ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Email address" name="email" cols="12" :value="$contact ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Contact no." name="contact_no" cols="12" :value="$contact ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-contact-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.email_contact.update","slug")}}';
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
                    contactsTbl.draw(false);
                    toast('info','Contact successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection