<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_employee_btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#show_employee_modal" title="View more" data-placement="left">
        <i class="fa fa-file-text"></i>
    </button>

    <a  href="{{route('dashboard.employee.edit', $data->slug)}}" for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_jo_employee_btn"  title="Edit" data-placement="top">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->slug}}" onclick="delete_data_secure('{{$data->slug}}','{{route('dashboard.employee.destroy','slug')}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-bs-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li onclick="window.open('{{route("dashboard.employee.service_record",$data->slug)}}')" class="dropdown-item service_records_btn" data="{{$data->slug}}">
                <i class="fa icon-service-record"></i> Service Records
            </li>
            <li onclick="window.open('{{route("dashboard.employee.training",$data->slug)}}')" class="dropdown-item service_records_btn" data="{{$data->slug}}">
                <i class="fa icon-seminar"></i> Trainings
            </li>

            <li onclick="window.open('{{route("dashboard.employee.education",$data->slug)}}')" class="dropdown-item service_records_btn" data="{{$data->slug}}">
                <i class="fa swep-certificate"></i> Credentials
            </li>

            <li class="dropdown-item matrix_btn" data-bs-toggle="modal" data-bs-target="#matrix_modal" data="{{$data->slug}}">
                <i class="fa fa-dashboard"></i> Matrix
            </li>
            <li onclick="window.open('{{route("dashboard.employee.201",$data->slug)}}')" class="dropdown-item" data="{{$data->slug}}">
                <i class="fa fa-folder"></i> 201 File
            </li>
            <li class="dropdown-item bm_uid_btn" employee="{{$data->lastname}}, {{$data->firstname}}"  data="{{$data->slug}}" bm_uid="{{$data->biometric_user_id}}">
                <i class="fa icon-ico-fingerprint"></i> Biometric User ID
            </li>

            <li onclick="window.open('{{route("dashboard.employee.other_hr_actions",$data->slug)}}')" class="dropdown-item" data="{{$data->slug}}">
                <i class="fa icon-service-record"></i> Other HR Actions
            </li>
            <li class="dropdown-item other_actions_btn" target="_blank" href="{{route('dashboard.employee.generate_qr',$data->slug)}}" data="{{$data->slug}}">
                <i class="fa fa-qrcode"></i> Get QR Code
            </li>
        </ul>
    </div>


</div>