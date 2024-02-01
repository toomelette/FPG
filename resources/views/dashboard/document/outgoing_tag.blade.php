<style>

</style>
<div id="parent-of-trt">
    <table class="{{$document->qr_location ?? 'UPPER_RIGHT'}}">
        <tbody>
        <tr>
            <td><img src="{{route('display_qr',$document->slug)}}" style="width: 60px"></td>
            <td style="font-family: Arial; font-size: 8px">
                <b>SUGAR REGULATORY ADMINISTRATION</b>
                <br>
                HRRS
                <br>
                DOCUMENT ARCHIVING SYSTEM
                <br>
                <br>
                <span style="font-size: 13px;font-weight: bold">{{$document->outgoing_control_no ?? $document->document_id}}</span>
            </td>
        </tr>
        </tbody>
    </table>
</div>