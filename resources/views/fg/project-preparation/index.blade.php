@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Project Preparation</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">

        <table class="mt-2 table table-bordered table-striped table-hover table-sm" id="applicants-table" style="width: 100% !important">
            <thead>
            <tr class="">
                <th>Control No</th>
                <th>Project</th>
                <th>Client</th>
                <th>Age</th>
                <th><small>Appln. Date</small></th>
                <th >SL</th>
                <th style="width: 80px;">Action</th>
                <th>Updated at</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection