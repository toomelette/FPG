@php($rand = \Illuminate\Support\Str::random(15))
@extends('layouts.modal-content', ['form_id'=>'create_sr_form_'.$rand, 'slug'=>$employee->slug])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - Add Service Record
@endsection

@section('modal-body')

        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('sequence_no',[
                'label' => 'Seq No.:*',
                'cols' => 4,
            ]) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('from_date',[
                'label' => 'Date From:*',
                'cols' => 4,
                'type' => 'date',
            ]) !!}

            <div class="form-group col-md-4 to_date ">
                <label for="to_date">Date To *</label>
                <input class="form-control " id="to_date" name="to_date" type="date" value="" placeholder="Date To">
                <div class="checkbox no-margin">
                    <label>
                        <input type="checkbox" name="upto_date"> Upto present
                    </label>
                </div>
            </div>

        </div>

        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
                'label' => 'Position:*',
                'cols' => 6,
            ]) !!}

            {!! \App\Swep\ViewHelpers\__form2::select('appointment_status',[
               'label' => 'Appointment Status:*',
               'cols' => 6,
               'options' => \App\Swep\Helpers\Arrays::appointmentStatus(),
            ]) !!}
        </div>

        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
               'label' => 'Salary:*',
               'cols' => 6,
               'class' => 'autonum_'.$rand,
            ]) !!}
            {!! \App\Swep\ViewHelpers\__form2::textbox('mode_of_payment',[
               'label' => 'Mode of Payment:*',
               'cols' => 6,
            ]) !!}

        </div>

        <div class="row">

            {!! \App\Swep\ViewHelpers\__form2::textbox('station',[
               'label' => 'Station:*',
               'cols' => 4,
            ]) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('gov_serve',[
               'label' => 'Government Serve:*',
               'cols' => 4,
            ]) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('psc_serve',[
               'label' => 'PSC Serve:*',
               'cols' => 4,
            ]) !!}

        </div>

        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('lwp',[
               'label' => 'LWP:*',
               'cols' => 4,
            ]) !!}
            {!! \App\Swep\ViewHelpers\__form2::textbox('spdate',[
               'label' => 'SP Date:*',
               'cols' => 4,
            ]) !!}
            {!! \App\Swep\ViewHelpers\__form2::textbox('status',[
               'label' => 'Status:*',
               'cols' => 4,
            ]) !!}

        </div>

        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('remarks',[
               'label' => 'Remarks:*',
               'cols' => 12,
            ]) !!}
        </div>



@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#create_sr_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        uri = '{{route(\Illuminate\Support\Facades\Request::route()->getName().'_store',"slug")}}';
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
                sr_active = res.slug;
                service_records_tbl.draw(false);
                notify("Data successfully saved.","success");
                $("input[name='to_date']").removeAttr('disabled');
                wipe_autonum();
            },
            error: function (res) {
                errored(form,res)
                console.log(res);
            }
        })
    })

    $("input[name='upto_date']").change(function () {
        let t = $(this);

        if(t.prop('checked')){
            t.parent('label').parent('div').siblings('#to_date').attr('disabled','disabled');
        }else{
            t.parent('label').parent('div').siblings('#to_date').removeAttr('disabled');
        }
    })
    
    $(".autonum_{{$rand}}").each(function () {
        new AutoNumeric(this,autonum_settings);
    })
</script>
@endsection

