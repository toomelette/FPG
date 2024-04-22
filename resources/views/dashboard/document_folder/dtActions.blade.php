<div class="btn-group">


    <a href="{{route('dashboard.document_folder.browse',$data->slug)}}" type="button" data="{{$data->slug}}" class="btn btn-default btn-sm"  title="Edit" data-placement="top">
        <i class="fa fa-folder-open"></i>
    </a>

    <a href="{{route('dashboard.document_folder.download',$data->slug)}}" type="button" data="{{$data->slug}}" class="btn btn-default btn-sm"  title="Edit" data-placement="top">
        <i class="fa fa-download"></i>
    </a>
    <button href="{{route('dashboard.leave_application.print',$data->slug )}}"  type="button"  class="btn btn-default btn-sm print-btn-dialog"  title="Print" data-placement="top">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_application.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

</div>