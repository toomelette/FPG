<div class="form-group col-{{$cols}} {{$name}} {{$containerClass}}" >
    <label for="{{$for ?? $name}}">{{$label}}:</label>
    <textarea class="form-control {{$class}}" @if($id) id="{{$id}}"@endif  name="{{$name}}" rows="{{$rows}}" >{!! $value !!}</textarea>
</div>