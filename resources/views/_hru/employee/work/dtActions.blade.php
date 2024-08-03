<div class="btn-group btn-group-xs">
    <button data-bs-toggle="modal" data-bs-target="#edit-work-modal"  type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-work-btn"  title="Edit" data-placement="top">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}"  onclick="delete_data('{{$data->slug}}','{{route('dashboard.employee.work','slug')}}')" class="btn btn-sm btn-danger " data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>