@extends('layouts.modal-content')

@section('modal-header')
    {{$document->reference_no}}
@endsection

@section('modal-body')
    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
        Document Info
    </p>

    <div class="well well-sm">
        <dl class="dl-horizontal">
            <dt>Reference No:</dt>
            <dd>{{$document->reference_no}}</dd>
            <dt>Document ID:</dt>
            <dd>{{$document->document_id}}</dd>
            <dt>Date:</dt>
            <dd>{{\Illuminate\Support\Carbon::parse($document->data)->format('F d, Y')}}</dd>
            <dt>To:</dt>
            <dd>{{$document->person_to}}</dd>
            <dt>From:</dt>
            <dd>{{$document->person_from}}</dd>
            <dt>Subject:</dt>
            <dd>{{$document->subject}}</dd>
            <dt>Type:</dt>
            <dd>{{(isset(\App\Swep\Helpers\__static::document_types(true)[$document->type]) ? \App\Swep\Helpers\__static::document_types(true)[$document->type] : $document->type)}}</dd>
            <dt>Folder:</dt>
            <dd>{{$document->folder_code}} - {{$document->folder->description}}</dd>
            @if($document->folder_code2 != '')
                <dt>Folder 2:</dt>
                <dd>{{$document->folder_code2}} - {{$document->folder2->description}}</dd>
            @endif

            <dt>Remarks:</dt>
            <dd>{{$document->remarks}}</dd>
        </dl>
    </div>
    <p class="page-header-sm text-info" style="border-bottom: 1px solid #cedbe1">
        File info
    </p>

    <div class="well well-sm">
        <dl class="dl-horizontal">
            <dt>Filename:</dt>
            <dd>{{$document->filename}}</dd>

            @if(\Illuminate\Support\Facades\Storage::exists($document->path.$document->filename))
                <dt>Size:</dt>
                <dd>
                    {{\App\Swep\Helpers\Helper::formatBytes(\Illuminate\Support\Facades\Storage::size($document->path.$document->filename), 'MB')}}
                </dd>
            @endif

            <dt>Path:</dt>
            <dd>{{$document->path}}</dd>
            @if($document->folder_code2 != '')
                <dt>Path 2:</dt>
                <dd>{{$document->path2}}</dd>
            @endif
        </dl>
    </div>

@endsection

@section('modal-footer')
    <div class="row">
        <x-html.timestamp-footer :source-data="$document" cols="10"/>
        <div class="col-md-2">
            <button class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection

