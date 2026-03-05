<div class="form-group  col-md-{{$cols}} {{$name}} {{$containerClass}} {{$autoClass ? Str::of($name)->replaceFirst('[','_')->replace('][','_')->replace('[','')->replace(']','') : ''}}">
    @if($selectOnly == false)
    <label for="lastname">{{$label}}:</label>
   @endif

        @if($inputGroup)
            <div class="input-group">
        @endif
                <select name="{{$name}}" class="form-control {{$class}}"
                        @if($id != null)id="{{$id}}"@endif
                        @if($required != null)
                            required="required"
                        @endif
                        @if($tabindex != null)
                            tabindex="{{$tabindex}}"
                        @endif
                        @if($multiple)
                            multiple="multiple"
                        @endif
                        @if($s2Url != null)
                            data-s2-url="{{$s2Url}}"
                        @endif
                        @if($s2Id != null)
                            data-s2-id="{{$s2Id}}"
                        @endif
                        @if($s2Text != null)
                            data-s2-text="{{$s2Text}}"
                        @endif
                >
                    @if($select2Preselected)
                        <option value="{{$value}}">{{$select2Preselected}}</option>
                    @else
                        @if($includeEmpty)
                            <option value="">{{$placeholder ?? 'Select'}}</option>
                        @endif
                    @endif

                    @foreach($options as $key => $option)
                        @if(is_array($option))
                            <optgroup label="{{$key}}">
                                @foreach($option as $key2 => $opt)
                                    <option value="{{$key2}}" {{$value == $key2 ? 'selected' : ''}}>{{$opt}}</option>
                                @endforeach
                            </optgroup>
                        @else
                            <option value="{{$key}}" {{$value == $key ? 'selected' : ''}}>{{$option}}</option>
                        @endif
                    @endforeach
                </select>
        @if($inputGroup)
                    <button class="btn {{$inputGroupClass}}" type="button">{!! $inputGroupText !!}</button>
            </div>
        @endif
</div>