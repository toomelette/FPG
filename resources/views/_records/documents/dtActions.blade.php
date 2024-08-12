<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_document_btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#show_document_modal">
        <i class="fa fa-file-text"></i>
    </button>

    <button  data-bs-toggle="modal" data-bs-target="#edit-document-modal" for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-document-btn" >
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data_secure('{{$data->slug}}','{{route("dashboard.document.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip">
        <i class="fa fa-trash"></i>
    </button>

    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <li onclick="window.open('{{route('dashboard.document.dissemination', $data->slug)}}','_self')" class="dropdown-item">
                <i class="fa fa-envelope"></i> Disseminate
            </li>
            <li onclick="window.open('{{route('dashboard.document.dissemination', $data->slug)}}?send_copy=1','_self')" class="dropdown-item">
                <i class="fa fa-envelope"></i> Send Copy
            </li>

            <li class="dropdown-item print-qr-btn" data="{{$data->slug}}">
                <i class="fa fa-qrcode"></i> Print QR
            </li>
            <li class="dropdown-item outgoing_tag_btn" data="{{$data->slug}}">
                <i class="fa fa-qrcode"></i> Outgoing Tag
            </li>
        </ul>
    </div>
</div>