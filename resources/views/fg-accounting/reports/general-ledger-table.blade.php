<table style="width: 100%; font-size: 14px; margin-top: 10px" class="tbl-padded">
    <thead>
    <tr>
        <th class="b-bottom text-center">DATE</th>
        <th class="b-bottom text-center">BOOK</th>
        <th class="b-bottom text-center">DEBIT</th>
        <th class="b-bottom text-center">CREDIT</th>
        <th class="b-bottom text-center">BALANCE</th>
    </tr>
    </thead>
    <tbody>
    @php
        $runningBalance = 0;
    @endphp
    @forelse($months as $month => $books)
        @forelse($books as $book => $entries)
            <tr>
                <td>{{$loop->first ? Carbon::parse($month)->format('M d, Y') : ''}}</td>
                <td>{{$book}}</td>
                <td class="text-right">{{Helper::accountingFormat($debit = $entries->sum('debit'))}}</td>
                <td class="text-right">{{Helper::accountingFormat($credit = $entries->sum('credit'))}}</td>
                <td class="text-right">{{Helper::accountingFormat($runningBalance = $runningBalance + $debit - $credit)}}</td>
            </tr>
        @empty
        @endforelse
    @empty
    @endforelse
    <tr>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
        <td class="b-top"></td>
    </tr>
    </tbody>
</table>