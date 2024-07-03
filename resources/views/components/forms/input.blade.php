<div class="form-group  col-md-{{$cols}} {{$name}} {{$containerClass}}">
    <label for="lastname">{{$label}}:</label>
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
    >
</div>