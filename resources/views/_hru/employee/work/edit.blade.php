@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\EmployeeExperience $work **/
@endphp

@extends('adminkit.modal',[
    'id' => 'edit-work-form-'.$rand,
    'slug' => $work->slug,
])

@section('modal-header')
    {{$work->company}} - {{$work->position}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Company" name="company" cols="7" :value="$work ?? null"/>
        <x-forms.input label="Position" name="position" cols="5" :value="$work ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Date from" name="date_from" cols="4" type="date" :value="$work ?? null"/>
        <x-forms.input label="Date to" name="date_to" cols="4" type="date" :value="$work ?? null"/>
    </div>
    <hr class="no-margin">
    <div class="row mb-2">
        <x-forms.input label="Salary" name="salary" class="autonum-{{$rand}} text-end" cols="4" :value="$work ?? null"/>
        <x-forms.input label="SG" name="salary_grade" cols="4" :value="$work ?? null"/>
        <x-forms.input label="Step" name="step" cols="4" :value="$work ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Appointment Status" name="appointment_status" cols="4" :value="$work ?? null"/>
        <x-forms.select label="Gov't Service" name="is_gov_service" cols="4" :options="[0 => 'NO', 1 => 'YES']" :value="$work ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')

    <script type="text/javascript">
        initializeAutonumByClass('autonum-{{$rand}}');
        $("#edit-work-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.work","slug")}}';
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
                    workActive = res.slug;
                    workTbl.draw(false);
                    toast('info','Data successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection