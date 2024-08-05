<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view_document_btn" data="{{$data->slug}}" data-toggle="modal" data-target ="#show_document_modal">
        <i class="fa fa-file-text"></i>
    </button>

    <a href="{{route('dashboard.payroll_preparation.edit',$data->slug)}}" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-edit"></i>
    </a>


    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.payroll_preparation.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" >
        <i class="fa fa-trash"></i>
    </button>

</div>