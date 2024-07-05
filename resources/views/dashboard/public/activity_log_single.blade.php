@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria;">
        <h3>{{\Illuminate\Support\Facades\Request::get('text') ?? ''}}</h3>
        <table style="width: 100%;font-size: 15px" class="tbl-bordered-grey tbl-padded">
            <thead>
            <tr>
                <th>#</th>
                <th>Timestamp</th>
                <th>Event</th>
                <th>User</th>
                <th>Changelog</th>
            </tr>
            </thead>
            <tbody>
            @php
                $users = [];
            @endphp
            @forelse($activities as $activity /** @var \Spatie\Activitylog\Models\Activity $activity **/)
                @php
                    if(!isset($users[$activity->causer_id])){
                        $user = \App\Models\User::query()
                        ->with(['employee'])
                        ->find($activity->causer_id);
                        $users[$activity->causer_id] = $user;
                    }
                @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{Helper::dateFormat($activity->created_at,'M. d, Y | h:i A')}}</td>
                    <td class="text-center">{{strtoupper($activity->event)}}</td>
                    <td>
                        @if(isset($users[$activity->causer_id]))
                            {{$users[$activity->causer_id]->employee->full_name ?? $users[$activity->causer_id]->user_id ?? $users[$activity->causer_id]}}
                        @else
                        @endif
                    </td>
                    <td>
                        <p>Changes made:</p>
                        @php
                            $attributes = $activity->attributesToArray();
                            $changed = $activity->getChangesAttribute();
                        @endphp
                        @if(isset($changed['old']))
                            <table class="tbl-bordered-grey tbl-padded" style="width: 100%">
                                <thead>
                                <tr>
                                    <th style="width: 20%">Data</th>
                                    <th style="width: 40%">From</th>
                                    <th>Changed to</th>
                                </tr>
                                @foreach($changed['old'] as $field => $old)
                                    <tr>
                                        <td>{{Str::of($field)->title()->replace('_',' ')}}</td>
                                        <td>{{$old}}</td>
                                        <td>{{$changed['attributes'][$field]}}</td>
                                    </tr>
                                @endforeach
                                </thead>
                            </table>
                        @else
                            <p>New data created.</p>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center">No logs found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>


@endsection

@section('scripts')

@endsection
