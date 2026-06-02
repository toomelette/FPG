<div class="btn-group btn-group-sm">
    <a href="{{route('stocks.show',$data->uuid)}}" type="button" class="btn btn-outline-secondary btn-sm view-stock-btn">
        <i class="fa fa-file-text"></i>
    </a>
    <button data-bs-toggle="modal" data-bs-target="#edit-stock-modal" for="linkToEdit" type="button"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-stock-btn">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("stocks.destroy","slug")}}')" class="btn btn-sm btn-danger"
            data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>