<div class="btn-group btn-group-sm">
    <button data-bs-target="#edit-applicant-modal" data-bs-toggle="modal"   for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-applicant-btn"  >
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route('dashboard.applicant.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn">
        <i class="fa fa-trash"></i>
    </button>

</div>