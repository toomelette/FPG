@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong">SCHEDULE OF ACCOUNTS</h3>
        <p class="no-margin">
            <span class="text-strong">{{$chartOfAccount->account_title}}</span> | {{$chartOfAccount->account_code}}
        </p>
        <p class="no-margin">As of {{Carbon::parse(request('date_to'))->format('F Y')}}</p>
        <br>

        <table style="width: 100%; font-size: 14px">
            <thead>
            <tr>
                <th class="text-center b-all" rowspan="2">ACCOUNT NO.</th>
                <th class="text-center b-all" rowspan="2">ACCOUNT NAME</th>
                <th class="text-center b-all" rowspan="2">BEGINNING BALANCE</th>
                <th class="text-center b-all" colspan="2">TRANSACTIONS FOR {{Str::of(Carbon::parse(request('date_to'))->format('M Y'))->upper()}}</th>
                <th class="text-center b-all" rowspan="2">ENDING BALANCE</th>
            </tr>
            <tr>
                <th class="text-center b-all" >DEBIT</th>
                <th class="text-center b-all" >CREDIT</th>

            </tr>
            </thead>
            <tbody>
            @forelse($usedSubsidiaryAccounts as $subsidiaryAccount)
                @php
                    $accountOnCutoff = $accountsOnCutoff->firstWhere('account_code',$subsidiaryAccount->account_code);
                    $accountOnSelectedMonth =  $accountsOnSelectedMonth->firstWhere('account_code',$subsidiaryAccount->account_code);
                    $beginningBalance = $accountOnCutoff?->debit - $accountOnCutoff?->credit;
                    $endingBalance = $beginningBalance + $accountOnSelectedMonth?->debit - $accountOnSelectedMonth?->credit;
                @endphp
                <tr>
                    <td>{{$subsidiaryAccount->account_code}}</td>
                    <td>{{$subsidiaryAccount->account_title}}</td>
                    <td class="text-right">{{Helper::accountingFormat($beginningBalance)}}</td>
                    <td class="text-right">{{Helper::accountingFormat($accountOnSelectedMonth?->debit)}}</td>
                    <td class="text-right">{{Helper::accountingFormat($accountOnSelectedMonth?->credit)}}</td>
                    <td class="text-right">{{Helper::accountingFormat($endingBalance)}}</td>
                </tr>
            @empty
            @endforelse
            <tr>
                <td class="b-top"></td>
                <td class="b-top"></td>
                <td class="b-top text-right">
                    {{Helper::accountingFormat($bbTotal = $accountsOnCutoff->sum('debit') - $accountsOnCutoff->sum('credit'))}}
                </td>
                <td class="b-top text-right">
                    {{Helper::accountingFormat($debitTotal = $accountsOnSelectedMonth->sum('debit'))}}
                </td>
                <td class="b-top text-right">
                    {{Helper::accountingFormat($creditTotal = $accountsOnSelectedMonth->sum('credit'))}}
                </td>
                <td class="b-top text-right">
                    {{Helper::accountingFormat($bbTotal + $debitTotal - $creditTotal)}}
                </td>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection