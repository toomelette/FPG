@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$stock->name}}</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
        <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th>Date</th>
                <th>Control No.</th>
                <th>Description</th>
                <th>UOM</th>
                <th>REF DOC</th>
                <th>Add</th>
                <th>Less</th>
                <th>Balance</th>
            </tr>
            </thead>
            <tbody>
            @php
                $runningBalance = 0;
            @endphp
            @forelse($ledger as $line)
                @php
                    $runningBalance = $runningBalance + $line->movement;
                @endphp
                <tr>
                    <td>{{Helper::dateFormat($line->date,'M d, Y')}}</td>
                    <td>{{$line->control_no}}</td>
                    <td>{{$line->remarks}}</td>
                    <td>{{$line->uom}}</td>
                    <td>{{$line->book}}</td>
                    @if($line->direction == 1)
                        <td class="text-center">{{$line->qty}}</td>
                        <td class="text-center"></td>
                    @endif
                    @if($line->direction == -1)
                        <td class="text-center"></td>
                        <td class="text-center">{{$line->qty}}</td>
                    @endif
                    <td class="text-center " @if($loop->last) style="background-color: #deffe7" @endif>

                        {{$runningBalance}}
                    </td>
                </tr>
            @empty
            @endforelse
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