@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\RECORDS\DocumentRequests $documentRequest **/
@endphp
@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px">
            <tr>
                <td style="width: 65%;">
                    <h3 class="no-margin text-strong">Fil Power Group & Marketing Corp.</h3>
                    <p class="no-margin">Lopez Jaena Street, Bacolod City</p>
                </td>
                <td class="text-right text-strong">
                    <i></i>
                </td>
            </tr>
            <tr>

                <td>
                    <h3 class="text-strong">PURCHASE ORDER</h3>
                    <table style="width: 100%; font-size: 14px; border-spacing: 5px;border-collapse: separate;" class="tbl-padded">
                        <tr>
                            <td style="border: 1px solid black">{{$purchaseOrder->supplier}}</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black">{{$purchaseOrder->remarks}}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%; font-size: 14px; border-spacing: 5px;border-collapse: separate;" class="tbl-padded">
                        <tr>
                            <td>PO No.</td>
                            <td style="border: 1px solid black">{{$purchaseOrder->control_no}}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td style="border: 1px solid black">{{Helper::dateFormat($purchaseOrder->date,'m/d/Y')}}</td>
                        </tr>
                        <tr>
                            <td>Terms</td>
                            <td style="border: 1px solid black">{{$purchaseOrder->terms}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>

        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-bottom">DESCRIPTION</th>
                <th class="text-center b-bottom">UNIT</th>
                <th class="text-center b-bottom">QUANTITY</th>
                <th class="text-center b-bottom">UNIT PRICE</th>
                <th class="text-center b-bottom">AMOUNT</th>
            </tr>
            </thead>
            <tbody>
            @forelse($purchaseOrder->details as $detail)
                <tr>
                    <td>{{$detail->description}}</td>
                    <td class="text-center">{{$detail->uom}}</td>
                    <td class="text-center">{{$detail->qty}}</td>
                    <td class="text-right">{{Helper::toNumber($detail->unit_cost)}}</td>
                    <td class="text-right">{{Helper::toNumber($detail->amount)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="b-top" colspan="4">TOTAL</th>

                <th class="b-top text-right">
                    {{Helper::toNumber($purchaseOrder->details->sum('amount'))}}
                </th>
            </tr>
            </tbody>
        </table>

        <br>
        <table style="width: 100%; font-size: 14px; border-collapse: separate;border-spacing: 10px">
            <tr>
                <td style="width: 33.333%;" class="text-top">
                    Prepared by:
                </td>
                <td style="width: 33.333%;" class="text-top">
                    Approved by:
                </td>
                <td style="" class="text-top">
                    Conforme/Accepted:
                </td>

            </tr>

            <tr>
                <td class="b-bottom"></td>
                <td class="text-strong b-bottom text-bottom">R.L. BERMEO JR. / A.B. GUEVARA</td>
                <td class="b-bottom" style="height: 50px"></td>
            </tr>

        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
        window.onafterprint = function () {
            window.close();
        }
    </script>
@endsection