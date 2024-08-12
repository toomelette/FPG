@php
    $rand = Str::random();
    /** @var \App\Models\LeaveCard $leaveCard **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-leave-card-form-'.$rand,
    'slug' => $leaveCard->slug,
])

@section('modal-header')
    {{$leaveCard->date}} | {{$leaveCard->leave_card}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Date" name="date" cols="6" type="date" :value="$leaveCard ?? null"/>
        <x-forms.input label="Credits" name="credits" cols="6" type="number" step="0.001" :value="$leaveCard ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Remarks" name="remarks" cols="12" :value="$leaveCard ?? null"/>
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
                    activeLeaveCredits = res.slug;
                    leaveCreditsTbl.draw(false);
                    toast('info','Leave credit successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection