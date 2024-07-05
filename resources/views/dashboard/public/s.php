@php
= \Illuminate\Support\Str::random();
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')


@endsection

@section('scripts')
<script type="text/javascript">

    $(document).ready(function () {
        let set = 625;
        if ($("#items_table_{{}}").height() < set) {
            let rem = set - $("#items_table_{{}}").height();
            $("#adjuster").css('height', rem)
            print();
        }
    })
    window.onafterprint = function () {
        window.close();
    }
</script>
@endsection