<div class="btn-group btn-group-sm">
    <a href="{{route('sales-invoice.show',$data->uuid)}}" type="button" class="btn btn-outline-secondary btn-sm view-sales-invoice-btn" data="{{$data->uuid}}">
        <i class="fa fa-file-text"></i>
    </a>
    <a href="{{route('sales-invoice.edit',$data->uuid)}}" for="linkToEdit" type="button"
            class="btn btn-outline-secondary btn-sm ">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("sales-invoice.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>