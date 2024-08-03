<div class="btn-group btn-group-sm">
    <button type="button" data="{{$data->slug}}" class="btn btn-outline-secondary btn-sm edit-holiday-btn" data-bs-toggle="modal" data-bs-target="#edit-holiday-modal" title="" data-placement="top" data-original-title="Edit">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" onclick="delete_data('{{$data->slug}}','{{route('dashboard.holidays.destroy','slug')}}')" data="{{$data->slug}}" class="btn btn-sm btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
        <i class="fa fa-trash"></i>
    </button>
</div>