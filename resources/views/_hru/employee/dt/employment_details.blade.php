<p class="text-strong no-margin">{{$data->employee_no}}</p>

<div class="subdetail" style="margin-top: 3px">
    <table class="table-subdetail">
        <tbody>
        @if($data->biometric_user_id != 0 && $data->biometric_user_id != '' && $data->biometric_user_id != null)
            <tr>
                <td style="padding-right: 10px">Biometric ID.:</td>
                <td>{{$data->biometric_user_id}}</td>
            </tr>
        @endif

        <tr>
            <td style="padding-right: 10px">Original Appt.:</td>
            <td>{{Helper::dateFormat($data->firstday_gov,'M. d, Y')}} - {{Carbon::parse($data->firstday_gov)->age}}y</td>
        </tr>
        <tr>
            <td style="padding-right: 10px">First Day in SRA:</td>
            <td>{{Helper::dateFormat($data->firstday_sra,'M. d, Y')}} - {{Carbon::parse($data->firstday_sra)->age}}y</td>
        </tr>
        <tr>
            <td style="padding-right: 10px">Last promotion:</td>
            <td>{{Helper::dateFormat($data->adjustment_date,'M. d, Y')}}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px">Assignment:</td>
            <td>{{$data->assignment}}</td>
        </tr>

        @if($data->date_of_separation != null)
            <tr class="text-danger">
                <td style="padding-right: 10px">Date of Separation:</td>
                <td>{{Helper::dateFormat($data->date_of_separation,'M. d, Y')}}</td>
            </tr>
        @endif
        @if($data->reason_of_separation != null || $data->reason_of_separation != '')
        <tr class="text-danger">
            <td style="padding-right: 10px">Reason of Separation:</td>
            <td>{{$data->reason_of_separation}}</td>
        </tr>
        @endif
        </tbody>
    </table>
</div>