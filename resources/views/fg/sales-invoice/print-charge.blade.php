@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; width: 188mm;">
        <table style="width: 100%; font-size: 14px" class="">
            <tr>
                <td style="height: 24mm; width: 120mm"></td>
                <td></td>
            </tr>
            <tr>
                <td style="height: 6mm; width: 120mm"></td>
                <td>{{\App\Swep\Helpers\Helper::dateFormat($salesInvoice->date,'m/d/Y')}}</td>
            </tr>
        </table>
        <table style="width: 100%; font-size: 14px" class="">
            <tr>
                <td style="height: 6mm; width: 25mm"></td>
                <td class="text-strong">{{$salesInvoice->client->name}}</td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 14px" class="">
            <tr>
                <td style="height: 6mm; width: 31mm"></td>
                <td class="text-strong" style="width: 74mm"><br></td>
                <td class="text-strong" style="width: 10mm"></td>
                <td class="text-strong">{{$salesInvoice->client->tin}}</td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 14px" class="">
            <tr>
                <td style="height: 6mm; width: 20mm"></td>
                <td class="text-strong" >{{$salesInvoice->client->address}}</td>
            </tr>
        </table>

        <table style="width: 100%" class="">
            <tr>
                <td style="height: 13mm"></td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 14px" id="details-tbl" class="">
            @forelse($salesInvoice->details as $detail)
                <tr class="details-row">
                    <td style="width: 24mm;" class="text-center text-top">{{$detail->qty}}</td>
                    <td style="width: 18mm;" class="text-center text-top">{{$detail->uom}}</td>
                    <td style="width: 81mm;" class="text-top">{{$detail->description}}</td>
                    <td style="width: 25mm; padding-bottom: 8mm" class="text-right text-top">{{Helper::toNumber($detail->unit_cost)}}</td>
                    <td class="text-right text-top">{{Helper::toNumber($detail->amount)}}</td>
                </tr>
            @empty
            @endforelse
            <tr id="adjuster">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 14px" id="details-tbl" class="">
            <tr>
                <td style="width: 39mm; height: 11mm" class="text-center text-top"></td>
                <td style="width: 30mm;" class="text-top"></td>
                <td style="width: 50mm;" class="text-top"></td>
                <td style="width: 27mm;" class="text-right text-top"></td>
                <td class="text-right">{{Helper::toNumber($salesInvoice->tax_base)}}</td>
            </tr>
            <tr>
                <td style="width: 39mm; height: 11mm" class="text-center text-top"></td>
                <td style="width: 30mm;" class="text-top"></td>
                <td style="width: 50mm;" class="text-top"></td>
                <td style="width: 27mm;" class="text-right text-top"></td>
                <td class="text-right">{{Helper::toNumber($salesInvoice->vat)}}</td>
            </tr>


            <tr>
                <td style="height: 8mm" class="text-center text-top" colspan="4"></td>
                <td class="text-right text-strong">{{Helper::toNumber($salesInvoice->total_amount_due)}}</td>
            </tr>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            let allowableHeight = 105;
            let totalDetailsHeight = 0;
            $("#details-tbl .details-row").each(function (){
                totalDetailsHeight = totalDetailsHeight + ($(this).height() * 25.4 / 96)
            })
            $("#adjuster").css('height',allowableHeight-totalDetailsHeight+'mm');

            print();
        })

    </script>
@endsection