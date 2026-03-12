<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-outline-secondary btn-sm view--btn" data="{{$data->uuid}}" data-toggle="modal"
            data-target="#show--modal">
        <i class="fa fa-file-text"></i>
    </button>
    <a href="{{route('payroll-preparation.edit',$data->uuid)}}" data="{{$data->uuid}}"
            class="btn btn-outline-secondary btn-sm edit--btn">
        <i class="fa fa-edit"></i>
    </a>
    <button type="button" data="{{$data->uuid}}" onclick="delete_data('{{$data->uuid}}','{{route("payroll-preparation.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>