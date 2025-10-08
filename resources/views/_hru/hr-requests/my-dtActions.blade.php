@if(Str::of($data->document)->contains('Contract of Service') && $data->status == 'APPROVED')
    <div class="btn-group btn-sm float-end">
        <button data-bs-target="#download-cos-modal" data-bs-toggle="modal" type="button" data="{{$data->slug}}" class="btn btn-info btn-sm download-cos-btn" >
            <i class="fa fa-download"></i> Download COS
        </button>
    </div>
@else
    <div class="btn-group btn-sm float-end">
        @if(!empty($data->file_path))
            <a href="{{route('dashboard.hr_requests.file',$data->slug)}}?view" type="button" data="{{$data->slug}}" class="btn btn-success btn-sm"  target="_blank">
                <i class="fa fa-file-pdf"></i> View File
            </a>
        @endif

        <button type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm show-timeline-btn" data-bs-target="#show-timeline-modal" data-bs-toggle="modal" >
            <i class="fa fa-refresh"></i> Status
        </button>
    </div>
@endif

