@extends('adminkit.master')

@section('content2')
    <div class="row" style="height: 75vh">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-90">
            <div class="d-table-cell align-middle">

                <div class="text-center">
                    <h1 class="display-1 fw-bold text-danger">503</h1>
                    <p class="h2">Internal server error.</p>
                    <p class="lead fw-normal mt-3 mb-4">
                        {{$exception->getMessage() == '' ? 'Contact MIS Personnel.' : $exception->getMessage()}}
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection