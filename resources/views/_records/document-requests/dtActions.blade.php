<div class="btn-group btn-group-sm">
    <button data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#edit-document-request-modal"  type="button"  class="btn btn-outline-secondary btn-sm edit-document-request-btn" >
        <i class="fa fa-edit"></i>
    </button>
    <a href="{{route('dashboard.document_request.print',$data->slug)}}" target="_blank" data="{{$data->slug}}"   type="button"  class="btn btn-outline-secondary btn-sm" >
        <i class="fa fa-print"></i>
    </a>
    <button type="button" data="{{$data->slug}}" onclick="delete_data('{{$data->slug}}','{{route("dashboard.document_request.destroy","slug")}}')" class="btn btn-sm btn-danger" data-toggle="tooltip" >
        <i class="fa fa-trash"></i>
    </button>
    <div class="btn-group btn-group-sm" role="group">
        <button id="" type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
        <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
            <li class="dropdown-item edit-signatories-btn" data="{{$data->slug}}" data-bs-toggle="modal" data-bs-target="#edit-signatories-modal">
                <i class="fa fa-file-signature"></i> Edit Signatories
            </li>
        </ul>
    </div>
</div>