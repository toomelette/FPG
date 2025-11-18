@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-cos-form-'.$rand,
    'slug' => $cos->slug,
])

@section('modal-header')
    Edit
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Date from" name="date_from" cols="6" type="date" :value="$cos ?? null"/>
        <x-forms.input label="Date from" name="date_to" cols="6" type="date" :value="$cos ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Memo date" name="memo_date" cols="6" type="date" :value="$cos ?? null"/>
        <x-forms.input label="Memo Code" name="memo_code" cols="6" :value="$cos ?? null"/>
    </div>

    <div class="row mt-2">
        <x-forms.input label="Funds Available" name="funds_available" cols="6" :value="$cos ?? null"/>
        <x-forms.input label="Position" name="funds_available_position" cols="6" :value="$cos ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-cos-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.cos.update",$cos->slug)}}',
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Data successfully updated.','Success');
                    active = res.slug;
                    cosTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection