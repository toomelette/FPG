<div class="btn-group btn-group-xs">
    <button data-bs-toggle="modal" data-bs-target="#edit-education-modal"  type="button" data="{{$data->slug}}" class="btn btn-sm btn-outline-secondary edit-education-btn"  title="Edit" data-placement="top">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" data="{{$data->slug}}"  onclick="delete_data('{{$data->slug}}','{{route('dashboard.employee.education','slug')}}')" class="btn btn-sm btn-danger " data-toggle="tooltip" title="Delete" data-placement="top">
        <i class="fa fa-trash"></i>
    </button>
</div>