@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 14px">
        <h3 class="text-strong no-margin">{{\App\Swep\Helpers\Get::company()}}</h3>
        <p class="no-margin">{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-center text-strong no-margin">Trial Balance</h3>
        <p class="text-strong text-center">As of {{Carbon::parse(Request::get('month_to'))->lastOfMonth()->format('F d, Y')}}</p>


        @include('fg-accounting.reports.trial-balance-table')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection