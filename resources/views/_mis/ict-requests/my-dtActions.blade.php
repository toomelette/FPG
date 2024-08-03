@if($data->cancelled_at != null)
    <p class="text-muted no-margin">Cancelled</p>
@else
<div class="btn-group" style="width: 100%;">
    <button style="width: 50%" class="btn btn-outline-secondary btn-sm status-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#status-modal"><i class="fa fa-refresh"></i> Status</button>
    <button style="width: 50%" class="btn btn-outline-secondary btn-sm print-btn-dialog" href="{{route('dashboard.mis_requests.print_request_form',$data->slug)}}" data="{{$data->slug}}" text="Request no: <b>'.$data->request_no.'</b>"><i class="fa fa-print"></i> Print</button>
</div>
@endif