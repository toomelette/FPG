@php
    $rand = Str::random();
    /** @var \App\Models\Applicant $applicant **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-applicant-form-'.$rand,
    'slug' => $applicant->slug,
])

@section('modal-header')
    {{$applicant->lastname}}, {{$applicant->firstname}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Date received:" name="received_at" cols="3" type="date" :value="$applicant ?? null"/>
        <x-forms.input label="Last Name:" name="lastname" cols="3" :value="$applicant ?? null"/>
        <x-forms.input label="First Name:" name="firstname" cols="3" :value="$applicant ?? null"/>
        <x-forms.input label="Middle Name:" name="middlename" cols="3" :value="$applicant ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Birthday:" name="date_of_birth" cols="2" type="date" :value="$applicant ?? null"/>
        <x-forms.select label="Sex:" name="gender" cols="2" :options="\App\Swep\Helpers\Arrays::sex()" :value="$applicant ?? null"/>
        <x-forms.select label="Civil Status:" name="civil_status" cols="2" :options="\App\Swep\Helpers\Arrays::civil_status()" :value="$applicant ?? null"/>
        <x-forms.input label="Address:" name="address" cols="6" :value="$applicant ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.select label="Course" name="course" class="select2_course_{{$rand}}" cols="6" :value="$applicant ?? null" :select2-preselected="$applicant->course ?? null"/>
        <x-forms.input label="School" name="school" cols="6" :value="$applicant ?? null"/>

    </div>

    <div class="row mb-2">
        <div class="form-group col-md-12 position_applied">
            <label for="school">Position(s) Applied for:</label>
            <br>
            @php
                $value = [];
                if($applicant->positionApplied()->count()>0){
                    foreach ($applicant->positionApplied as $position){
                        if($position->item_no != '' || $position->item_no != null){
                            array_push($value,'ITEM '.$position->item_no.' - '. $position->position_applied);
                        }else{
                            array_push($value,$position->position_applied);
                        }
                    }
                }

            @endphp

            <input value="{{implode(',',$value)}}" type="text" name="position_applied" id="position_applied_{{$rand}}" class="form-control"  data-role="tagsinput" style="width:100%;">
            <p class="text-info"><i class="fa fa-info"></i> You can add more "Position applied for" by pressing <b>ENTER</b>. </p>
        </div>
    </div>

    <div class="row">
        <x-forms.input label="Contact No:" name="contact_no" cols="6" :value="$applicant ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".select2_course_{{$rand}}").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","applicant_courses")}}?default=Select',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $('#edit-applicant-modal')
        });

        $("#position_applied_{{$rand}}").tagsinput({
            typeaheadjs: {
                name: 'citynames',
                displayKey: 'name',
                valueKey: 'name',
                source: citynames.ttAdapter(),
            }
        });

        $('.bootstrap-tagsinput input').on('keypress', function(e){
            if (e.keyCode == 13){
                e.keyCode = 188;
                e.preventDefault();
            }
        });

        $("#edit-applicant-form-{{$rand}}").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            let uri = '{{route("dashboard.applicant.update",$applicant->slug)}}';
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
                    toast('info','Applicant changes were saved.','Success');
                    active = res.slug;
                    applicantsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection