<div class="btn-group btn-group-sm">

    <button  data-bs-toggle="modal" data-bs-target="#edit-course-modal" for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-course-btn" >
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.course.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip">
        <i class="fa fa-trash"></i>
    </button>

</div>