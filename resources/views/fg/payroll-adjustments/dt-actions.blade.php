<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-adjustment-btn" data="{{$adjustment->id}}"
            data-toggle="modal" data-target="#show-adjustment-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button data-bs-toggle="modal" data-bs-target="#edit-adjustment-modal" for="linkToEdit" type="button"
            data="{{$adjustment->id}}" class="btn btn-outline-secondary btn-sm edit-adjustment-btn">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$adjustment->id}}"
            onclick="delete_data('{{$adjustment->id}}','{{route("payroll-adjustments.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>