<a href="{{route('dashboard.show_activity',[$sourceData->getTable(),$sourceData->{$sourceData->getKeyName()}])}}" target="_blank">
    <div class="col-md-{{$cols}}" style="color: dimgrey">
        <table style="width: 100%; font-size: 11px" class="text-left">
            <tr>
                <th>Data created:</th>
                <th>Data updated:</th>
            </tr>
            <tr>
                <td style="width: 50%">
                    {{$sourceData->createdBy->employee->full_name ?? ''}}
                </td>
                <td>
                    {{$sourceData->updatedBy->employee->full_name ?? ''}}
                </td>
            </tr>
            <tr>
                <td>
                    {{Helper::dateFormat($sourceData->created_at,'M d, Y | h:i A')}}
                </td>
                <td>
                    {{Helper::dateFormat($sourceData->updated_at,'M d, Y | h:i A')}}
                </td>
            </tr>
        </table>
    </div>
</a>