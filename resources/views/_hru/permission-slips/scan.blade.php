@extends('adminkit.master')

@section('content2')

    <div class="row">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2">Scan Permission Slip</h1>
                </div>
                <div id="reader" width="600px"></div>
            </div>
        </div>
    </div>

@endsection


@section('modals')
    <x-adminkit.html.modal id="update-ps-time-modal" size="sm"/>
@endsection

@section('scripts')


    <script type="text/javascript">
        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            $("#update-ps-time-modal").modal('show');
            $("#update-ps-time-modal .modal-content").html(modal_loader_placeholder);
            html5QrcodeScanner.pause();
            $.ajax({
                url : '{{route("dashboard.permission_slip.log")}}?scan=true',
                data : {
                    ps_no : decodedText
                },
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#update-ps-time-modal .modal-content").html(res);
                },
                error: function (res) {

                }
            })
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);

        $('#update-ps-time-modal').on('hidden.bs.modal', function (e) {
            html5QrcodeScanner.resume();
        })
    </script>
@endsection