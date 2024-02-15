@if($data->email != null)
    <div class="table-subdetail" style="margin-top: 3px">
        <table>
            <tbody>
            <tr>
                <td style="padding-right: 10px">Email:</td>
                <td class="text-info">{{$data->email}}</td>
                <td style="padding-left: 20px;padding-right: 10px">Phone:</td>
                <td>{{$data->phone}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endif