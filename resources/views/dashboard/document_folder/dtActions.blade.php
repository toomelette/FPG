<div class="btn-group pull-right">


    <a href="{{route('dashboard.document_folder.browse',$data->folder_code)}}" type="button" data="{{$data->slug}}" class="btn btn-default btn-sm"  title="Edit" data-placement="top">
        <i class="fa fa-folder-open"></i>
    </a>
    @if(($data->documents1_count + $data->documents2_count > 0) )
    <a href="{{route('dashboard.document_folder.download',$data->folder_code)}}" type="button" data="{{$data->slug}}" class="btn btn-default btn-sm"  title="Edit" data-placement="top">
        <i class="fa fa-download"></i>
    </a>
    @else
    <button type="button" class="btn btn-default btn-sm"  title="Edit" data-placement="top" disabled>
        <i class="fa fa-download"></i>
    </button>
    @endif
    <button href="{{route('dashboard.leave_application.print',$data->slug )}}"  type="button"  class="btn btn-default btn-sm print-btn-dialog"  title="Print" data-placement="top">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.leave_application.destroy","slug")}}')" class="btn btn-sm btn-danger delete_jo_employee_btn" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>

</div>