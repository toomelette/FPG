<div class="btn-group btn-group-sm">
    <a href="{{route('dashboard.email_contact.show',$data->slug)}}" class="btn btn-outline-secondary btn-sm show-contact-btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#show-contact-modal">
        <i class="fa fa-file-text"></i>
    </a>

    <button  data-bs-toggle="modal" data-bs-target="#edit-contact-modal" for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-contact-btn" >
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.email_contact.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip">
        <i class="fa fa-trash"></i>
    </button>

</div>