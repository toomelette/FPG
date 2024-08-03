@php
    /** @var \App\Models\EmployeeEducationalBackground $education **/
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-education-form-'.$rand,
    'slug' => $education->slug,
])

@section('modal-header')
    {{$education->level}} - {{$education->school_name}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.select label="Level" name="level" cols="4" :options="\App\Swep\Helpers\Helper::educationalLevels()"  :value="$education ?? null"/>
        <x-forms.input label="School" name="school_name" cols="8" :value="$education ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Course" name="course" cols="6" :value="$education ?? null"/>
        <x-forms.input label="Date from" name="date_from" cols="3" :value="$education ?? null"/>
        <x-forms.input label="Date to" name="date_to" cols="3" :value="$education ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Units" name="units" cols="2" :value="$education ?? null"/>
        <x-forms.input label="Year Graduated" name="graduate_year" cols="3" :value="$education ?? null"/>
        <x-forms.input label="Scholarship" name="scholarship" cols="7" :value="$education ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Honor" name="honor" cols="6" :value="$education ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-education-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.education","slug")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    educationActive = res.slug;
                    educationTbl.draw(false);
                    toast('info','Data successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection