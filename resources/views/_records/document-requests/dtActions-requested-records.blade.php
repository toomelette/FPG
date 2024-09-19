@php
/** @var \App\Models\RECORDS\DocumentRequests $data **/
 @endphp
<b>{{$data->requested_records}}</b>

<div class="subdetail" style="margin-top: 3px">
    <table class="table-subdetail">
        <tbody>

        <tr>
            <td style="padding-right: 10px; width: 80px">Req. Party:</td>
            <td>{{$data->requesting_party}} {{$data->requesting_party_specify != null ? (' - '.$data->requesting_party_specify) : ''}}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px">Purpose:</td>
            <td>{{$data->purpose}} {{$data->purpose_specify != null ? (' - '.$data->purpose_specify) : ''}}</td>
        </tr>

        </tbody>
    </table>
</div>