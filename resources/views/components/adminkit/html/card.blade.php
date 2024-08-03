<div {{ $attributes->merge(['class' => 'card '.$class])}} {{$attributes}}>
    @if(!empty($title))
        <div {{ $title->attributes->merge(['class' => 'card-header '.$headerClass])}} {{$title->attributes}}>
            <h5 class="card-title">
                {{$title}}
            </h5>
        </div>
    @endif
    <div class="card-body {{$bodyClass}}">
        {{$slot}}
    </div>
</div>