
<p > {{$misRequest->requisitioner}} </p>
<hr style="border-color: #b5b0ce;">
<small>{{$misRequest->dept->descriptive_name ?? ''}}</small>

<p style="padding-top: 10px">{{$misRequest->request_details}}</p>


<div class="text-right">
    <a href="{{route('dashboard.mis_requests.index')}}" target="_blank"><small>Click here for details</small></a>
</div>