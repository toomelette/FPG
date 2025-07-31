@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'update-status-form-'.$rand,
    'slug' => $hrRequest->slug,
])

@section('modal-header')
    Update Status | <small>{{$hrRequest->tracking_no}}</small>
@endsection

@section('modal-body')
    <div class="row">
        <div class="col-md-8">
            @include('_hru.hr-requests.portion-timeline')
        </div>
        <div class="col-md-4">
            <div class="row">
                <x-forms.select :options="\App\Swep\Helpers\Arrays::db('hr_request_status')" label="Status" name="status" cols="12"/>
            </div>
            <button class="btn btn-sm btn-primary float-end mt-2" type="submit"><i class="fas fa-check"></i> Save</button>
        </div>
    </div>

@endsection

@section('modal-footer')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#update-status-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.hr_requests.update","slug")}}';
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
                    requestsTbl.draw(false);
                    toast('info','Status successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection