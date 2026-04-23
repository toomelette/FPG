<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-inventory-transfers-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-inventory-transfers-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <a href="{{route('inventory-transfers.edit',$data->uuid)}}"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-inventory-transfers-btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("inventory-transfers.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>