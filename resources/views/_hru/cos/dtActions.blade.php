<div class="btn-group btn-group-sm">
    <a href="{{route('dashboard.cos_employees.index',$data->slug)}}" class="btn btn-outline-secondary btn-sm edit-applicant-btn"  >
        <i class="fa fa-users"></i>
    </a>
    <button data-bs-target="#edit-cos-modal" data-bs-toggle="modal"  type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-cos-btn"  >
        <i class="fa fa-edit"></i>
    </button>

    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route('dashboard.cos.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn">
        <i class="fa fa-trash"></i>
    </button>

</div>