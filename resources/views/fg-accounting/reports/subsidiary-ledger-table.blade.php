<table style="width: 100%; font-size: 14px" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center b-bottom">DATE</th>
        <th class="text-center b-bottom">PARTICULARS</th>
        <th class="text-center b-bottom">REF BOOK</th>
        <th class="text-center b-bottom">REF JEV NO</th>
        <th class="text-center b-bottom">DEBIT</th>
        <th class="text-center b-bottom">CREDIT</th>
        <th class="text-center b-bottom">BALANCE</th>
    </tr>
    </thead>
    <tbody>
    @php
        $runningBalance = $begBal->total_debit - $begBal->total_credit;
    @endphp
    <tr>
        <td colspan="6">Beginning Balance</td>
        <td class="text-right">{{number_format($runningBalance,2)}}</td>
    </tr>
    @forelse($lines as $line)
        @php
            $runningBalance += $line->debit - $line->credit;
        @endphp
        <tr>
            <td>{{Helper::dateFormat($line->date,'m/d/Y')}}</td>
            <td>{{$line->remarks}}</td>
            <td class="text-center">{{\App\Swep\Helpers\Helper::getInitials($line->book)}}</td>
            <td>{{$line->control_no}}</td>
            <td class="text-right">{{Helper::accountingFormat($line->debit)}}</td>
            <td class="text-right">{{Helper::accountingFormat($line->credit)}}</td>
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
    </tr>
    </tbody>
</table>