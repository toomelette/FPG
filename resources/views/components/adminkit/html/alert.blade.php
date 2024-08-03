<div class="alert alert-{{$type}} @if($dismissible) alert-dismissible @endif" role="alert">
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
    @if($withIcon)
        <div class="alert-icon">
            <i class="far fa-fw fa-bell"></i>
        </div>
    @endif
    <div class="alert-message {{$bodyClass}}">
        {{$slot}}
    </div>
</div>

