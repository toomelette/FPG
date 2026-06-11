<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-journal-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-journal-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <a href="{{route('cash-disbursements.edit',$data->uuid)}}"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-journal-btn">
        <i class="fa fa-edit"></i>
    </a>


    <button href="{{route('cash-disbursements.print',$data->uuid)}}?print-voucher"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>
    <button href="{{route('cash-disbursements.print',$data->uuid)}}?print-check"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-money-check"></i>
    </button>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("cash-disbursements.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>