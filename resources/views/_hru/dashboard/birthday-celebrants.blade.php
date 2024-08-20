@php
    $diff = 0;
    if(Carbon::now() < \Illuminate\Support\Carbon::parse($requested_month)){
        $diff = \Illuminate\Support\Carbon::now()->firstOfYear()->diffInYears($requested_month);
    }
@endphp
@if(count($bday_celebrants['today']) > 0)
    <ul class="list-group list-group-flush">
        <li class="list-group-item p-1">
            Today:
        </li>
        @foreach($bday_celebrants['today'] as $celebrants)
            @foreach($celebrants as $celebrant)
                @if(\Illuminate\Support\Carbon::parse($requested_month)->firstOfMonth()->format('Y-m-d') == \Illuminate\Support\Carbon::now()->firstOfMonth()->format('Y-m-d'))
                    <li class="list-group-item p-1">
                        <a href="{{route('dashboard.employee.index')}}?find={{$celebrant->employee_no}}" target="_blank">{{strtoupper($celebrant->lastname)}}, {{strtoupper($celebrant->firstname)}} - {{\Illuminate\Support\Carbon::parse($celebrant->birthday)->age}} years old</a>
                        <small class="badge bg-danger float-end"><i class="fa fa-birthday-cake"></i> TODAY</small>
                    </li>
                @else
                    <li class="list-group-item p-1">
                        <a href="{{route('dashboard.employee.index')}}?find={{$celebrant->employee_no}}" target="_blank">
                            {{strtoupper($celebrant->lastname)}}, {{strtoupper($celebrant->firstname)}} - turning {{\Illuminate\Support\Carbon::parse($celebrant->birthday)->diffInYears($requested_month)+1}}
                        </a>
                        <small class="badge bg-danger float-end"><i class="fa fa-birthday-cake"></i> TODAY</small>
                    </li>
                @endif
            @endforeach
        @endforeach
    </ul>
@endif

@if(count($bday_celebrants['upcoming']) > 0)
    <ul class="list-group list-group-flush">
        <li class="list-group-item p-1">
            Upcoming:
        </li>
        @foreach($bday_celebrants['upcoming'] as $celebrants)
            @foreach($celebrants as $celebrant)
                <li class="list-group-item p-1">
                    <a href="{{route('dashboard.employee.index')}}?find={{$celebrant->employee_no}}" target="_blank">
                        {{strtoupper($celebrant->lastname)}}, {{strtoupper($celebrant->firstname)}} - turning {{\Illuminate\Support\Carbon::parse($celebrant->birthday)->diffInYears($requested_month)+1}}
                    </a>
                    <small class="badge bg-info float-end"><i class="fa fa-calendar"></i> {{Carbon::parse($celebrant->birthday)->format('M d')}}</small>
                </li>
            @endforeach
        @endforeach

    </ul>
@endif

@if(count($bday_celebrants['prev']) > 0)
    <ul class="list-group list-group-flush">
        <li class="list-group-item p-1">
            More this month:
        </li>
        @foreach($bday_celebrants['prev'] as $celebrants)
            @foreach($celebrants as $celebrant)
                <li class="list-group-item p-1">
                    <a href="{{route('dashboard.employee.index')}}?find={{$celebrant->employee_no}}" target="_blank">
                        {{strtoupper($celebrant->lastname)}}, {{strtoupper($celebrant->firstname)}} - {{\Illuminate\Support\Carbon::parse($celebrant->birthday)->diffInYears($requested_month)+1}} years old
                    </a>
                    <small class="badge bg-secondary float-end"><i class="fa fa-calendar"></i>  {{Carbon::parse($celebrant->birthday)->format('M d')}}</small>
                </li>
            @endforeach
        @endforeach
    </ul>
@endif