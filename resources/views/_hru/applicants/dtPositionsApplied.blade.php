<ul style="padding-left: 15px; margin-bottom: 0px">
    @forelse($data->positionApplied as $position)
        <li>
            @if($position->item != null || $position->item_no != '')
                <strong>{{$position->item_no}}</strong> -

            @endif
            {{$position->position_applied}}
        </li>
    @empty
    @endforelse
</ul>