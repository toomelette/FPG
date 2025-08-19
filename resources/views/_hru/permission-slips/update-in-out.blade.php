@php
$rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-update-form-'.$rand,
    'slug' => $ps->slug,
])

@section('modal-header')
    {{$ps->ps_no}} <small>Update time</small>
@endsection

@section('modal-body')
    <dl class="dl-horizontal" style="">
        <dt>Name:</dt>
        <dd>{{$ps->employee_name}}</dd>

        <dt>Purpose:</dt>
        <dd>{{$ps->purpose}}</dd>
    </dl>
    <div class="text-center">
        <button class="btn btn-outline-success action-btn-{{$rand}}" data="departure" type="button" style="width: 20%">OUT</button>
        <button class="btn btn-outline-primary action-btn-{{$rand}}" data="return" type="button" style="width: 20%">IN</button>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" id="close-{{$rand}}" type="button" data-bs-dismiss="modal">Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".action-btn-{{$rand}}").click(function (){
            $.ajax({
                url : '{{route("dashboard.permission_slip.update-time-via-scan",$ps->slug)}}',
                data : {
                    slug: '{{$ps->slug}}',
                    type: $(this).attr('data'),
                },
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#close-{{$rand}}").trigger('click');
                    Swal.fire({
                        title: "PS updated successfully.",
                        icon: "success"
                    });
                },
                error: function (res) {
             
                }
            })
        });
    </script>
@endsection