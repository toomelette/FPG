<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-cash-advance-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-cash-advance-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button href="{{route('cash-advances.print',$data->uuid)}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>
    @if(blank($data->amount_approved))
        <button data-bs-toggle="modal" data-bs-target="#edit-cash-advance-modal" for="linkToEdit" type="button"
                data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-cash-advance-btn">
            <i class="fa fa-edit"></i>
        </button>
        <button type="button" data="{{$data->uuid}}"
                onclick="delete_data('{{$data->uuid}}','{{route("cash-advances.destroy","slug")}}')"
                class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
            <i class="fa fa-trash"></i>
        </button>
    @endif
</div>