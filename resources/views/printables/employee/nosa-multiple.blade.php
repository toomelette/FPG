@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    @forelse($srs as $sr)
        @php
            $employee = $sr['employee'];
            $request = $sr['request'];
        @endphp
        <div style="break-after: page">
            @include('printables.employee.partials.nosa-hrs-034-02')
        </div>
    @empty
    @endforelse
@endsection

@section('scripts')
    <script type="text/javascript">
        print();
    </script>
@endsection