<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm show-users-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#show-users-modal" title="View more" data-placement="left">
        <i class="fa fa-file-text"></i>
    </button>

    <button  href="{{route('dashboard.submenu.edit', $data->slug)}}"  type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-submenu-btn" data-bs-target="#edit-submenu-modal" data-bs-toggle="modal">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route('dashboard.submenu.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

</div>