{{$misRequest->request_details}}
<hr style="border-color: #b5b0ce; margin-top: 10px">
<small>{{$misRequest->dept->descriptive_name ?? ''}}</small>

<div class="text-right">
    <a href="{{route('dashboard.mis_requests.index')}}" target="_blank"><small>Click here for details</small></a>
</div>