<div class="form-group col-md-{{$thiss->cols}} {{$thiss->name}} {{$thiss->containerClass}}">
    <label for="{{$thiss->for}}">{{$thiss->label}}:</label>
    <select name="{{$thiss->name}}" class="form-control {{$thiss->class}}">
        <option value="" {{$thiss->disableDefault == true ? 'disabled' : ''}}>{{$thiss->placeholder ?? 'Select'}}</option>
        @foreach($thiss->options as $groupLabel => $options)
            @if(is_array($options))
                <optgroup label="{{$groupLabel}}">
                    @foreach($options as $key => $textValue)
                        <option value="{{$key}}" {{$key == $thiss->value ? 'selected' : ''}}>{{$textValue}}</option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{$groupLabel}}" {{$groupLabel == $thiss->value ? 'selected' : ''}}>{{$options}}</option>
            @endif
        @endforeach
    </select>
</div>