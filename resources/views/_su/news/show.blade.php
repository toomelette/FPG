@extends('adminkit.modal')

@section('modal-header')
    {{$news->title}}
@endsection

@section('modal-body')
    {!! $news->details !!}

    @if($news->attachments->count() > 0)
        Attachment(s):
        <ul>
            @forelse($news->attachments as $attachment)
                <li><a href="{{route('dashboard.news.view_doc',$attachment->slug)}}" target="_blank"><i class="fa fa-link"></i> {{$attachment->original_file_name}}</a></li>
            @empty
            @endforelse
        </ul>
    @endif
    <hr class="mb-1">
    <div class="row">
        <div class="col-md-6">
            <b>{{$news->author}}</b> <br> <small>{{$news->author_position}}</small>
        </div>
        <div class="col-md-6 text-end">
            <i class="fa fa-clock"></i> {{Carbon::parse($news->created_at)->format('F d, Y | h:i A')}}
        </div>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary"  data-bs-dismiss="modal"> Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection