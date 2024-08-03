@php
/** @var \App\Models\EmployeeEligibility $eligibility **/
$rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-sr-form-'.$rand,
    'slug' => $eligibility->slug,
])

@section('modal-header')
    {{$eligibility->eligibility}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Eligibility" name="eligibility" cols="8" :value="$eligibility ?? null"/>
        <x-forms.input label="Level" name="level" cols="4" :value="$eligibility ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Rating" name="rating" cols="3" step="0.01" type="number" :value="$eligibility ?? null"/>
        <x-forms.input label="Place of exam" name="exam_place" cols="5" :value="$eligibility ?? null"/>
        <x-forms.input label="Date of exam" name="exam_date" cols="4" type="date" :value="$eligibility ?? null"/>

    </div>
    <div class="row mb-2">
        <x-forms.input label="License No." name="license_no" cols="4" :value="$eligibility ?? null"/>
        <x-forms.input label="License Validity" name="license_validity" cols="4" type="date" :value="$eligibility ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-sr-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.eligibility","slug")}}';
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
                    eligibilityActive = res.slug;
                    eligibilityTbl.draw(false);
                    toast('info','Data successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection