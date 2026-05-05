<div class="btn-group btn-group-sm">

    <button data-bs-toggle="modal" data-bs-target="#edit-account-modal" for="linkToEdit" type="button"
            data="{{$data->id}}" class="btn btn-outline-secondary btn-sm edit-account-btn">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->id}}"
            onclick="delete_data('{{$data->id}}','{{route("subsidiary-accounts.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>