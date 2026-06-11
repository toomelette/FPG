@extends('adminkit.modal')

@section('modal-header')
    {{request('counterparty')}}
@endsection

@section('modal-body')
    <table class="table table-bordered table-striped table-sm">
        <thead>
        <tr>
            <th>Book</th>
            <th>Control No</th>
            <th>Explanation</th>
            <th>Check Amount</th>
            <th>Cash Amount</th>
        </tr>
        </thead>
        <tbody>
        @forelse($journals as $journal)
            <tr>
                <td>{{Helper::getInitials($journal->book)}}</td>
                <td>{{$journal->control_no}}</td>
                <td>{{$journal->remarks}}</td>
                <td class="text-end">{{Helper::toNumber($journal->check_amount)}}</td>
                <td class="text-end">{{Helper::toNumber($journal->cash_amount)}}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection