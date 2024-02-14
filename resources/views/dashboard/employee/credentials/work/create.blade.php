@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content',['form_id'=> 'add_work_form_'.$rand])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - <small>Add Work Experience</small>
@endsection

@section('modal-body')
    <input name="employee_slug" value="{{$employee->slug}}" hidden>
    <input name="employee_no" value="{{$employee->employee_no}}" hidden>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('company',[
            'label' => 'Company:*',
            'cols' => 7,
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
            'label' => 'Position:*',
            'cols' => 5,
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('date_from',[
           'label' => 'Date from:',
           'cols' => 4,
           'type' => 'date',
        ]) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('date_to',[
           'label' => 'Date to:',
           'cols' => 4,
           'type' => 'date',
        ]) !!}
    </div>
    <hr class="no-margin">
    <div class="row" style="margin-top: 10px">
        {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
            'label' => 'Salary:',
            'cols' => 4,
        ]) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('salary_grade',[
            'label' => 'SG:',
            'cols' => 4,
            'type' => 'number',
        ]) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('step',[
            'label' => 'Step:',
            'cols' => 4,
            'type' => 'number',
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('appointment_status',[
            'label' => 'Appointment Status:',
            'cols' => 4,
        ]) !!}

        {!! \App\Swep\ViewHelpers\__form2::select('is_gov_service',[
            'label' => "Gov't Service:",
            'cols' => 4,
            'options' => [
                '1' => 'YES',
                '0' => 'NO',
            ]
        ]) !!}
    </div>

@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save </button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#add_work_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.employee.work.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,false);
                    $("#work_active_{{$passed_rand}}").val(res.id);
                    work_tbl_{{$passed_rand}}.draw(false);
                    notify('Data successfully saved.','success');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection

