@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 14px">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-center text-strong no-margin">Trial Balance</h3>
        <p class="text-strong text-center">As of {{Carbon::parse(Request::get('month_to'))->lastOfMonth()->format('F d, Y')}}</p>


        <table style="width: 100%; font-size: 14px" class="tbl-padded">
            <thead>
            <tr>
                <th class="text-center b-bottom">Account Code</th>
                <th class="text-center b-bottom">Account Title</th>
                <th class="text-center b-bottom">Debit</th>
                <th class="text-center b-bottom">Credit</th>
                <th class="text-center b-bottom">Balance</th>
            </tr>
            </thead>
            <tbody>
            @forelse($chartOfAccounts as $chartOfAccount)
                <tr>
                    <td>{{$chartOfAccount->account_code}}</td>
                    <td>{{$chartOfAccount->account_title}}</td>
                    <td class="text-right">
                        {{Helper::toNumber($chartOfAccount->debit)}}
                    </td>
                    <td class="text-right">
                        {{Helper::toNumber($chartOfAccount->credit)}}
                    </td>
                    <td class="text-right">
                        {{Helper::accountingFormat($chartOfAccount->balance)}}
                    </td>
                </tr>
            @empty
            @endforelse
            <tr>
                <th class="b-top"></th>
                <th class="b-top"></th>
                <th class="b-top"></th>
                <th class="b-top"></th>
                <th class="b-top"></th>
            </tr>
            </tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection