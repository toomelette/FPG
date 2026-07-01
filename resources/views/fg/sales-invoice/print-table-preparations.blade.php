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