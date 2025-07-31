@php
    $statusCollection = collect($hrRequest->status_trail);
    $statusCollection->sortBy('timestamp');
    $userIds = $statusCollection->pluck('user')->unique();
    $userIds->push($hrRequest->user_created);
    $usersUsed = \App\Models\User::query()
        ->with(['employee'])
        ->whereIn('user_id',$userIds)
        ->get();
@endphp
<section>
    <ul class="timeline">
        <li class="timeline-item mb-2">
            <h5 class="fw-bold">Request for {{$hrRequest->document}} was created.</h5>
            <p class="text-muted mb-1 fw-bold">{{Helper::dateFormat($hrRequest->created_at,'d F Y | h:i A')}}</p>
            <p class="text-muted">
                {{$usersUsed->where('user_id','=',$hrRequest->user_created)?->first()?->employee?->full['FMiLE']}}
            </p>
        </li>

        @if(!empty($statusCollection))
            @foreach($statusCollection as $status)
                <li class="timeline-item mb-2">
                    <h5 class="fw-bold">{{$status['status']}}</h5>
                    <p class="text-muted mb-2 fw-bold">{{Carbon::parse($status['timestamp'])->setTimezone('Asia/Macao')->format('d F Y | h:i A')}}</p>
                    <p class="text-muted">
                        {{$usersUsed->where('user_id','=',$status['user'])?->first()?->employee?->full['FMiLE']}}
                    </p>
                </li>
            @endforeach
        @endif
    </ul>
</section>