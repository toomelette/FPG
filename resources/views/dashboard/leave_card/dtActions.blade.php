<div class="btn-group">
    <button type="button" class="btn btn-default btn-sm view_document_btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#show_document_modal" title="View more" data-placement="left">
        <i class="fa fa-file-text"></i>
    </button>

    <a data-toggle="modal" data-target="#edit_leave_card_modal" type="button" data="{{$data->slug}}" class="btn btn-default btn-sm edit_leave_card_btn"  title="Edit" data-placement="top">
        <i class="fa fa-edit"></i>
    </a>

    <button href="{{route('dashboard.leave_card.print',$data->slug )}}"  type="button"  class="btn btn-default btn-sm print-btn-dialog"  title="Print" data-placement="top">
        <i class="fa fa-print"></i>
    </button>


    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_card.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

</div>