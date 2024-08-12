<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_employee_btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#show_employee_modal" title="View more" data-placement="left">
        <i class="fa fa-file-text"></i>
    </button>

    <button  href="{{route('dashboard.menu.edit', $data->slug)}}"  type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-menu-btn" data-bs-target="#edit-menu-modal" data-bs-toggle="modal">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route('dashboard.menu.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li onclick="window.open('{{route("dashboard.submenu.index",$data->slug)}}')" class="dropdown-item service_records_btn" data="{{$data->slug}}">
                Submenus
            </li>
        </ul>
    </div>


</div>