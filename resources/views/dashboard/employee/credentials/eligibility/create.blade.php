@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content',['form_id' => 'add_elig_form_'.$rand])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - Add Eligibility
@endsection

@section('modal-body')
    <input name="employee_slug" value="{{$employee->slug}}" hidden>
    <input name="employee_no" value="{{$employee->employee_no}}" hidden>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('eligibility',[
            'label' => 'Eligibility:*',
            'cols' => 8,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('level',[
            'label' => 'Level:',
            'cols' => 4,
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('rating',[
            'label' => 'Rating:',
            'cols' => 3,
            'type' => 'number',
            'step' => '0.01',
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('exam_place',[
            'label' => 'Place of exam:',
            'cols' => 5,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('exam_date',[
            'label' => 'Date of exam:',
            'cols' => 4,
            'type' => 'date',
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('license_no',[
            'label' => 'License No.:',
            'cols' => 4,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('license_validity',[
            'label' => 'License Validity:',
            'cols' => 4,
            'type' => 'date',
        ]) !!}
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#add_elig_form_{{$rand}}").submit(function (e) {

            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            let uri = '{{route("dashboard.employee.elig.store","slug")}}';
            uri = uri.replace('slug','{{$employee->slug}}');
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    $("#elig_active_{{$passed_rand}}").val(res.id);
                    elig_tbl_{{$passed_rand}}.draw(false);
                    notify('Data successfully saved.','success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection

