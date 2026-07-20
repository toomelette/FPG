@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong">ANALYSIS OF ACCOUNTS</h3>
        <p class="no-margin text-strong">{{$chartOfAccount->account_code}}</p>
        <p class="no-margin text-strong">{{$chartOfAccount->account_title}}</p>

        @include('fg-accounting.reports.analysis-of-accounts-table')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection