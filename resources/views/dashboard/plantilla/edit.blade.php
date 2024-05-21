@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content',['form_id'=>'edit_item_form_'.$rand,'slug' => $pp->id, 'uri'=> route('dashboard.plantilla.update',$pp->id)])

@section('modal-header')
{{$pp->position}} - Edit
@endsection

@section('modal-body')
    <input name="id" value="{{$pp->id}}" hidden>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('item_no',[
            'label' => 'Item No:*',
            'cols' => '4',
        ],$pp) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
            'label' => 'Position:*',
            'cols' => '8',
        ],$pp) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('job_grade',[
            'label' => 'JG:*',
            'cols' => '4',
        ],$pp) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('step_inc',[
            'label' => 'Step Inc:*',
            'cols' => 4,
        ],$pp) !!}
    </div>
    
    <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
        Qualification Standards
    </p>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textarea('qs_education',[
            'label' => 'Education:',
            'cols' => 12,
        ],$pp ?? null)   !!}
        {!! \App\Swep\ViewHelpers\__form2::textarea('qs_training',[
            'label' => 'Training:',
            'cols' => 12,
        ],$pp ?? null)   !!}

        {!! \App\Swep\ViewHelpers\__form2::textarea('qs_experience',[
            'label' => 'Experience:',
            'cols' => 12,
        ],$pp ?? null)   !!}

        {!! \App\Swep\ViewHelpers\__form2::textarea('qs_eligibility',[
            'label' => 'Eligibility:',
            'cols' => 12,
        ],$pp ?? null)   !!}
        {!! \App\Swep\ViewHelpers\__form2::textarea('qs_competency',[
            'label' => 'Competency:',
            'cols' => 12,
        ],$pp ?? null)   !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('place_of_assignment',[
            'label' => 'Place of Assignment:',
            'cols' => 12,
        ],$pp ?? null)   !!}
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#fullname_{{$rand}}").typeahead({
            ajax : "{{\Illuminate\Support\Facades\Request::url()}}?typeahead=true",
            onSelect:function (result) {
                $("#employee_no_{{$rand}}").val(result.value);

            },
            lookup: function (i) {
                console.log(i);
            }
        });
        
        $("#edit_item_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : form.attr('uri'),
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                   succeed(form,true,true);
                   notify('Plantilla item successfully updated.');
                   active = res.id;
                   plantilla_tbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection

