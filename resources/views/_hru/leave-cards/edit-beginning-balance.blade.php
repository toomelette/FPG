@php
    $rand = Str::random();
    /** @var \App\Models\Employee $employee **/
    /** @var \App\Models\HRU\LeaveBeginningBalance $begBal **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-leave-card-form-'.$rand,
    'slug' => $employee->slug,
])

@section('modal-header')
    {{$employee->full['LFEMi']}} | <small>Beginning Balance</small>
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="As of" name="as_of" cols="4" type="date" :value="$begBal ?? null"/>
        <x-forms.input label="Vacation Leave" name="vl" cols="4" type="number" step="0.001" :value="$begBal ?? null"/>
        <x-forms.input label="Sick Leave" name="sl" cols="4" type="number" step="0.001" :value="$begBal ?? null"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-leave-card-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.leave_card.beginning_balance",$employee->slug)}}';
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
                    leaveCardsTbl.draw(false);
                    toast('info','','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection