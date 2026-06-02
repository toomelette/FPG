@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-stock-form-'.$rand,
    'slug' => $stock->uuid,
])

@section('modal-header')
    {{Str::of($stock->name)->limit(50)}} | Edit
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Product Name" name="name" cols="12" :value="$stock ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Description" name="description" cols="12" :value="$stock ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.select label="Unit" name="uom" cols="4" :options="\App\Swep\Helpers\Arrays::uoms()" :value="$stock ?? null"/>
        <x-forms.input label="Category" name="category" cols="4" :value="$stock ?? null"/>
        <x-forms.input label="Bar Code" name="bar_code" cols="4" :value="$stock ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-stock-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("stocks.update","slug")}}';
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
                    stocksTbl.draw(false);
                    toast('info','Product successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection