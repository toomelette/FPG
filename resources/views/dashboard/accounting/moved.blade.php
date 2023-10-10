@extends('layouts.admin-master')

@section('content')

    <section class="content">
        <div class='text-center' style="margin-top:10%;">
            <h1><span style="font-size: 120px; color: grey"><i class="fa fa-exclamation-triangle"></i></span></h1>
            <h1>Migration Notice</h1>
            <p>All modules pertaining to <b>ACCOUNTING</b> have been moved to:</p>
            <h3><a href="http://accounting.sra.gov.ph/"> http://accounting.sra.gov.ph/</a> </h3>
            <br>
            <p><a href="http://10.36.1.14:8011/"> http://10.36.1.14:8011/</a> for local use in SRA Bacolod Network</p>
            <h5 class="text-danger"><i class="fa fa-warning"></i> <b>This module will soon be removed from SWEP-AFD</b></h5>
        </div>
    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection