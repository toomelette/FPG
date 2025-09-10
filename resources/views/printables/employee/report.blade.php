@extends('printables.print_layouts.print_layout_main')
@section('wrapper')
<div style="font-family: Cambria">
    @php($table_count = 0)
    @if(count($employees) >0)
        @foreach($employees as $k=>$category)
            @php($table_count++)
            @if($table_count <= 1)
                @include('printables.employee.header')
                <p class="text-center text-strong">
                    LIST OF EMPLOYEES
                </p>
                <div style="width: 100%; font-size: 11px; color: #0d6aad" class="text-right">
                    @if($filters_text != '')
                        FILTERS [<b>{{$filters_text}}</b>]
                    @endif
                </div>
            @else
                @if($request->headers_per_table == 'headers_per_table')
                    @include('printables.employee.header')
                    <p class="text-center text-strong">
                        LIST OF EMPLOYEES
                    </p>
                    <div style="width: 100%; font-size: 11px; color: #0d6aad" class="text-right">
                        @if($filters_text != '')
                            FILTERS [<b>{{$filters_text}}</b>]
                        @endif
                    </div>
                @endif
            @endif


            <div {!! ($request->separate_page_per_table == 'separate_page_per_table') ? 'style="break-after: page"' : '' !!}>
                <p class="text-strong">{{strtoupper($k)}}</p>
                @include('printables.employee.tables.table-report')
                <hr>
            </div>
            @if($request->separate_page_per_table == 'separate_page_per_table')
                <div style="margin: 20px 0px" class="no-print">
                    <p class="no-margin" style="font-size: 12px; color: orangered">PAGE BREAK</p>
                    <div style="width: 100%; border: 1px dashed orangered" ></div>
                </div>
            @endif

        @endforeach
    @else
        <h4 style="margin-top: 30px; text-align: center">No data found</h4>
    @endif
</div>



@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection
