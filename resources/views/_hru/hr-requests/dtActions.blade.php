@if(!Str::of($data->document)->contains('Contract of Service'))
    <div class="btn-group btn-sm float-end">
        <a href="{{route('dashboard.hr_requests.create_document',$data->slug)}}" type="button" data-bs="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
            <i class="fa fa-file-text"></i> {{empty($data->document_fields) ? 'Create' : 'Edit'}} Doc
        </a>

        @if(!empty($data->document_fields))
            <button href="{{route('dashboard.hr_requests.print',$data->slug )}}?autoPrint=true"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
                <i class="fa fa-print"></i>
            </button>
        @else
        @endif

        @if(!empty($data->file_path))
            <a href="{{route('dashboard.hr_requests.file',$data->slug )}}?view"  target="_blank"  class="btn btn-success btn-sm"  >
                <i class="fa fa-file-pdf"></i>
            </a>
        @else
        @endif

        <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.hr_requests.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" >
            <i class="fa fa-trash"></i>
        </button>
        <div class="btn-group btn-group-sm" role="group">
            <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <li href="{{route("dashboard.hr_requests.print_request",$data->slug)}}" class="dropdown-item print-btn-dialog" data="{{$data->slug}}">
                    <i class="fa fa-print"></i> Print Request Form
                </li>
                <li class="dropdown-item update-status-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#update-status-modal">
                    <i class="fa fa-refresh"></i> Update Status
                </li>
                <li class="dropdown-item upload-file-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#upload-file-modal">
                    <i class="fa fa-upload"></i> Upload File
                </li>
            </ul>
        </div>
    </div>
@else
    <div class="btn-group btn-sm float-end">
        <button type="button"  class="btn btn-sm btn-outline-success approve-btn" data="{{$data->slug}}" data-bs-target="#cos-action-modal"  data-bs-toggle="modal" >
            <i class="fa fa-thumbs-up"></i> Approve
        </button>
        <button type="button"  class="btn btn-sm btn-outline-danger disapprove-btn" value="0" data="{{$data->slug}}" data-bs-toggle="tooltip" >
            <i class="fa fa-thumbs-down"></i> Disapprove
        </button>
    </div>
@endif