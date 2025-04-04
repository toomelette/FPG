@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRPayPlanitilla $plantilla **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-plantilla-form-'.$rand,
    'slug' => $plantilla->slug,
])

@section('modal-header')
    {{$plantilla->item_no}} - {{ $plantilla->position  }}
@endsection

@section('modal-body')
    
    
    <div class="row mb-2">
        <x-forms.input label="Position" name="position" cols="8" :value="$plantilla ?? null"/>
        <x-forms.select label="JG" name="job_grade" cols="2" :value="$plantilla ?? null" :options="\App\Swep\Helpers\Arrays::jobGradeLevels()"/>
        <x-forms.select label="Step" name="step_inc" cols="2" :value="$plantilla ?? null" :options="\App\Swep\Helpers\Arrays::stepIncements()"/>
    </div>


    <p class="page-header-sm text-info text-strong mb-2" style="border-bottom: 1px solid #cedbe1">
        Qualification Standards
    </p>

    <div class="row mb-2">
        <x-forms.textarea label="Education" name="qs_education" cols="12" rows="2" :value="$plantilla ?? null"/>
    </div>
    <div class="row mb-2">

    </div>
    <div class="row mb-2">
        <x-forms.textarea label="Experience" name="qs_experience" cols="12" rows="2" :value="$plantilla ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.textarea label="Eligibility" name="qs_eligibility" cols="12" rows="2" :value="$plantilla ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.textarea label="Competency" name="qs_competency" cols="12" rows="2" :value="$plantilla ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Place of Assignment" name="place_of_assignment" cols="12"  :value="$plantilla ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.checkbox label="Job Classification"
                          type="checkbox"
                          name="job_classification"
                          cols="12"
                          each-class="6"
                          :options="\App\Swep\Helpers\Arrays::jobClassifications()"
                          :value="$plantilla->classifications->pluck('classification')->toArray() ?? null"
        />
    </div>


@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-plantilla-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route('dashboard.plantilla.update',$plantilla->id)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Plantilla item successfully updated.','Success!');
                    active = res.id;
                    plantillaTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection