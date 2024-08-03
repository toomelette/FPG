<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MIS Request Form - Print</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/print.css') }}?s={{\Illuminate\Support\Str::random()}}">


    <style type="text/css">

        .div-height{

            margin-bottom: -50px;
            padding-bottom: 50px;
            overflow: hidden;

        }

        .bordered td{
            border: 1px solid black;
            padding-left: 2px;
        }

        .top-left{
            float: left;
        }
        .no-margin{
            margin: 0 0 0 0;
        }
        .text-center{
            text-align: center;
        }
        .text-strong{
            font-weight: bold;
        }
        .f-12{
            font-size: 12px;
        }
        .f-9{
            font-size: 9px;
        }
        .no-border-top{
            border-top: 0px
        }
        .no-border-bottom{
            border-bottom: 0px
        }
        .no-border-left{
            border-left: 0px
        }
        .no-border-right{
            border-right: 0px
        }
        #dv_table{
            border-right: 2px solid black;
            border-left: 2px solid black;
            border-bottom: 2px solid black;
        }

        .details_table tr td:first-child{
            width: 25%;
        }
        /*.details_table  td{*/
        /*    line-height: 40px;*/
        /*}*/
    </style>

</head>

{{--<body onload="window.print();" onafterprint="window.close()">--}}
<body>

<div class="printable">

    <div style=" width: 100%; margin-bottom: 10px; overflow: auto">
        <div style="width: 25%; float: left">
            <center>
                <img src="{{ asset('images/sra.png') }}" style="width:100px;">
            </center>
        </div>
        <div style="width: 75%; float: right">
            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
            <p class="no-margin">PLANNING, POLICY, AND SPECIAL PROJECTS DEPARTMENT</p>
            <p class="no-margin text-strong">MIS SECTION - {{env('SERVER_LOCATION','')}}</p>
        </div>
    </div>

    <div style="width: 100%; overflow: auto">
        <div style="width: 49%; float: left">
            <p class="no-margin" style="font-weight: bold; font-size: 20px; padding-top: 8px">ICT SERVICE REQUEST FORM</p>
        </div>
        <div style="width: 49%; float: right">
            <table style="width: 100%;" class="bordered">
                <tr>

                    <td>Request No.</td>
                    <td><b>{{$r->request_no}}</b></td>
                </tr>
                <tr>
                    <td>
                        Date/Time
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($r->created_at)->format('M d, Y | h:i A')}}
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <br>
        <table style="width: 100%;" class="details_table bordered" >
            <tr>
                <td height="40">Nature of Request</td>
                <td>{{$r->nature_of_request}}</td>
            </tr>
            <tr>
                <td height="40">Details</td>
                <td>{{$r->request_details}}</td>
            </tr>
            <tr>
                <td height="40">Requisitioner</td>
                <td>{{$r->requisitioner}} </td>
            </tr>
        </table>

    <br>
    <table class="details_table bordered" style="width: 100%">
        <tr>
            <td height="40">Summary of Diagnostics</td>
            <td>{{$r->summary_of_diagnostics}}</td>
        </tr>
        <tr>
            <td height="40">Recommendations</td>
            <td>{{$r->recommendations}}</td>
        </tr>
    </table>
<br>
    <table style="width: 100%;" class="details_table bordered">
        <tr>
            <td height="40">Status</td>
            <td style="width: 30%"></td>
            <td style="width: 12%">
                Returned<br>
                <span style="font-size: smaller">(if equipment)</span>
            </td>
            <td>
                {{$r->returned}}
            </td>
        </tr>
        <tr>
            <td height="40">
                MIS Personnel
            </td>
            <td style="width: 30%"></td>
            <td style="width: 12%">
                Date Returned
            </td>
            <td>
                {{($r->date_returned == null )? '' : Carbon::parse($r->date_returned)->format('F d, Y')}}
            </td>
        </tr>
    </table>

</div>
    <table style="width: 100%; margin-top: 5px; font-size: 10px;">
        <tr>
            <td>
                {{\Carbon\Carbon::now()->format('Y')}}/PPSPD/MIS | {{\Illuminate\Support\Facades\Auth::user()->username}} | {{\Illuminate\Support\Facades\Request::ip()}}
            </td>
            <td style="text-align: right">
                rev 202203
            </td>
        </tr>
    </table>
<br>
<hr style="border: 1px dashed grey" class="no-margin">
<p class="no-margin" style="font-size: 8px"><i class="fa fa-scissors"></i> CUT HERE</p>
</body>
<script type="text/javascript">
    print();
</script>
</html>