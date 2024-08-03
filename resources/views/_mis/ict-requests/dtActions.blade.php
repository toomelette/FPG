<div class="btn-group btn-group-sm">
    <button class="btn btn-outline-secondary btn-sm print-btn-dialog" href="{{route('dashboard.mis_requests.print_request_form',$data->slug)}}" data="{{$data->slug}}" text="Request no: <b>{{$data->request_no}}</b>"><i class="fa fa-print"></i></button>
    <button class="btn btn-outline-secondary btn-sm status-btn" data="{{$data->slug}}" text="Request no: <b>{{$data->request_no}}</b>" data-bs-target="#status-modal" data-bs-toggle="modal" title="Status" data-placement="top" ><i class="fa fa-refresh"></i></button>
    <button class="btn btn-outline-secondary btn-sm edit-request-btn" data="{{$data->slug}}" data-bs-target="#edit-request-modal" data-bs-toggle="modal" ><i class="fa fa-edit"></i></button>

    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li><a href="#" default_text="{{$data->recommendations}}" class="update-status-btn dropdown-item" data="{{$data->slug}}" request_no="{{$data->request_no}}">Update Status</a></li>
            <li><a href="#" class="mark-as-done-btn dropdown-item" data="{{$data->slug}}" request_no="{{$data->request_no}}">Mark as completed</a></li>
        </ul>
    </div>

</div>