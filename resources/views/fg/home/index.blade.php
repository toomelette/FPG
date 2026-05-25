@extends('adminkit.master')

@section('content2')


    <div class="row" style="height: 75vh">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-90">
            <div class="d-table-cell align-middle">

                <div class="text-center mt-4">
                    <h1 class="h2">Welcome back {{Str::of(Auth::user()->employee->firstname)->lower()->title()}}!</h1>
                    <p class="lead">
                        Today is {{now()->format('l, F d, Y')}}
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