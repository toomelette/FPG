<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view-project-expense-liquidation-btn" data="{{$data->uuid}}" data-toggle="modal"
            data-target="#show--modal">
        <i class="fa fa-file-text"></i>
    </button>
    <a href="{{route("project-expense-liquidation.edit",$data->uuid)}}" target="_blank"
            class="btn btn-outline-secondary btn-sm edit-project-expense-liquidation-btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}"
            onclick="delete_data('{{$data->uuid}}','{{route("project-expense-liquidation.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>