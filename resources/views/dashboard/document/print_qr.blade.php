<style>
    #parent-of-trt  {
        position: relative;
        height: 100%;
    }
    .LOWER_RIGHT {
        position: absolute;
        right: 0px;
        bottom: 0px;
    }
    .LOWER_LEFT {
        position: absolute;
        left: 0px;
        bottom: 0px;
    }
    .UPPER_LEFT {
        position: absolute;
        left: 0px;
        top: 0px;
    }
    .UPPER_RIGHT{
        position: absolute;
        right: 0px;
        top: 0px;
    }
    .LOWER_LEFT_PADDED{
        position: absolute;
        left: 0px;
        bottom: 0px;
        padding-left: 30%;
    }
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
                <span style="font-size: 12px">{{$document->document_id}}</span>
            </td>
        </tr>
        </tbody>
    </table>
</div>