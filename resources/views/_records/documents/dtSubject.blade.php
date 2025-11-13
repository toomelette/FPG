@foreach(Str::of($data->subject)->explode(' ') as $text)
    <span class="allow-search">{{$text}}</span>
@endforeach

@if($data->remarks != '')
    <div class="subdetail" style="margin-top: 3px">
        <span class="text-success text-strong">{{$data->remarks}}</span>
    </div>
@endif