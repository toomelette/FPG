<div class="btn-group btn-group-sm" style="width: 100%;">
    <a  type="button" href="{{route('costing.edit',$data->uuid)}}"
            data="{{$data->uuid}}" class="btn btn-outline-secondary btn-sm edit-costing-btn">
        <i class="fa fa-edit"></i>
        Edit
    </a>
    <button type="button" data="{{$data->uuid}}" onclick="delete_data('{{$data->uuid}}','{{route("costing.destroy","slug")}}')"
            class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>