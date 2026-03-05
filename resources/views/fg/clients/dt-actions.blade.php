<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-client-btn" data="{{$data->uuid}}" data-toggle="modal" data-target ="#show-client-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button  data-bs-toggle="modal" data-bs-target="#edit-client-modal" for="linkToEdit" type="button" data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-client-btn" >
        <i class="fa fa-edit"></i>
    </button>
     <button type="button" data="{{$data->uuid}}" onclick="delete_data('{{$data->uuid}}','{{route("clients.destroy","slug")}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>