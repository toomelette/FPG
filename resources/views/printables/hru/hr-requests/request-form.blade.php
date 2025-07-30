@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
<div class="print-wrapper" style="font-family: Cambria">
    @for($i = 0; $i <= 1; $i++)
        <div style="{{$i == 0 ? 'height: 500px' : ''}}">
            <p class="text-center no-margin text-strong">Administrative and Finance Department
            <p class="text-center no-margin text-strong">General Administrative Division</p>
            <p class="text-center text-strong">Human Resource and Records Section</p>

            <p class="text-center text-strong">REQUEST FORM</p>
            <table style="width: 100%; font-size: 14px" class="tbl-padded">
                <tr>
                    <td style="width: 20%">Name of Requestor:</td>
                    <td class="b-bottom" style="width: 45%;">{{$hrRequest->employee_full}}</td>
                    <td style="width: 15%;">Signature:</td>
                    <td class="b-bottom"></td>
                </tr>
                <tr>
                    <td>Purpose of Request:</td>
                    <td colspan="3" class="b-bottom">{{$hrRequest->purpose}}</td>
                </tr>
                <tr>
                    <td>Date of Request:</td>
                    <td class="b-bottom">{{Helper::dateFormat($hrRequest->created_at,'F d, Y')}}</td>
                    <td>Time of Request:</td>
                    <td class="b-bottom">{{Helper::dateFormat($hrRequest->created_at,'h:i A')}}</td>
                </tr>
            </table>
            @php
                $options = [
                        'Service Record',
                        'Certificate of Employment',
                        'Certificate of No Pending Case',
                        'Certificate of Leave Without Pay (LWOP)',
                        'Certificate of Discount given to Government Hospital',
                        'Certificate with Dependents',
                    ];
                $others = true;
            @endphp
            <table class="tbl-padded" style="font-size: 12px; width: 70%; margin-left: 25%; margin-top: 20px">
                @foreach($options as $option)
                    <tr>
                        <td class="b-bottom" style="width: 40px">
                            &nbsp;&nbsp;&nbsp;
                            @if($hrRequest->document == $option)
                                @php
                                    $others = false;
                                @endphp
                                ✔
                            @else
                                &nbsp;
                            @endif
                            &nbsp;&nbsp;&nbsp;
                        </td>
                        <td>{{$option}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="b-bottom">
                        &nbsp;&nbsp;&nbsp;
                        @if($others)
                            ✔
                        @else
                            &nbsp;
                        @endif
                        &nbsp;&nbsp;&nbsp;
                    </td>
                    <td>Others: <u class="text-strong">{{$others ? $hrRequest->document : ''}}</u></td>
                </tr>
            </table>
            <table style="width: 100%; font-size: 14px;margin-top: 20px" class="tbl-padded">
                <tr>
                    <td style="width: 20%"></td>
                    <td  style="width: 35%;"></td>
                    <td style="width: 25%;"></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Remarks:</td>
                    <td colspan="3" class="b-bottom">{{$hrRequest->details}}</td>
                </tr>
                <tr>
                    <td>Released by:</td>
                    <td class="b-bottom"></td>
                    <td>Date and Time of Release:</td>
                    <td class="b-bottom"></td>
                </tr>
            </table>

            <div style="margin-top: 30px">
                <p class="no-margin text-right" style="font-size: 10px;">FM-AFD-HRS-048, Rev. 001</p>
                <p class="no-margin text-right" style="font-size: 10px;">Effectivity Date: November 16, 2020</p>
            </div>
        </div>
    @endfor
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
    </script>
@endsection