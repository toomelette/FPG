@if($data->last_activity == null)
<span class="badge bg-primary" style="width: 100%;">
    OFFLINE
</span>
@else
    @php
        $last_activity = Carbon::parse($data->last_activity);
    @endphp
    @if($last_activity->diffInSeconds() < 301)
        <span class="badge bg-success" style="width: 100%;">ONLINE</span>
    @else
        @if($last_activity->diffInMinutes() < 60)
            <span class="badge bg-secondary" style="width: 100%;">Active {{$last_activity->diffInMinutes()}} minutes ago</span>
        @else
            @if($last_activity->diffInMinutes() >= 60)
                @if($last_activity->diffInHours() < 2)
                    <span class="badge bg-secondary " style="width: 100%;">Active an hour ago</span>
                @else
                    @if($last_activity->diffInHours() > 23)
                        @if($last_activity->diffInDays() < 2)
                            <span class="badge bg-secondary " style="width: 100%;">Active a day ago</span>
                        @else
                            <span class="badge bg-secondary " style="width: 100%;">Active {{$last_activity->diffInDays()}} days ago</span>
                        @endif
                    @else
                        <span class="badge bg-secondary " style="width: 100%;">Active {{$last_activity->diffInHours()}} hours ago</span>
                    @endif
                @endif
            @endif
        @endif
    @endif
@endif

