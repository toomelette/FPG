<div class="btn-group btn-group-sm">
    <button type="button" uri="{{route('dashboard.plantilla.show',$data->id)}}" class="btn btn-outline-secondary btn-sm show_item_btn"  data-bs-toggle="modal" data-bs-target ="#show-plantilla-modal">
        <i class="fa fa-file-text"></i>
    </button>
    <button type="button" uri="{{route('dashboard.plantilla.edit',$data->id)}}" class="btn btn-outline-secondary edit-plantilla-btn" data-bs-toggle="modal" data-bs-target="#edit-plantilla-modal">
        <i class="fa fa-edit"></i>
    </button>

</div>