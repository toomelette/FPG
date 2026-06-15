@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <tr>
                <td style="width: 80%;">
                    <p class="no-margin text-strong" style="font-size: 28px">{{\App\Swep\Helpers\Get::company()}}</p>
                    <p class="no-margin" style="font-size: 18px">{{\App\Swep\Helpers\Get::address()}}</p>
                </td>
                <td>
                    <table style="width: 100%; font-size: 14px">
                        <tr>
                            <td>SI Date:</td>
                            <td>{{Helper::dateFormat($si->date,'M. d, Y')}}</td>
                        </tr>
                        <tr>
                            <td>SI No:</td>
                            <td>{{$si->invoice_no}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="height: 10px"></td>
            </tr>
            <tr>
                <td class="text-strong b-all">{{$si->client->name}} - {{$si->client->account_no}}</td>
            </tr>
            <tr>
                <td style="height: 10px"></td>
            </tr>
            <tr>
                <td class="b-all">{{$si->client->address}}</td>
            </tr>
        </table>
        <p class="text-strong" style=" margin-top: 15px">PROJECT PREPARATION</p>
        <table style="width: 100%; font-size: 14px;" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-bottom">REF NO</th>
                <th class="text-center b-bottom">PARTICULARS</th>
                <th class="text-center b-bottom">QTY</th>
                <th class="text-center b-bottom">UOM</th>
                <th class="text-center b-bottom">UNIT PRICE</th>
                <th class="text-center b-bottom">AMOUNT</th>
            </tr>
            </thead>
            <tbody>
                @forelse($preparationDetails as $preparationDetail)
                    <tr>
                        <td class="text-center">{{$preparationDetail->preparation->control_no}}</td>
                        <td>{{$preparationDetail->description}}</td>
                        <td class="text-center">{{$preparationDetail->qty}}</td>
                        <td class="text-center">{{$preparationDetail->uom}}</td>
                        <td class="text-right">{{Helper::toNumber($preparationDetail->unit_cost)}}</td>
                        <td class="text-right">{{Helper::toNumber($preparationDetail->amount)}}</td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <th colspan="5" class="b-top">TOTAL</th>
                    <th class="text-right b-top">{{Helper::toNumber($preparationDetails->sum('amount'))}}</th>
                </tr>
            </tbody>
        </table>
        <br>
        <p class="text-strong">PROJECT EXPENSES</p>
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-bottom">REF NO</th>
                <th class="text-center b-bottom">EXPENSES</th>
                <th class="text-center b-bottom">AMOUNT</th>
            </tr>
            </thead>
            <tbody>
            @forelse($liquidationDetails as $liquidationDetail)
                <tr>
                    <td class="text-center">{{$liquidationDetail->liquidation->control_no}}</td>
                    <td>{{$liquidationDetail->description}}</td>
                    <td class="text-right">{{Helper::toNumber($liquidationDetail->debit - $liquidationDetail->credit)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th colspan="2" class="b-top">TOTAL</th>
                <th class="text-right b-top">{{Helper::toNumber($liquidationDetail->sum('debit') - $liquidationDetail->sum('credit'))}}</th>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        print();
    </script>
@endsection