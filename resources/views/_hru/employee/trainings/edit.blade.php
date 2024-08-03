@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\EmployeeTraining $training **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-training-form-'.$rand,
    'slug' => $training->slug,
])

@section('modal-header')
    {{$training->title}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Sequence No." name="sequence_no" cols="6" type="number"  :value="$training ?? null"/>
        <x-forms.input label="Type of Seminar." name="type" cols="6"  :value="$training ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Title" name="title" cols="12"  :value="$training ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Started" name="date_from" cols="6" type="date" :value="$training ?? null"/>
        <x-forms.input label="Ended" name="date_to" cols="6" type="date" :value="$training ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Detailed Period:" name="detailed_period" cols="12" placeholder="E.g.: Feb 1,3,4,7 2015" :value="$training ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Hours" name="hours" cols="6" type="number" :value="$training ?? null"/>
        <x-forms.input label="Conducted By" name="conducted_by" cols="6" :value="$training ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Venue" name="venue" cols="6" :value="$training ?? null"/>
        <x-forms.input label="Remarks" name="remarks " cols="6" :value="$training ?? null"/>
        <x-forms.select label="Is Relevant" name="is_relevant " cols="6" :options="['1' => 'YES', '0' => 'NO']" :value="$training ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit-training-form-{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let uri = '{{route("dashboard.employee.training","slug")}}';
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
                active = res.slug;
                trainings_tbl.draw(false);
                toast('info','Data successfully updated.','Updated');
            },
            error: function (res) {
                errored(form,res);
            }
        })

    })
</script>
@endsection