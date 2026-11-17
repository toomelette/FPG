@if(filled($data->latestLogs))
    @forelse($data->latestLogs as $logs)
        <small>
            {{$logs->user->employee->full['LFEMi']}} | {{Helper::dateFormat($logs->created_at,'M. d, Y H:i:s')}}<br>
        </small>
    @empty
    @endforelse
@endif