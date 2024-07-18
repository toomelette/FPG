@php
$rand = Str::random();
/** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
@endphp
@extends('layouts.modal-content',['form_id'=>'edit-signatories-form-'.$rand,'slug'=>$payrollMaster->slug])

@section('modal-header')
    Edit Signatories
@endsection

@section('modal-body')
    <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
        BOX A (CERTIFIED)
    </p>
    <div class="row">
        <x-forms.input :value="$payrollMaster" label="Name" name="a_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="a_position" cols="6"/>
    </div>

    <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
        BOX B (Head, Accounting Unit)
    </p>
    <div class="row">
        <x-forms.input :value="$payrollMaster" label="Name" name="b_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="b_position" cols="6"/>
    </div>

    <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
        BOX C (Head of the Agency/Representative)
    </p>
    <div class="row">
        <x-forms.input :value="$payrollMaster" label="Name" name="c_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="c_position" cols="6"/>
    </div>


    <p class="page-header-sm text-info text-strong" style="border-bottom: 1px solid #cedbe1">
        BOX D (Disbursing Officer)
    </p>
    <div class="row">
        <x-forms.input :value="$payrollMaster" label="Name" name="d_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="d_position" cols="6"/>
    </div>
@endsection

@section('modal-footer')

    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-signatories-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.payroll_preparation.update","slug")}}?signatories=true';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Signatories successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection

