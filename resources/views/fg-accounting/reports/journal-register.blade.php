@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h4 class="text-strong no-margin">Fil Power Group & Marketing Corp.</h4>
        <p>{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong no-margin">
            {{$request->book == 'GENERAL JOURNAL' ? $request->book : $request->book.'S'}} REGISTER
        </h3>
        <p>
            Period Covered:
            @if(filled($request->date_from) && filled($request->date_to))
                From {{Helper::dateFormat($request->date_from)}} to {{Helper::dateFormat($request->date_to)}}
            @endif
            @if(filled($request->date_from) && blank($request->date_to))
                From {{Helper::dateFormat($request->date_from)}} to {{now()->format('M. d, Y')}}
            @endif
            @if(blank($request->date_from) && filled($request->date_to))
               Until {{Helper::dateFormat($request->date_to)}}
            @endif
            @if(blank($request->date_from) && blank($request->date_to))
                Until {{now()->format('M. d, Y')}}
            @endif
        </p>

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

        @php
            $accountsUsed = $journals->pluck('entries')
                ->flatten()
                ->groupBy('account_code')
                ->sortKeys();
        @endphp
        <h4 style="margin-top: 50px">RECAPITULATION</h4>
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
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection