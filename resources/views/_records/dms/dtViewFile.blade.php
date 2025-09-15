<div class="dropdown">
    <button class="btn btn-success dropdown-toggle" type="button" id="documentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-file-pdf"></i>
    </button>
    <ul class="dropdown-menu" aria-labelledby="documentDropdown"
        style="min-width: 100%; width: auto; max-height: 250px; overflow-y: auto;">

        {{-- Main documents --}}
        @foreach($data as $doc)
            <li>
                <a class="dropdown-item text-truncate"
                   href="{{ route('dashboard.dms_document.show', $doc->slug) }}"
                   target="_blank"
                   title="{{ $doc->file_name }}">
                    {{ $doc->file_name }}
                </a>
            </li>
        @endforeach

        {{-- Attachments --}}
        @foreach($data2 as $doc)
            <li>
                <a class="dropdown-item text-truncate"
                   href="{{ route('dashboard.dms_document.showAttachment', $doc->slug) }}"
                   target="_blank"
                   title="{{ $doc->document_attachment_file }}">
                    {{ $doc->document_attachment_file }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
