@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content',['form_id'=>'create_training_form_'.$rand, 'slug'=>$employee->slug])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - Add Training
@endsection

@section('modal-body')
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('sequence_no',[
            'label' => 'Sequence no.:',
            'type' => 'number',
            'cols' => 6,
        ]) !!}
        {!! __form::textbox(
           '6 type', 'type', 'text', 'Type of Seminar', 'Type of Seminar', old('type'), $errors->has('type'), $errors->first('type'), ''
        ) !!}
    </div>
    <div class="row">
        {!! __form::textbox(
               '12 title', 'title', 'text', 'Title *', 'Title', old('title'), $errors->has('title'), $errors->first('title'), ''
            ) !!}

    </div>
    <div class="row">
        {!! __form::textbox(
            '6 date_from', 'date_from', 'date', 'Started:', 'Date From','', '', '', ''
         ) !!}

        {!! __form::textbox(
          '6 date_to', 'date_to', 'date', 'Ended:', 'Date To', '', '', '', ''
       ) !!}
    </div>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('detailed_period',[
            'cols' => 12,
            'label' => 'Detailed Period:',
            'placeholder' => 'E.g.: Feb 1,3,4,7 2015',
        ]) !!}
    </div>

    <div class="row">
        {!! __form::textbox(
           '6 hours', 'hours', 'text', 'Hours *', 'Hours', old('hours'), $errors->has('hours'), $errors->first('hours'), ''
        ) !!}

        {!! __form::textbox(
           '6 conducted_by', 'conducted_by', 'text', 'Conducted By', 'Conducted By', old('conducted_by'), $errors->has('conducted_by'), $errors->first('conducted_by'), ''
        ) !!}
    </div>

    <div class="row">
        {!! __form::textbox(
           '6 venue', 'venue', 'text', 'Venue', 'Venue', old('venue'), $errors->has('venue'), $errors->first('venue'), ''
        ) !!}

        {!! __form::textbox(
           '6 remarks', 'remarks', 'text', 'Remarks', 'Remarks', old('remarks'), $errors->has('remarks'), $errors->first('remarks'), ''
        ) !!}

        {!! __form::select_static(
          '6 is_relevant', 'is_relevant', 'Relevant', old('is_relevant'), ['Yes' => 'true', 'No' => 'false'], $errors->has('is_relevant'), $errors->first('is_relevant'), '', ''
        ) !!}
    </div>
@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#create_training_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        uri = '{{route(\Illuminate\Support\Facades\Request::route()->getName()."_store","slug")}}';
        uri = uri.replace('slug','{{$employee->slug}}');
        var form = $(this);
        loading_btn(form);
        $.ajax({
            url : uri,
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,false);
                trainings_active = res.slug;
                trainings_tbl.draw(false);
                notify("Data successfully saved.","success");
            },
            error: function (res) {
                errored(form,res)
                console.log(res);
            }
        })
    })
</script>
@endsection

