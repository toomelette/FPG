@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-cash-advance-form-'.$rand,
    'slug' => $ca->uuid,
])

@section('modal-header')
    Make Action
@endsection

@section('modal-body')

    <div class="row">
        <x-forms.input label="Amount approved" name="amount_approved" cols="6" class="autonum-{{$rand}}" :value="$ca ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        initializeAutonumByClass('.autonum-{{$rand}}');

        $("#edit-cash-advance-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("cash-advances.update","slug")}}?approve';
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
                    active = res.uuid;
                    cashAdvancesTbl.draw(false);
                    toast('info','Data successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection