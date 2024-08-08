<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_user_btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#view_user_modal" >
        <i class="fa fa-file-text"></i>
    </button>

    <a href="{{route('dashboard.user.edit',$data->slug)}}" class="btn btn-outline-secondary btn-sm edit_user_btn" data-toggle="modal" data-target="#edit_user_modal">
        <i class="fa fa-key"></i>
    </a>
    <button type="button" data="'.$data->slug.'" class="btn btn-sm btn-danger delete_user_btn" onclick="delete_data('{{$data->slug}}','{{route('dashboard.user.destroy','slug')}}')" data="{{$data->slug}}" >
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li class="dropdown-item service_records_btn ac_dc"
                user="{{ucwords(strtolower($data->firstname))}}"
                data="{{$data->slug}}"
                name="{{strtoupper($data->firstname)}} {{strtoupper($data->lastname)}}"
                status="{{$data->is_activated ? 'inactive' : 'active'}}"
            >
                {{$data->is_activated ? 'Activate' : 'Deactivate'}}
            </li>
            <li class="dropdown-item service_records_btn reset_password_btn"
                data="{{$data->slug}}"
                fullname="{{strtoupper($data->firstname)}} {{strtoupper($data->lastname)}}"
            >
                Reset Password
            </li>
        </ul>
    </div>
</div>