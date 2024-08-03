<strong>{{$data->requisitioner}}</strong>
@if($data->email != null)
    <div class="subdetail" style="margin-top: 3px">
        <span class="text-success">{{$data->dept->descriptive_name ?? ''}}</span>
        <table class="table-subdetail">
            <tbody>
            <tr>
                <td>Email:</td>
                <td class="text-info">{{$data->email}}</td>
            </tr>
            <tr>
                <td >Phone:</td>
                <td>{{$data->phone}}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endif