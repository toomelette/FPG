@php
    $rand = Str::random();
    /** @var \App\Models\Course $course  **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-course-form-'.$rand,
    'slug' => $course->slug,
])

@section('modal-header')
    {{$course->name}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Acronym" name="acronym" cols="12" :value="$course ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Name" name="name" cols="12" :value="$course ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-course-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.course.update","slug")}}';
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
                    coursesTbl.draw(false);
                    toast('info','Course successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection