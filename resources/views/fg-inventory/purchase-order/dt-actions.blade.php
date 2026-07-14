<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-purchase-order-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-purchase-order-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button href="{{route('purchase-orders.print',$data->uuid)}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>

    <a href="{{route('purchase-orders.edit',$data->uuid)}}"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-purchase-order-btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("purchase-orders.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>