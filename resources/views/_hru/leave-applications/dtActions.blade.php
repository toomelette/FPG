<div class="btn-group btn-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_document_btn" data-bs="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#show_document_modal" >
        <i class="fa fa-file-text"></i>
    </button>

    <a href="{{route('dashboard.leave_application.edit',$data->slug)}}" type="button" data-bs="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-edit"></i>
    </a>

    <button href="{{route('dashboard.leave_application.print',$data->slug )}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>


    <button type="button" data-bs="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_application.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>

</div>