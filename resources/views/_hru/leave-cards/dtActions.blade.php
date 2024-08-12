<div class="btn-group btn-sm">
    <a href="{{route('dashboard.leave_card.show',$data->slug)}}" class="btn btn-outline-secondary btn-sm view_document_btn">
        <i class="fa fa-file-text"></i>
    </a>

    <a data-bs-toggle="modal" data-bs-target="#edit-leave-card-modal" type="button" data="{{$data->slug}}" class="visually-hidden btn btn-outline-secondary btn-sm edit-leave-card-btn" >
        <i class="fa fa-edit"></i>
    </a>

    <button href="{{route('dashboard.leave_card.print',$data->slug )}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog" >
        <i class="fa fa-print"></i>
    </button>


    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_card.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>

</div>