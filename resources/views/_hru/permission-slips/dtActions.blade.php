<div class="btn-group btn-sm">
    <a href="{{route('dashboard.permission_slip.edit',$data->slug)}}" type="button" data-bs="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit_document_btn"  >
        <i class="fa fa-edit"></i>
    </a>
    <button href="{{route('dashboard.permission_slip.print',$data->slug )}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.permission_slip.destroy","slug")}}')" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>
</div>