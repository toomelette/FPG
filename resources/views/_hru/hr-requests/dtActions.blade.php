<div class="btn-group btn-sm">
    <a href="{{route('dashboard.hr_requests.create_document',$data->slug)}}" type="button" data-bs="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-file-text"></i> Create Doc
    </a>

    <a href="{{route('dashboard.hr_requests.edit',$data->slug)}}" type="button" data-bs="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-edit"></i>
    </a>

    <button href="{{route('dashboard.hr_requests.print',$data->slug )}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>


    <button type="button" data-bs="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.hr_requests.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>

</div>