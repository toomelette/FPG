<table style="width: 100%; font-size: 14px; margin-top: 10px" class="tbl-padded">
    <thead>
    <tr>
        <th class="b-bottom text-center">DATE</th>
        <th class="b-bottom text-center">BOOK</th>
        <th class="b-bottom text-center">REF #</th>
        <th class="b-bottom text-center">CHECK NO.</th>
        <th class="b-bottom text-center">PARTICULARS</th>
        <th class="b-bottom text-center">EXPLANATION</th>
        <th class="b-bottom text-center">DEBIT</th>
        <th class="b-bottom text-center">CREDIT</th>
        <th class="b-bottom text-center">BALANCE</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{Carbon::parse(request('date_from'))->subDay()->format('m/d/Y')}}</td>
        <td>BB</td>
        <td></td>
        <td></td>
        <td>BALANCE FORWARDED</td>
        <td>BALANCE FORWARDED</td>
        <td class="text-right">{{Helper::accountingFormat($balanceForwarded->debit)}}</td>
        <td class="text-right">{{Helper::accountingFormat($balanceForwarded->credit)}}</td>
        <td class="text-right">{{Helper::accountingFormat($runningBalance = $balanceForwarded->debit - $balanceForwarded->credit)}}</td>
    </tr>
    @forelse($journalEntries as $journalEntry)
        @php
            $runningBalance = $runningBalance + $journalEntry->debit - $journalEntry->credit;
        @endphp
        <tr>
            <td>{{Helper::dateFormat($journalEntry->date,'m/d/Y')}}</td>
            <td>{{$journalEntry->book}}</td>
            <td>{{$journalEntry->control_no}}</td>
            <td>{{$journalEntry->check_no}}</td>
            <td>{{$journalEntry->counterparty}}</td>
            <td>{{$journalEntry->remarks}}</td>
            <td class="text-right">{{Helper::accountingFormat($journalEntry->debit)}}</td>
            <td class="text-right">{{Helper::accountingFormat($journalEntry->credit)}}</td>
            <td class="text-right">{{Helper::accountingFormat($runningBalance)}}</td>
        </tr>
    @empty
    @endforelse
    <tr>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
    </tr>
    </tbody>
</table>