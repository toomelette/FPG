@php
    $days_in_this_month = \Carbon\Carbon::parse($month)->daysInMonth;
@endphp
<head>
    <style type="text/css">

        @font-face {
            font-family: 'HunDin';
            src: url({{ asset('fonts/print/HunDin.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;
        }


        @font-face {
            font-family: 'OS-Condenesed-Bold';
            src: url({{ asset('fonts/print/OpenSansCondensed-Bold.ttf') }}) format('truetype');
            font-weight: 400;
            font-style: normal;

        }

        @font-face {
            font-family: 'OS-Condenesed-Light';
            src: url({{ asset('fonts/print/OpenSansCondensed-Light.ttf') }}) format('truetype');
            font-style: normal;
        }

        .table-bordered,.table-bordered th,.table-bordered td {
            border: 1px solid grey;
            border-collapse: collapse;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }

        .text-left{
            text-align: left;
        }
        table td{
            font-family: "HunDin";
            padding: 4px 2px;

            font-size: 12px;
            font-weight: bold;
        }

        thead{
            font-family: "Helvetica";
        }
        p{
            font-size: 16px;
            font-family: "Helvetica";
        }
        .small-margin{
            margin: 5px 0;
        }
        .incomplete{
            color : #1e5ab3;
        }

        @page {
            size: A4 portrait;
            margin: 2%;
        }
        {{--.dtr-table tr  td:nth-child(2),td:nth-child(3),td:nth-child(4),td:nth-child(5),td:nth-child(6),td:nth-child(7) { background: url("{{asset('images/wm.png')}}");}--}}
        .text-blue{
            color: blue;
        }
        .text-red{
            color: red;
        }
    </style>

    <script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('template/plugins/html2canvas/html2canvas.js')}}"></script>
</head>
<div >

</div>
<div id="both"  style=" width: 780px; overflow: auto;">
    <div style="width: 48.5%; float: left; border-right: 1px dashed black">
        @include('_hru.dtr.dtr-content')
    </div>
    <div style="width: 48.5%; float: right;">
        @include('_hru.dtr.dtr-content')
    </div>

</div>
<button id="cap_btn">Caputre</button>
<div id="frameee">

</div>

<script type="text/javascript">
    $(document).ready(function () {
        window.onafterprint = function () {
            window.close();
        }

        html2canvas(document.querySelector("#both"),{
            scale: 3,
        }).then(canvas => {
            $('#frameee').append(canvas);
            $("#both").remove();
            $("#cap_btn").remove();
            setTimeout(function () {

                print();
            },500);
        });



    })


</script>