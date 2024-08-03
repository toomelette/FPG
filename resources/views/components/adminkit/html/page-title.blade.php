<h1 class="h3 mb-2">
    {{$title}}
    @if(!empty($subtitle))
        <small> - {{$subtitle}}</small>
    @endif

    @if(!empty($floatEnd))
        <span class="float-end">{{$floatEnd}}</span>
    @endif
</h1>