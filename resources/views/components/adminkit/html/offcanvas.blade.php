<div class="offcanvas offcanvas-{{$class}}" tabindex="-1" id="{{$id}}" aria-labelledby="{{$id}}Label" {{$attributes}}>
    <div class="offcanvas-header">
        <h5 id="{{$id}}Label">{{$title}}</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        {{$slot}}
    </div>
</div>