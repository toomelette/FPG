<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-delivery-receipt-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-delivery-receipt-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button href="{{route('delivery-receipts.print',$data->uuid)}}" for="linkToEdit" type="button"
            class="btn btn-outline-secondary btn-sm print-btn-dialog">
        <i class="fa fa-print"></i>
    </button>
    <a href="{{route('delivery-receipts.edit',$data->uuid)}}"
       class="btn btn-outline-secondary btn-sm edit-delivery-receipt-btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("delivery-receipts.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>