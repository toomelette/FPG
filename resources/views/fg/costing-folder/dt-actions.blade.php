<div class="btn-group btn-group-sm">
{{--    <a href="{{route('costing-folder.show',$data->uuid)}}" type="button" class="btn btn-outline-secondary btn-sm view-client-btn" data="{{$data->uuid}}">--}}
{{--        <i class="fa fa-file-text"></i>--}}
{{--    </a>--}}
    <a href="{{route('costing-folder.children',$data->uuid)}}" type="button" class="btn btn-outline-secondary btn-sm view-client-btn" data="{{$data->uuid}}">
        <i class="fa fa-folder-tree"></i>
    </a>
    <button  data-bs-toggle="modal" data-bs-target="#edit-folder-modal" for="linkToEdit" type="button" data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-folder-btn" >
        <i class="fa fa-edit"></i>
    </button>
     <button type="button" data="{{$data->uuid}}" onclick="delete_data('{{$data->uuid}}','{{route("costing-folder.destroy","slug")}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>