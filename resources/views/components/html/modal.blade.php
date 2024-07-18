<div class="modal fade"
     id="{{$id}}"
     @if($static == true)
         data-backdrop="static"
     @endif
>
    <div class="modal-dialog {{!is_numeric($size) ? 'modal-'.$size : ''}}"
         style="
            @if(is_numeric($size))
                width:{{$size}}%;
            @endif
            @if($padding != null)
                padding-top:{{$padding}} ;
            @endif
            margin:15px auto"
        >
        <div class="modal-content" >
        </div>
    </div>
</div>