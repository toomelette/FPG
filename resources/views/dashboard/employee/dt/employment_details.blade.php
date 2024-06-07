<b>{{$data->employee_no}}</b>
@if($data->biometric_user_id != 0 && $data->biometric_user_id != '' && $data->biometric_user_id != null)
    <span class="pull-right" title="Biometric User ID">
        <i class="fa icon-ico-fingerprint"></i> {{$data->biometric_user_id}}
    </span>
@endif
<div class="table-subdetail" style="margin-top: 3px">
    <table>
        <tbody>
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
            <td style="padding-right: 10px">Assignement:</td>
            <td>{{$data->assignment}}</td>
        </tr>
        </tbody>
    </table>
</div>