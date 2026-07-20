<table style="width: 100%; font-size: 14px" class="tbl-padded">
    <thead>
    <tr>
        <th class="text-center b-bottom">NO.</th>
        <th class="text-center b-bottom">DATE</th>
        <th class="text-center b-bottom">CHECK NO</th>
        <th class="text-center b-bottom">PARTICULARS</th>
        <th class="text-center b-bottom">EXPLANATION</th>
        <th class="text-center b-bottom">ACCOUNT TITLE</th>
        <th class="text-center b-bottom">DEBIT</th>
        <th class="text-center b-bottom">CREDIT</th>
    </tr>
    </thead>
    <tbody>
    @forelse($journals as $journal)
        @forelse($journal->entries as $entry)
            @if($loop->first)
                <tr>
                    <td class="text-center">{{$journal->control_no}}</td>
                    <td class="text-center">{{Helper::dateFormat($journal->date,'m/d/Y')}}</td>
                    <td class="text-center">{{$journal->check_no}}</td>
                    <td>{{$journal->counterparty}}</td>
                    <td>{{$journal->remarks}}</td>
                    <td><small>{{$entry->chartOfAccount->account_title}}</small></td>
                    <td class="text-right">{{Helper::toNumber($entry->debit)}}</td>
                    <td class="text-right">{{Helper::toNumber($entry->credit)}}</td>
                </tr>
            @elseif($loop->last)
                <tr>
                    <td class="b-bottom b-grey"></td>
                    <td class="b-bottom b-grey"></td>
                    <td class="b-bottom b-grey"></td>
                    <td class="b-bottom b-grey"></td>
                    <td class="b-bottom b-grey"></td>
                    <td class="b-bottom b-grey"><small>{{$entry->chartOfAccount->account_title}}</small></td>
                    <td class="text-right b-bottom b-grey">{{Helper::toNumber($entry->debit)}}</td>
                    <td class="text-right b-bottom b-grey">{{Helper::toNumber($entry->credit)}}</td>
                </tr>
            @else
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><small>{{$entry->chartOfAccount->account_title}}</small></td>
                    <td class="text-right">{{Helper::toNumber($entry->debit)}}</td>
                    <td class="text-right">{{Helper::toNumber($entry->credit)}}</td>
                </tr>
            @endif
        @empty
        @endforelse

    @empty
    @endforelse
    </tbody>
</table>