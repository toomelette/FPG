<html>
<head>
    <style>
        {!! \Illuminate\Support\Facades\Http::get(asset('template/plugins/print/bootstrap.print.css'))->body() !!}
        {!! \Illuminate\Support\Facades\Http::get(asset('template/bower_components/font-awesome/css/font-awesome.min.css'))->body() !!}
        {!! \Illuminate\Support\Facades\Http::get(asset('css/print.css').'?rand='.\Illuminate\Support\Str::random())->body() !!}
        {!! \Illuminate\Support\Facades\Http::get(asset('template/bower_components/font-awesome/css/font-awesome.min.css'))->body() !!}
    </style>

    <script type="text/javascript" src="{{asset('template/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <style type="text/css">
        .no-margin{
            margin: 0 0 0 0;
        }

        table {
            font-size: 12px
        }
        /*td, th {*/
        /*    padding: 5px !important*/
        /*}*/

        .text-stong{

        }

        @media print{
            .noPrint{
                display: none;
            }
        }
    </style>


</head>
<body onload="" onafterprint="">
<div class="wrapper" style="overflow:hidden !important;">
    @yield('wrapper')
</div>

<script type="text/javascript" src="{{ asset('template/plugins/fixed-header/table-fixed-header.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $("#loader").fadeOut(function(){
            $("#content").fadeIn(1000);
        })

        $(".table-fixed-header").fixedHeader({
            topOffset: 0
        });
    })
</script>

@yield('scripts')
</body></html>