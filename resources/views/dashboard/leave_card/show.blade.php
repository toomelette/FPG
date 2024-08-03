@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>{{$employee->full['LFEMi']}} <small>Leave Cards</small></h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-green">SL</span>
                    <div class="info-box-content">
                        <span class="info-box-text">SICK LEAVE</span>
                        <span class="info-box-number">1,410</span>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-green">VL</span>
                    <div class="info-box-content">
                        <span class="info-box-text">VACATION LEAVE</span>
                        <span class="info-box-number">1,410</span>
                    </div>

                </div>
            </div>
        </div>

    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection