@if($document != null && $storage->exists($document->path.$document->filename))
    <a href="{{route("dashboard.document.view_file", $document->slug)}}" class="btn btn btn-{{($document->folder->is_permanent ?? false) || ($document->folder2->is_permanent ?? false) ? 'danger' :'success'}}" target="_blank">
        <i class="fa fa-file-pdf"></i>
    </a>
@else
    <button class="btn btn btn-warning" title="File not found" disabled><i class="fa fa-exclamation-circle text-black" ></i></button>
@endif