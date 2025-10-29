@extends('adminkit.modal')

@section('modal-header')
    {{$news->title}}
@endsection

@section('modal-body')
    {!! $news->details !!}
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