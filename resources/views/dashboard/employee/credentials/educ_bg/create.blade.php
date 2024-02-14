@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content',['form_id'=>'form_'.$rand])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - Add educational background
@endsection

@section('modal-body')
    <div class="row">
        <input name="employee_slug" value="{{$employee->slug}}" hidden>
        <input name="employee_no" value="{{$employee->employee_no}}" hidden>
        {!! \App\Swep\ViewHelpers\__form2::select('level',[
            'label' => 'Level:',
            'cols' => 4,
            'options' => \App\Swep\Helpers\Helper::educationalLevels(),
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('school_name',[
            'label' => 'School:',
            'cols' => 8,
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('course',[
            'label' => 'Course:',
            'cols' => 6,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('date_from',[
            'label' => 'Date From:',
            'cols' => 3,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('date_to',[
            'label' => 'Date To:',
            'cols' => 3,
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('units',[
            'label' => 'Units:',
            'cols' => 2,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('graduate_year',[
            'label' => 'Year Graduated:',
            'cols' => 3,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('scholarship',[
            'label' => 'Scholarship:',
            'cols' => 7,
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('honor',[
            'label' => 'Honor:',
            'cols' => 6,
        ]) !!}
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.educ_bg.store")}}';
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#educ_active_{{$passed_rand}}").val(res.id);
                    educ_tbl_{{$passed_rand}}.draw(false);
                    succeed(form,true,false);
                    notify('Data successfully saved.');
                },
                error: function (res) {
                    errored(form,res)
                }
            })
        })
    </script>
@endsection

