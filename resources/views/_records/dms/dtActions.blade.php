<button  data-bs-toggle="modal" data-bs-target="#add-document-modal" for="linkToEdit" type="button" data="{{$data->slug}}" class="btn btn-outline-primary btn-sm add-document-btn" >
    <i class="fa fa-plus"></i>
</button>
<button type="button" data="{{$data->slug}}" class="btn btn-sm btn-danger" onclick="delete_data('{{$data->slug}}','{{route('dashboard.dms_document.destroy',$data->slug)}}')" data-toggle="tooltip" title="Delete Permanently" data-placement="top">
    <i class="fa fa-trash"></i>
</button>