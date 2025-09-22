@switch($data->status)
    @case('ON PROCESS')
        <span class="badge bg-warning" style="width: 100%;">{{$data->status}}</span>
        @break
    @case('FOR SIGNATURE')
        <span class="badge bg-info" style="width: 100%;">{{$data->status}}</span>
        @break
    @case('REQUEST SUBMITTED')
        <span class="badge bg-primary" style="width: 100%;">{{$data->status}}</span>
        @break
    @case('READY FOR PICK-UP')
        <span class="badge bg-success" style="width: 100%;">{{$data->status}}</span>
        @break
    @default()
        <span class="badge bg-secondary" style="width: 100%;">{{$data->status}}</span>
        @break
@endswitch