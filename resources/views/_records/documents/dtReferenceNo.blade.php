<strong>{{$data->reference_no}}</strong>
<div class="subdetail" style="margin-top: 3px">
    <span class="float-end">
        @if(!empty($data->folder_code))
            <a title="{{$data->folder->description}}" href="{{route("dashboard.document_folder.browse",$data->folder_code)}}" target="_blank"><i class="fa fa-folder"></i> {{$data->folder_code}}</a>
        @endif
        @if(!empty($data->folder_code2))
            & <a title="{{$data->folder2->description}}" href="{{route("dashboard.document_folder.browse",$data->folder_code2)}}" target="_blank">{{$data->folder_code2}}</a>
        @endif
    </span>
    {{__static::document_types(true)[$data->type]  ?? ''}}
</div>