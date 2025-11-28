@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'clone-payroll-form-'.$rand,
    'slug' => $payrollMaster->slug,
])

@section('modal-header')
    {{Carbon::parse($payrollMaster->date)->format('F Y')}} | {{$payrollMaster->type}}
@endsection

@section('modal-body')
    <x-forms.input label="Save as" name="month" cols="12" type="month"/>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#clone-payroll-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.payroll_preparation.update",$payrollMaster->slug)}}?saveAs',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Payroll successfully cloned.','Success');
                    active = res.slug;
                    payrollTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
    </script>
@endsection