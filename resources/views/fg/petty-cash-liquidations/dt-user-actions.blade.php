@if($data->status == null)
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-outline-secondary btn-sm view-petty-cash-liquidations-btn"
                data="{{$data->uuid}}" data-toggle="modal" data-target="#show-petty-cash-liquidations-modal">
            <i class="fa fa-file-text"></i>
        </button>
        <button data-bs-toggle="modal" data-bs-target="#edit-petty-cash-liquidations-modal" for="linkToEdit" type="button"
                data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-petty-cash-liquidations-btn">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button" data="{{$data->uuid}}"
                onclick="delete_data('{{$data->uuid}}','{{route("petty-cash-liquidations.destroy","slug")}}')"
                class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
            <i class="fa fa-trash"></i>
        </button>
    </div>
@endif