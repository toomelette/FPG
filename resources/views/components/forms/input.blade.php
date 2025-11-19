
<div class="form-group  col-md-{{$cols}} {{$name}} {{$containerClass}} {{$autoClass ? Str::of($name)->replaceFirst('[','_')->replace('][','_')->replace('[','')->replace(']','') : ''}}">
    @if($inputOnly == false)
    <label for="">{{$label}}:</label>
     @endif

    @if($inputGroup)
            <div class="input-group">
    @endif
                <input class="form-control {{$class}} "
                       aria-label="{{$label}}"
                       name="{{$name}}"
                       type="{{$type}}"
                       value="{{$value}}"
                       placeholder="{{$placeholder ?? $label}}"
                       autocomplete="{{$autocomplete}}"
                       @if($id != null)
                           id="{{$id}}"
                       @endif
                       @if($for != null)
                           for="{{$for}}"
                       @endif
                       @if($required != null)
                           required="required"
                       @endif
                       @if($tabindex != null)
                           tabindex="{{$tabindex}}"
                        @endif
                       @if($step != null)
                           step="{{$step}}"
                        @endif
                       @if($disabled == true)
                           disabled="disabled"
                        @endif

                        {{$attributes}}
                >


        @if($inputGroup)
                    <button class="btn {{$inputGroupClass}}" type="button">{!! $inputGroupText !!}</button>
            </div>
        @endif
</div>

