@php
    $rand = Str::random();
    /** @var \App\Models\HRU\PayrollMasterDetails $payMasterDetail **/
    /** @var \App\Models\HRU\PayrollMasterEmployees $payMasterEmployee **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-deduction-form-'.$rand,
    'slug' => $payMasterDetail->slug ?? Str::random(),
])

@section('modal-header')
    {{$payMasterEmployee->saved_employee_data['full_name'] ?? ''}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Deduction Code" name="code" cols="12" readonly="readonly" value="{{$deductionCode}}"/>
        <x-forms.input label="Type" name="type" cols="12" readonly="readonly" value="DEDUCTION" container-class="visually-hidden"/>
        <x-forms.input label="Listing" name="pay_master_employee_listing_slug" cols="12" readonly="readonly" value="{{$payMasterEmployee->slug}}" container-class="visually-hidden"/>
        <x-forms.input label="Listing" name="employee_slug" cols="12" readonly="readonly" value="{{$payMasterEmployee->employee_slug}}" container-class="visually-hidden"/>

        <x-forms.input label="Amount" name="amount" cols="12" class="autonum-{{$rand}}"  value="{{$payMasterDetail->amount ?? ''}}"/>
    </div>
@endsection

@section('modal-footer')
<button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $(".autonum-{{$rand}}").each(function(){
        new AutoNumeric(this, autonum_settings);
    });

    $("#edit-deduction-form-{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let uri = '{{route("dashboard.payroll_preparation.update",$payMasterEmployee->pay_master_slug)}}?updateDeduction';
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
                let row = $("#payroll-employees-table tr[data='{{$payMasterEmployee->slug}}']");
                row.html(res);
                row.find('td[deduction-code="{{$deductionCode}}"]').addClass('table-success');
                setTimeout(function (){
                    row.find('td[deduction-code="{{$deductionCode}}"]').removeClass('table-success');
                },2000)
                toast('info','Deduction successfully','Updated');

            },
            error: function (res) {
                errored(form,res);
            }
        })

    })
</script>
@endsection