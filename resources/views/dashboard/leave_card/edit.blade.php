@php($rand = \Illuminate\Support\Str::random(10))
@extends('layouts.modal-content',['form_id' => 'edit_beg_bal_form_'.$rand,'slug' => $employee->slug])

@section('modal-header')
{{$employee->full_name}} | <small>Beginning Balance</small>
@endsection

@section('modal-body')
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('as_of',[
            'label' => 'As of:',
            'type' => 'date',
            'cols' => 4,
        ],$begBal ?? null) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('vl',[
            'label' => 'Vacation Leave:',
            'cols' => 4,
            'type' => 'number',
            'step' => '0.001',
        ],$begBal ?? null) !!}
        {!! \App\Swep\ViewHelpers\__form2::textbox('sl',[
            'label' => 'Sick Leave:',
            'cols' => 4,
            'type' => 'number',
            'step' => '0.001',
        ],$begBal ?? null) !!}
    </div>
@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit_beg_bal_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.leave_card.update","slug")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    active = res.slug;
                    employees_tbl.draw(false);
                    toast('info','Beginning balance successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection

