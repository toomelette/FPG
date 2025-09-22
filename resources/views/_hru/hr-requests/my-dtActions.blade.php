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