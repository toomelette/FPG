<table style="width: 55%; font-size: 14px">
    <thead>
    <tr>
        <th class="b-bottom">Account Code</th>
        <th class="b-bottom">Account Title</th>
        <th class="b-bottom">Debit</th>
        <th class="b-bottom">Credit</th>
    </tr>
    </thead>
    <tbody>
    @forelse($accountsUsed as $accountCode => $accountUsed)
        <tr>
            <td>{{$accountCode}}</td>
            <td>{{$accountUsed->first()->chartOfAccount->account_title}} </td>
            <td class="text-right">{{Helper::toNumber($accountUsed->sum('debit'))}}</td>
            <td class="text-right">{{Helper::toNumber($accountUsed->sum('credit'))}}</td>
        </tr>
    @empty
    @endforelse
    @php
        $all = $accountsUsed->flatten();
    @endphp
    <tr>
        <td class="b-top text-strong"></td>
        <td class="b-top text-strong">TOTAL</td>
        <td class="text-right b-top text-strong">{{Helper::toNumber($all->sum('debit'))}}</td>
        <td class="text-right b-top text-strong">{{Helper::toNumber($all->sum('credit'))}}</td>
    </tr>
    </tbody>
</table>