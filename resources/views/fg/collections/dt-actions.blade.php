<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-collection-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-collection-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <a href="{{route('collections.edit',$data->uuid)}}" for="linkToEdit" type="button"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-collection-btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("collections.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>