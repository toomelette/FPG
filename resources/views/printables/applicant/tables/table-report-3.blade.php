@php($num = 1)
<table class="table table-bordered">
    <thead class="">
    <tr class="text-strong">
        @foreach($requested_columns as $requested_column)
            @switch($requested_column)
                @case('numbering')
                    <th class="{{$requested_column}}">#</th>
                    @break
                @default
                    <th class="{{$requested_column}}">{{$columns[$requested_column]}}</th>
                    @break
            @endswitch
        @endforeach
    </tr>
    </thead>

    <tbody>
    @foreach($applicants as $applicant_slug=>$applicant)
        @if(is_array($applicant))
            <tr>
                @foreach($requested_columns as $requested_column)
                    @switch($requested_column)
                        @case('numbering')
                            <td class="{{$requested_column}}">{{$num++}}</td>
                            @break
                        @case('fullname')
                            <td class="{{$requested_column}}">{{$applicant['applicant_obj']->lastname}}, {{$applicant['applicant_obj']->firstname}}</td>
                            @break
                        @case('course')
                            @if(!empty($applicant['applicant_obj']->course))
                                <td class="{{$requested_column}}">{{str_replace('BACHELOR OF SCIENCE IN','BS',$applicant['applicant_obj']->course)}}</td>
                            @else
                                <td class="{{$requested_column}}">N/A</td>
                            @endif
                            @break
                        @case('department_unit')
                            @if(!empty($applicant['applicant_obj']->departmentUnit))
                                <td class="{{$requested_column}}">{{$applicant['applicant_obj']->departmentUnit->description}}</td>
                            @else
                                <td class="{{$requested_column}}">N/A</td>
                            @endif
                            @break
                        @case('date_of_birth')
                            <td class="{{$requested_column}}">{{date('M. d, Y',strtotime($applicant['applicant_obj']->date_of_birth))}}</td>
                            @break
                        @case('position_applied')
                            @if(!empty($applicant['applicant_obj']->positionApplied))
                                <td class="{{$requested_column}}">

                                    @foreach($applicant['applicant_obj']->positionApplied as $position_applied)
                                        • {{$position_applied->position_applied}}<br>
                                    @endforeach

                                </td>
                            @else
                                <td class="{{$requested_column}}">N/A</td>
                            @endif
                            @break
                        @case('received_at')
                            <td class="{{$requested_column}}">{{date("m/d/Y",strtotime($applicant['applicant_obj']->received_at))}}</td>
                            @break
                        @default
                            <td class="{{$requested_column}}">{{$applicant['applicant_obj']->$requested_column}}</td>
                            @break
                    @endswitch

                @endforeach

            </tr>
        @endif

    @endforeach
    </tbody>
</table>