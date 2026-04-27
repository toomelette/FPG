@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
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
        <table style="width: 100%; font-size: 14px" class="tbl-bordered">
            <tr>
                <td rowspan="2" style="width: 65%;">
                    {{$salesInvoice->client->name}} <br>
                    {{$salesInvoice->client->address}}
                </td>
                <td style="height: 100px">

                </td>
            </tr>
            <tr>
                <td >BILLING NO: {{$salesInvoice->invoice_no}}</td>
            </tr>
        </table>
        <table style="width: 100%;" class="tbl-padded b-left b-right">
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
                <td>
                    CHECKED BY: <br><br><br><br>
                </td>
            </tr>
        </table>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
            print();

    </script>
@endsection