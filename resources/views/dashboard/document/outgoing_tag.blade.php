<style>

</style>
<div id="parent-of-trt">
    <table class="{{$document->qr_location ?? 'UPPER_RIGHT'}}">
        <tbody>
        <tr>
            <td><img src="{{route('display_qr',$document->slug)}}" style="width: 55px"></td>
            <td style="font-family: Arial; font-size: 10px">
                SUGAR REGULATORY ADMINISTRATION
                <br>
                HUMAN RESOURCE & RECORDS SECTION
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