<div class="btn-group btn-group-xs" role="toolbar" aria-label="...">
    <button type="button" class="btn btn-outline-secondary edit-sr-btn btn-sm" data-bs-toggle="modal" data-bs-target="#edit-sr-modal" data="{{$data->slug}}"><i class="fa fa-edit"></i></button>
    <button data="{{$data->slug}}" type="button" onclick="delete_data('{{$data->slug}}','{{route('dashboard.employee.service_record',$data->slug)}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
</div>