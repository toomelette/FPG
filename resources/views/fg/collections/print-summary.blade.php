@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <tr>
                <td style="width: 80%;">
                    <p class="no-margin text-strong" style="font-size: 28px">{{\App\Swep\Helpers\Get::company()}}</p>
                    <p class="no-margin" style="font-size: 18px">{{\App\Swep\Helpers\Get::address()}}</p>
                </td>
            </tr>
        </table>
        <br>
        <p class="text-center text-strong">COLLECTION SUMMARY</p>
        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-all">Date</th>
                <th class="text-center b-all">Receipt #</th>
                <th class="text-center b-all">Customer</th>
                <th class="text-center b-all">Invoice / Billing of Charge Invoice #</th>
                <th class="text-center b-all">Amount</th>
            </tr>
            </thead>
            <tbody>
            @forelse($collections as $collection)
                <tr>
                    <td>{{Helper::dateFormat($collection->date,'m/d/Y')}}</td>
                    <td>{{$collection->ref_no}}</td>
                    <td>{{$collection->client->name}}</td>
                    <td>{{implode('; ',$collection->distributions->pluck('invoice.invoice_no')->toArray())}}</td>
                    <td class="text-right">{{Helper::toNumber($collection->total_paid)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th colspan="4" class="b-top">TOTAL</th>
                <th class="text-right b-top">{{Helper::toNumber($collections->sum('total_amount'))}}</th>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
@endsection