<div class="form-group  col-md-{{$cols}} {{$name}} {{$containerClass}}">
    <label for="lastname">{{$label}}:</label>
    <div class="row">
        @foreach($options as $key => $option)
            <div class="col-md-{{$eachClass}}">
                <label>
                    <input class="{{$class}}" type="{{$type}}" name="{{$name}}{{$type=='checkbox' ? '[]' : ''}}" value="{{$key}}" {{in_array($key,$value) ? 'checked' : ''}}> {{$option}}
                </label>
            </div>
        @endforeach
    </div>
</div>