<div class="btn-group btn-group-sm">
    <button href="{{route('dashboard.leave_card.edit',$data->slug )}}" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#edit-leave-credit-modal"  type="button"  class="btn btn-outline-secondary btn-sm edit-leave-credit-btn" >
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_card.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>
</div>