<div class="btn-group btn-group-xs" role="toolbar" aria-label="...">
    <button type="button" class="btn btn-sm btn-outline-secondary edit-training-btn" data-bs-toggle="modal" data-bs-target="#edit-training-modal" data="{{$data->slug}}"><i class="fa fa-edit"></i></button>
    <button data="{{$data->slug}}" type="button" onclick="delete_data('{{$data->slug}}','{{route('dashboard.employee.training','slug')}}')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
</div>