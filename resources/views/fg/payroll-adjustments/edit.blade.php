@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-adjustment-form-'.$rand,
    'slug' => $adjustment->slug,
])

@section('modal-header')
    {{$adjustment->code}} - Edit
@endsection

@section('modal-body')

    <div class="row mt-2">
        <x-forms.input label="Description" name="description" cols="12" :value="$adjustment ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.select label="Type" name="type" cols="12" :options="\App\Swep\Helpers\Arrays::payrollAdjustmentTypes()" :value="$adjustment ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Priority" name="priority" cols="12" :value="$adjustment ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-adjustment-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("payroll-adjustments.update",$adjustment->id)}}';
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
                    adjustmentsTbl.draw(false);
                    toast('info','','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection