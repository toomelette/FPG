@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong">SUBSIDIARY LEDGER</h3>
        <p class="no-margin">{{$subsidiaryAccount->account_code}} | <span class="text-strong">{{$subsidiaryAccount->account_title}}</span> </p>
        <p class="no-margin">As of {{Carbon::parse(request('date_to'))->format('F d, Y')}}</p>
        <br>

        @include('fg-accounting.reports.subsidiary-ledger-table')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection