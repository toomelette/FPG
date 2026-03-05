@php
    $rand = randString();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-client-form-'.$rand,
    'slug' => $client->uuid,
])

@section('modal-header')
    Edit {{$client->name}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Account No." name="account_no" cols="5" :value="$client ?? null"/>
        <x-forms.input label="Client Name" name="name" cols="7" :value="$client ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Address" name="address" cols="8" :value="$client ?? null"/>
        <x-forms.input label="TIN" name="tin" cols="4" :value="$client ?? null"/>
    </div>
    <p class="page-header-sm text-info mt-2" style="border-bottom: 1px solid #cedbe1">
        Contact Person
    </p>
    <div class="row mt-2">
        <x-forms.input label="Name" name="contact_person" cols="7" :value="$client ?? null"/>
        <x-forms.input label="Contact No." name="contact_no" cols="5" :value="$client ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-client-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("clients.update", $client->uuid)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','','Success');
                    active = res.uuid;
                    clientsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection