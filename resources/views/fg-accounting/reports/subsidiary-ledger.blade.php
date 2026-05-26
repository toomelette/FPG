@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong">SUBSIDIARY LEDGER</h3>
        <p class="no-margin">{{$subsidiaryAccount->account_code}} | <span class="text-strong">{{$subsidiaryAccount->account_title}}</span> </p>
        <p class="no-margin">As of {{Carbon::parse(request('date_to'))->format('F d, Y')}}</p>
        <br>

        <table style="width: 100%; font-size: 14px">
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
                $runningBalance = 0;
            @endphp
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
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection