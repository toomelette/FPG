@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria">
        <h4 class="text-strong no-margin">Fil Power Group & Marketing Corp.</h4>
        <p>{{\App\Swep\Helpers\Get::address()}}</p>
        <h3 class="text-strong no-margin">
            SALES INVOICE SUMMARY
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

            @if(filled($request->stations))
                <br>
                STATIONS: <b>{{implode(', ',$request->stations)}}</b>
            @endif

        </p>
        @include('fg.invoice-reports.sales-invoice-summary-table')
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
    </script>
@endsection