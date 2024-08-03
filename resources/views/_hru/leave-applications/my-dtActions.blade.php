<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-leave-application-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#view-leave-application-modal">
        <i class="fa fa-file-text"></i>
    </button>

    <a href="{{route('dashboard.leave_application.edit',$data->slug)}}" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-edit"></i>
    </a>

    <button href="{{route('dashboard.leave_application.print',$data->slug )}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog" >
        <i class="fa fa-print"></i>
    </button>


    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_application.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn">
        <i class="fa fa-trash"></i>
    </button>

</div>