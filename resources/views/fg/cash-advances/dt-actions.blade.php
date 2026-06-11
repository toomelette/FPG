<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-cash-advance-btn" data="{{$data->uuid}}"
            data-toggle="modal" data-target="#show-cash-advance-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button href="{{route('cash-advances.print',$data->uuid)}}"  type="button"  class="btn btn-outline-secondary btn-sm print-btn-dialog"  >
        <i class="fa fa-print"></i>
    </button>
    <button data-bs-toggle="modal" data-bs-target="#make-action-cash-advance-modal" for="linkToEdit" type="button"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm make-action-cash-advance-btn">
        <i class="fa fa-arrow-right"></i>
    </button>

</div>