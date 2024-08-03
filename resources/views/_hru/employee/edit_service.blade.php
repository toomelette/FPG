@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content',['form_id'=>'edit_sr_form_'.$rand, 'slug'=>$sr->slug])

@section('modal-header')
{{$sr->position}} - Edit
@endsection

@section('modal-body')
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('sequence_no',[
            'label' => 'Seq No.:*',
            'cols' => 4,
        ],$sr) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('from_date',[
            'label' => 'Date From:*',
            'cols' => 4,
            'type' => 'date',
        ],$sr) !!}

        <div class="form-group col-md-4 to_date ">
            <label for="to_date">Date To *</label>
            @php($value = '')
            @if($sr->upto_date != 1)
                @if($sr->to_date != '')
                    @php($value = \Illuminate\Support\Carbon::parse($sr->to_date)->format('Y-m-d'))
                @endif
            @endif
            <input class="form-control " id="e_to_date" name="to_date" type="date" value="{{$value}}" placeholder="Date To" {{($sr->upto_date == 1)? 'disabled="disabled"':''}}>
            <div class="checkbox no-margin">
                <label>
                    <input type="checkbox" name="upto_date" {{($sr->upto_date == 1)? 'checked':''}}> Upto present
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
            'label' => 'Position:*',
            'cols' => 6,
        ],$sr) !!}

        {!! \App\Swep\ViewHelpers\__form2::select('appointment_status',[
           'label' => 'Appointment Status:*',
           'cols' => 6,
           'options' => \App\Swep\Helpers\Arrays::appointmentStatus(),
        ],$sr) !!}
    </div>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
           'label' => 'Salary:*',
           'cols' => 6,
           'class' => 'autonum_'.$rand,
        ],$sr) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('mode_of_payment',[
           'label' => 'Mode of Payment:*',
           'cols' => 6,
        ],$sr) !!}

    </div>

    <div class="row">

        {!! \App\Swep\ViewHelpers\__form2::textbox('station',[
           'label' => 'Station:*',
           'cols' => 4,
        ],$sr) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('gov_serve',[
           'label' => 'Government Serve:*',
           'cols' => 4,
        ],$sr) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('psc_serve',[
           'label' => 'PSC Serve:*',
           'cols' => 4,
        ],$sr) !!}

    </div>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('lwp',[
           'label' => 'LWP:*',
           'cols' => 4,
        ],$sr) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('spdate',[
           'label' => 'SP Date:*',
           'cols' => 4,
        ],$sr) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('status',[
           'label' => 'Status:*',
           'cols' => 4,
        ],$sr) !!}

    </div>

    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('remarks',[
           'label' => 'Remarks:*',
           'cols' => 12,
        ],$sr) !!}
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-success pull-right" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit_sr_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        loading_btn(form);
        var uri = '{{route(\Illuminate\Support\Facades\Request::route()->getName().'_update',"slug")}}';
        uri = uri.replace("slug","{{$sr->slug}}");
        $.ajax({
            url : uri,
            data : form.serialize(),
            type: 'PUT',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,true);
                sr_active = res.slug;
                service_records_tbl.draw(false);
                notify("Data successfully updated.","success");
                $("input[name='to_date']").removeAttr('disabled');
            },
            error: function (res) {
                errored(form,res);
                console.log(res);
            }
        })
    })

    $("input[name='upto_date']").change(function () {
        let t = $(this);

        if(t.prop('checked')){
            t.parent('label').parent('div').siblings('#e_to_date').attr('disabled','disabled');
        }else{
            t.parent('label').parent('div').siblings('#e_to_date').removeAttr('disabled');
        }
    })

    $(".autonum_{{$rand}}").each(function () {
        new AutoNumeric(this,autonum_settings);
    })
</script>
@endsection

