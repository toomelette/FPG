<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="icon" href="{{asset('images/sra_only2_low.png')}}" type="image/icon type">


    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>SRA | HRRS</title>
    <meta property="og:title" content="SRA Web Portal"/>
    <meta property="og:image" content="{{asset('/images/og-image.png')}}"/>
    <meta property="og:image:type" content="image/png">
    <meta property="og:description" content="HRRS"/>
    <meta property="og:url" content="https://hrrs.sra.gov.ph/"/>
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="628" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('adminkit/adminkit-css/bootstrap-icons.css')}}" crossorigin="anonymous">
    <link href="{{asset('adminkit/main/static/css/light.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    @include('adminkit.css')
</head>

<body>
<div class="wrapper">

    @include('adminkit.sidebar')

    <div class="main">
        @include('adminkit.topbar')

        <main class="content">
            <div class="container-fluid p-0">
                @yield('content')

                @yield('content2')
            </div>
        </main>
        @include('adminkit.footer')

    </div>
</div>


<div style="display: none;">
    <div class="modal_loader">

        <center>
            <div class="spinner-border text-primary m-5" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </center>
    </div>
</div>


<script src="{{asset('adminkit/main/static/js/app.js')}}"></script>

@include('adminkit.js')
<script type="text/javascript">
    function modalPlaceholder(){
        return $(".modal_loader").parent('div').html();
    }
    @if(\Illuminate\Support\Facades\Request::has('find'))
        var find = '{{\Illuminate\Support\Facades\Request::get('find')}}';
    @else
        var find = '';
    @endif

    $("body").on("click",".print-btn-dialog",function (){
        let href = $(this).attr('href');
        window.open(href, "popupWindow", "width=1200, height=800, scrollbars=yes");
    })




    $(".sidebar-nav a[href='{{url()->current()}}']").parent('li').addClass('active');
    $(".sidebar-nav a[href='{{url()->current()}}']").parents('.sidebar-dropdown').addClass('show');
    $(".sidebar-nav a[href='{{url()->current()}}']").parents('.sidebar-dropdown').siblings('.sidebar-link').removeClass('collapsed');
    $(".sidebar-nav a[href='{{url()->current()}}']").parents('.sidebar-item').addClass('active');
</script>
@yield('modals')
@yield('scripts')
</body>

</html>