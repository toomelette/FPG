<div class="btn-group btn-group-sm">
    <a href="{{route('subsidiary-accounts.index',$data->id)}}" type="button" class="btn btn-outline-secondary btn-sm view-account-btn">
        <i class="fa fa-file-text"></i>
    </a>
    <button data-bs-toggle="modal" data-bs-target="#edit-account-modal" for="linkToEdit" type="button"
            data="{{$data->id}}" class="btn btn-outline-secondary btn-sm edit-account-btn">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->id}}"
            onclick="delete_data('{{$data->id}}','{{route("chart-of-accounts.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>