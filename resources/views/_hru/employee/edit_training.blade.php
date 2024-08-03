@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content',['form_id'=>'edit_training_form_'.$rand, 'slug'=>$training->slug])

@section('modal-header')
    {{$training->title}} - Edit
@endsection

@section('modal-body')
     <div class="row">
          {!! \App\Swep\ViewHelpers\__form2::textbox('sequence_no',[
            'label' => 'Sequence no.:',
            'type' => 'number',
            'cols' => 6,
        ], $training) !!}
          {!! __form::textbox(
             '6 type', 'type', 'text', 'Type of Seminar', 'Type of Seminar', $training->type, '', '', ''
          ) !!}
     </div>
     <div class="row">
          {!! __form::textbox(
                 '12 title', 'title', 'text', 'Title *', 'Title', $training->title, '', '', ''
              ) !!}

     </div>
     <div class="row">

          {!! __form::textbox(
             '6 date_from', 'date_from', 'date', 'Date From', 'Date From', ($training->date_from == ''?'':\Carbon\Carbon::parse($training->date_from)->format('Y-m-d')), '', '', ''
          ) !!}

          {!! __form::textbox(
            '6 date_to', 'date_to', 'date', 'Date To', 'Date To', ($training->date_to == ''?'':\Carbon\Carbon::parse($training->date_to)->format('Y-m-d')), '', '', ''
         ) !!}

     </div>

     <div class="row">
          {!! \App\Swep\ViewHelpers\__form2::textbox('detailed_period',[
              'cols' => 12,
              'label' => 'Detailed Period:',
              'placeholder' => 'E.g.: Feb 1,3,4,7 2015',
          ], $training) !!}
     </div>

     <div class="row">
          {!! __form::textbox(
             '6 hours', 'hours', 'text', 'Hours *', 'Hours', $training->hours, '', '', ''
          ) !!}

          {!! __form::textbox(
             '6 conducted_by', 'conducted_by', 'text', 'Conducted By', 'Conducted By', $training->conducted_by, '', '', ''
          ) !!}
     </div>

     <div class="row">
          {!! __form::textbox(
             '6 venue', 'venue', 'text', 'Venue', 'Venue', $training->venue, '', '', ''
          ) !!}

          {!! __form::textbox(
             '6 remarks', 'remarks', 'text', 'Remarks', 'Remarks', $training->remarks, '', '', ''
          ) !!}

          {!! __form::select_static(
            '6 is_relevant', 'is_relevant', 'Relevant', $training->is_relevant, ['Yes' => 'true', 'No' => 'false'], '', '', '', ''
          ) !!}
     </div>
@endsection

@section('modal-footer')
     <button class="btn btn-success pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
     $("#edit_training_form_{{$rand}}").submit(function (e) {
          e.preventDefault();
          let form = $(this);
          loading_btn(form);
          var uri = '{{route(\Illuminate\Support\Facades\Request::route()->getName()."_update","slug")}}';
          uri = uri.replace("slug","{{$training->slug}}");
          $.ajax({
               url : uri,
               data : form.serialize(),
               type: 'PUT',
               headers: {
                    {!! __html::token_header() !!}
               },
               success: function (res) {
                    succeed(form,true,true);
                    trainings_active = res.slug;
                    trainings_tbl.draw(false);
                    notify("Data successfully updated.","success");
               },
               error: function (res) {
                    errored(form,res);
                    console.log(res);
               }
          })
     })
</script>
@endsection

