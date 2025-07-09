<table class="table table-bordered table-sm">
    <thead>
    <tr>
        <th class="text-center">Day</th>
        <th class="text-center">AM IN</th>
        <th class="text-center">AM OUT</th>
        <th class="text-center">PM IN</th>
        <th class="text-center">PM OUT</th>
    </tr>
    </thead>
    <tbody>
        @for($i = 1;$i <= $daysInAMonth; $i++)
            @php
                $fullDate = $month.'-'.Str::padLeft($i,2,'0');
                $thisDay = $dtrs->where('date',$fullDate);
            @endphp
            <tr>
                <td class="text-center {{Carbon::parse($fullDate)->isDayOfWeek(6) || Carbon::parse($fullDate)->isDayOfWeek(0) ? 'text-danger' : ''}}">{{$i}} </td>
                <td class="text-center">
                    {{Helper::dateFormat($thisDay->where('type','10')->last()?->timestamp,'H:i')}}
                </td>
                <td class="text-center">
                    {{Helper::dateFormat($thisDay->where('type','20')->last()?->timestamp,'H:i')}}
                </td>
                <td class="text-center">
                    {{Helper::dateFormat($thisDay->where('type','30')->last()?->timestamp,'H:i')}}
                </td>
                <td class="text-center">
                    {{Helper::dateFormat($thisDay->where('type','40')->last()?->timestamp,'H:i')}}
                </td>
            </tr>
        @endfor
    </tbody>
</table>
