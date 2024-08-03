<strong>{{$data->leave_type}}</strong>
@if($data->leave_details != null)
    <div class="subdetail" style="margin-top: 3px">
        <span class="text-info">{{$data->leave_details}}</span>
        @if($data->leave_specify != null)
            , {{$data->leave_specify}}
        @endif
    </div>
@endif