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