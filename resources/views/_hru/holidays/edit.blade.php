@php
    $rand = Str::random();
    /** @var \App\Models\Holiday $holiday  **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-holiday-form-'.$rand,
    'slug' => $holiday->slug,
])

@section('modal-header')
    {{$holiday->name}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Date" name="date" cols="12" type="date" :value="$holiday ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Name" name="name" cols="12" :value="$holiday ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.select label="Type" name="type" cols="12" :options="\App\Swep\Helpers\Helper::holiday_types()" :value="$holiday ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-holiday-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            form = $(this);
            slug = form.attr("data");
            url = '{{route("dashboard.holidays.update","slug")}}';
            url = url.replace("slug",slug);
            loading_btn(form);
            $.ajax({
                url : url,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    active = res.slug;
                    holidaysTbl.draw(false);
                    toast('info','Holiday successfully updated.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection