<div class="btn-group btn-group-sm float-end">
    @if($data->type == 'DIFF')
        <button type="button" class="btn btn-outline-secondary btn-sm clone-payroll-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target ="#clone-payroll-modal">
            <i class="fa fa-clone"></i>
        </button>
    @endif

    <a href="{{route('dashboard.payroll_preparation.edit',$data->slug)}}" type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-edit"></i>
    </a>


    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.payroll_preparation.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" >
        <i class="fa fa-trash"></i>
    </button>

</div>