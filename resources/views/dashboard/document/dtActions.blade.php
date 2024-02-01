<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm view_document_btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#show_document_modal" title="View more" data-placement="left">
        <i class="fa fa-file-text"></i>
    </button>

    <button  data-toggle="modal" data-target="#edit_document_modal" for="linkToEdit" type="button" data="'.$data->slug.'" class="btn btn-default btn-sm edit_document_btn"  title="Edit" data-placement="top">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.document.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right">
            <li><a href="{{route('dashboard.document.dissemination', $data->slug)}}" target="_blank" class="service_records_btn" data="{{$data->slug}}"><i class="fa fa-envelope-o"></i> Disseminate</a></li>
            <li><a href="{{route('dashboard.document.dissemination', $data->slug)}}?send_copy=1" target="_blank" class="trainings_btn" data="{{$data->slug}}"><i class="fa fa-envelope"></i> Send Copy</a></li>
            <li><a href="#" data-toggle="modal" data-target="#matrix_modal" class="print_qr_btn" data="{{$data->slug}}"><i class="fa fa-qrcode"></i>Print QR</a></li>

            <li><a href="#" data-toggle="modal" data-target="#matrix_modal" class="outgoing_tag_btn" data="{{$data->slug}}"><i class="fa fa-qrcode"></i>Outgoing Tag</a></li>

        </ul>
    </div>
</div>