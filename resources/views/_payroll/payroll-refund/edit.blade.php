@php
    $rand = Str::random();
    /** @var \App\Models\HRU\PayrollMasterDetails $payrollDetail  **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-refund-form-'.$rand,
    'slug' => $payrollDetail->slug,
])

@section('modal-header')
    {{$payrollDetail->employeePayroll->employee->full['LFEMi'] ?? ''}} {{$payrollDetail->code}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Refund amount" name="refund_amount" class="autonum-{{$rand}}" cols="6" :value="$payrollDetail ?? null"/>
        <x-forms.input label="Refund date" name="refund_date" cols="6" type="date" :value="$payrollDetail ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Remarks" name="refund_remarks" cols="12" :value="$payrollDetail ?? null"/>
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
        $("#edit-refund-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.payroll_refund.update","slug")}}';
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
                    dataTablesArray[activeTable].draw(false);
                    toast('info','Refund successfully saved.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection