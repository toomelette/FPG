<table class="table-subdetail">
    <tbody>
    <tr>
        <td style="padding-right: 10px; width: 35%">Type:</td>
        <td>{{$data->personal_official}}</td>
    </tr>
    @if($data->personal_official == 'PERSONAL')
        <tr>
            <td>Frequency:</td>
            <td>{{$data->ps_frequency}} for {{Helper::dateFormat($data->date,'M Y')}}</td>
        </tr>
    @endif

    <tr>
        <td>Departure:</td>
        <td>{{Helper::dateFormat($data->departure,'h:i A')}}</td>
    </tr>
    <tr>
        <td>Return: </td>
        <td>{{Helper::dateFormat($data->return,'h:i A')}}</td>
    </tr>
    <tr>
        <td>Time Spent: </td>
        <td>
            @if($data->time_spent > 0)
            {{Helper::minsToHuman($data->time_spent)}} - <i>({{$data->time_spent}} mins.)</i>
            @endif
        </td>
    </tr>

    </tbody>
</table>