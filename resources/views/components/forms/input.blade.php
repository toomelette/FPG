@if($inputOnly == false)
    <div class="form-group  col-md-{{$cols}} {{$name}} {{$containerClass}}">
        <label for="lastname">{{$label}}:</label>
@endif

        <input class="form-control {{$class}}"
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

@if($inputOnly == false)
    </div>
@endif
