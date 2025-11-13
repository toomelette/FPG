@foreach(Str::of($data->$column)->explode(' ') as $text)
    <span class="allow-search">{{$text}}</span>
@endforeach