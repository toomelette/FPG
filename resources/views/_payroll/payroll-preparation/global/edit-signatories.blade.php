@php
    $rand = Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster  **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-signatories-form-'.$rand,
    'slug' => $payrollMaster->slug,
])

@section('modal-header')

@endsection

@section('modal-body')
    <x-adminkit.html.alert type="primary mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
        BOX A (CERTIFIED)
    </x-adminkit.html.alert>
    <div class="row mb-2">
        <x-forms.input :value="$payrollMaster" label="Name" name="a_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="a_position" cols="6"/>
    </div>

    <x-adminkit.html.alert type="warning mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
        BOX B (Head, Accounting Unit)
    </x-adminkit.html.alert>
    <div class="row mb-2">
        <x-forms.input :value="$payrollMaster" label="Name" name="b_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="b_position" cols="6"/>
    </div>

    <x-adminkit.html.alert type="info mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
        BOX C (Head of the Agency/Representative)
    </x-adminkit.html.alert>
    <div class="row mb-2">
        <x-forms.input :value="$payrollMaster" label="Name" name="c_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="c_position" cols="6"/>
    </div>


    <x-adminkit.html.alert type="success mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
        BOX D (Disbursing Officer)
    </x-adminkit.html.alert>
    <div class="row mb-2">
        <x-forms.input :value="$payrollMaster" label="Name" name="d_name" cols="6"/>
        <x-forms.input :value="$payrollMaster" label="Position" name="d_position" cols="6"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
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