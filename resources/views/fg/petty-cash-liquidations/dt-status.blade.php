@if($data->status == 'APPROVED')
    <span class="badge bg-success">{{$data->status}}</span>
    <hr class="mt-1 mb-1">
    {{Helper::toNumber($data->approved_amount)}} | <small>CV#: {{$data->cv_no}}</small>
@elseif($data->status == 'DISAPPROVED')
    <span class="badge bg-danger">{{$data->status}}</span>
@endif