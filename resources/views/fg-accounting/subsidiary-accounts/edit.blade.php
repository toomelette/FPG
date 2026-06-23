@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-account-form-'.$rand,
    'slug' => $account->id,
])

@section('modal-header')
    Edit
@endsection

@section('modal-body')

    <div class="row">
        <x-forms.input label="Account Title" name="account_title" cols="12" :value="$account ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Address" name="account_address" cols="12" :value="$account ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Contact Person" name="contact_person" cols="12" :value="$account ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Contact No" name="contact_no" cols="12" :value="$account ?? null"/>
    </div>

    @if(empty($account->client) && $account->account_code == '11000')
        <div class="row mt-2">
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" type="checkbox" checked name="create_account">
                    <span class="form-check-label">
                    Create a client profile
                </span>
                </label>
            </div>
        </div>
    @endif

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-account-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("subsidiary-accounts.update","slug")}}';
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
                    active = res.id;
                    accountsTbl.draw(false);
                    toast('info','Account successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection