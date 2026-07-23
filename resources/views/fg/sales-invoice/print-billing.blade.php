@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
    <style>
        @media print {
            @page {
                size: Letter  portrait; /* or portrait */
            }
        }
    </style>

    <div style="font-family: Cambria;">
        <table style="width: 100%; font-size: 14px" class="b-vertical b-top tbl-padded">
            <tr>
                <td style="text-align: center">
                    <img src="{{asset('images/fg-header.png')}}" style="width: 80%">
                </td>
            </tr>
            <tr>
                <td class="text-strong text-center b-vertical b-top">BILLING</td>
            </tr>
        </table>
        <table style="width: 100%; font-size: 14px" class="tbl-bordered tbl-padded">
            <tr>
                <td rowspan="2" style="width: 65%;">
                    <span style="font-size: 16px" class="text-strong">{{$salesInvoice->client->name}}</span> <br>
                    {{$salesInvoice->client->address}}
                </td>
                <td style="height: 100px">
                    {{Helper::dateFormat($salesInvoice->date,'F d, Y')}}
                </td>
            </tr>
            <tr>
                <td >BILLING NO: {{$salesInvoice->invoice_no}}</td>
            </tr>
        </table>
        <table style="width: 100%;" class="tbl-padded b-left b-right" id="table">
            <thead>
            <tr>
                <th class="text-center b-bottom b-right">QUANTITY</th>
                <th class="text-center b-bottom b-right">UOM</th>
                <th class="text-center b-bottom b-right">DESCRIPTION OF ARTICLES</th>
                <th class="text-center b-bottom b-right">UNIT PRICE</th>
                <th class="text-center b-bottom">TOTAL PRICE</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="5" style="vertical-align: top; padding: 7px 5px" class="text-center">
                    {{$salesInvoice->remarks}}
                </td>
            </tr>
            @forelse($salesInvoice->details as $detail)
                <tr>
                    <td class="text-center">{{$detail->qty}}</td>
                    <td class="text-center">{{$detail->uom}}</td>
                    <td>{{$detail->description}}</td>
                    <td class="text-right">{{Helper::toNumber($detail->unit_cost)}}</td>
                    <td class="text-right">{{Helper::toNumber($detail->amount)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <td colspan="5" id="placeholder">

                </td>
            </tr>
            </tbody>
            <tfoot>
                <tr style="font-size: 13px">
                    <td class="text-strong b-top" colspan="4">TOTAL AMOUNT DUE</td>
                    <td class="text-strong text-right b-top">{{Helper::toNumber($salesInvoice->total_amount_due)}}</td>
                </tr>
            </tfoot>
        </table>
        <table style="width: 100%;" class="tbl-padded b-all">
            <tr>
                <td style="width: 1%;"></td>
                <td style="width: 24%;">
                    PREPARED BY:
                </td>
                <td style="width: 1%;"></td>
                <td class="text-top">NOTED BY</td>
                <td style="width: 1%;"></td>
                <td class="text-top" style="width: 50%;">Received the above merchandise in good order and condition</td>
                <td style="width: 1%;"></td>
            </tr>
            <tr>
                <td></td>
                <td class="b-bottom" style="height: 50px"></td>
                <td></td>
                <td class="b-bottom" style="height: 50px"></td>
                <td></td>
                <td class="b-bottom" style="height: 50px"></td>
            </tr>
            <tr>
                <td style="height: 25px"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="small text-top">Printed Name & Signature</td>
            </tr>
        </table>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            var maxHeight = 600;
            var tableHeight = $("#table").height();
            var needed = maxHeight - tableHeight;
            if(tableHeight <= maxHeight){
                $("#placeholder").css('height',needed+'px');
            }
            print();
        })

        window.onafterprint = function () {
            window.close();
        }

    </script>
@endsection