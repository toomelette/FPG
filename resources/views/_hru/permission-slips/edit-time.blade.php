@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-time-form-'.$rand,
    'slug' => $ps->slug,
])

@section('modal-header')
    {{$ps->ps_no}} | <small>Edit Departure & Return Time</small>
@endsection

@section('modal-body')
    <h6 class="mb-1">Employee:</h6>
    <p class="text-muted">{{$ps->employee_name}}</p>
    <h6 class="mb-1">Purpose:</h6>
    <p class="text-muted">{{$ps->purpose}}</p>
    <h6 class="mb-1">Destination:</h6>
    <p class="text-muted">{{$ps->destination}}</p>

    <div class="row">
        <x-forms.input label="Departure" type="time" name="departure" cols="6" :value="Helper::dateFormat($ps->departure,'H:i')"/>
        <x-forms.input label="Return" type="time" name="return" cols="6" :value="Helper::dateFormat($ps->return,'H:i')"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-time-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.permission_slip.update_time","slug")}}';
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
                    psTbl.draw(false);
                    toast('info','PS successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection