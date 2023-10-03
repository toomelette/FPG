@php
$rand = \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <table style="width: 100%" class="tbl tbl-bordered tbl-padded">
        <th class="text-center">
            Account Name
        </th>
        <th class="text-center">Account Code</th>
        @forelse($depts as $key => $dept)
            <th class="text-center">{{$untouchedDepartmentList[$key]}}</th>
        @empty
        @endforelse
        <tbody>
        @php
            $totals = $depts;
        @endphp
        @forelse($accounts as $accountCode => $accountEntry)
            <tr>
                <td>{{$untouchedCoa[$accountCode]}}</td>
                <td>{{$accountCode}}</td>
                @forelse($depts as $key => $dept)
                    <th class="text-right">{{Helper::toNumber($accounts[$accountCode][$key] ?? '',2)}}</th>
                    @php
                        $totals[$key] = $totals[$key] + ($accounts[$accountCode][$key] ?? 0);
                    @endphp
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2">TOTAL</th>
            @forelse($totals as $total)
                <th class="text-right">{{Helper::toNumber($total,2)}}</th>
            @empty
            @endforelse
        </tr>
        </tfoot>
    </table>

@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function () {
        let set = 625;
        if ($("#items_table_{{$rand}}").height() < set) {
            let rem = set - $("#items_table_{{$rand}}").height();
            $("#adjuster").css('height', rem)
            print();
        }
    })
    window.onafterprint = function () {
        window.close();
    }
</script>
@endsection