<strong>{{$data->nature_of_request}}</strong>
@if($data->completed_at != null)
    <span class="text-success float-end"><i class="fa  fa-check-circle"></i></span>
@endif
@if($data->request_details != '')
    <div class="subdetail">
        {{$data->request_details}}
    </div>
@endif