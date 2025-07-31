@extends('adminkit.modal')

@section('modal-header')
    Request Timeline
@endsection

@section('modal-body')
    @include('_hru.hr-requests.portion-timeline')
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" data-bs-dismiss="modal" type="submit"> Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection