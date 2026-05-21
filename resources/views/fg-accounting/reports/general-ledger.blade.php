@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 14px">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-center text-strong">GENERAL LEDGER</h3>
        <p class="no-margin text-strong">{{$chartOfAccount->account_code}}</p>
        <p class="no-margin text-strong">{{$chartOfAccount->account_title}}</p>

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
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection