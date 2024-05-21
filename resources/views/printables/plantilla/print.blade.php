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

        .bordered td,th{
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

        .department{
            background-color: #c7f2cd !important;
            -webkit-print-color-adjust: exact;
            font-weight: bold;
            font-size: 13px;
        }
        .division{
            background-color: #bff7ff !important;
            -webkit-print-color-adjust: exact;
            font-weight: bold;
            font-size: 13px;
        }
        .section{
            background-color: #f5deb8 !important;
            -webkit-print-color-adjust: exact;
            font-weight: bold;
            font-size: 13px;
        }
        table tbody tr td:nth-child(2){
            width: 15%;
        }
        table tbody tr td:nth-child(8){
            width: 7%;
        }
        table tbody tr td:nth-child(9){
            width: 15%;
        }
        table tbody tr td:nth-child(10){
            width: 7%;
        }
        table tbody tr td:nth-child(11){
            width: 7%;
        }

        table tbody tr td:nth-child(12){
            width: 7%;
        }
    </style>

</head>

{{--<body onload="window.print();" onafterprint="window.close()">--}}
<body>
    @foreach($planitillaArray as $k => $pls)
    <div class="printable"
         style="break-after: {{$request->separate_page_per_table == true ? 'page' : 'none'}};
                {{($request->font != null ? 'font-family: '.\App\Swep\Helpers\Arrays::fonts()[$request->font] : '')}};
         {{($request->font_size != null ? 'font-size: '.\App\Swep\Helpers\Arrays::fontSizes()[$request->font_size] : 'font-size: 12px')}};
                 ">
        @if($request->headers_per_table == true)
            <h3 class="text-center no-margin">SUGAR REGULATORY ADMINISTRATION</h3>
            <p class="text-center no-margin">PLANTILLA OF PERSONNEL</p>
            <p class="text-center no-margin">As of {{\Illuminate\Support\Carbon::now()->format('F d, Y')}}</p>
        @else
            @if($loop->index == 0)
                <h3 class="text-center no-margin">SUGAR REGULATORY ADMINISTRATION</h3>
                <p class="text-center no-margin">PLANTILLA OF PERSONNEL</p>
                <p class="text-center no-margin">As of {{\Illuminate\Support\Carbon::now()->format('F d, Y')}}</p>
            @endif
        @endif
        <p>
            @if($request->type == 'job_grade')
                JOB GRADE: <b>{{$k}}</b>
            @elseif($request->type == 'location')
                LOCATION: <b>{{$k}}</b>
            @elseif($request->type == 'department')
                DEPARTMENT: <b>{{$k}}</b>
            @endif
        </p>
        <table style="width: 100%;" class="bordered">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        @switch($column)
                            @case('item_no')
                                <th class="text-center" style="width: 20px">{{\App\Swep\Helpers\Arrays::plantillaColumnsForReport()[$column]['name']}}</th>
                            @break
                            @default
                                <th class="text-center">{{\App\Swep\Helpers\Arrays::plantillaColumnsForReport()[$column]['name']}}</th>
                            @break
                        @endswitch
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($pls as $department => $divisions)
                    <tr>
                        <td colspan="{{count($columns)}}" class="department">{{$department}}</td>
                    </tr>
                    @foreach($divisions as $key => $division)
                        @if(is_numeric($key))
                            <tr>
                                @foreach($columns as $column)
                                    @switch($column)
                                        @case('numbering')
                                            <td class="text-center"></td>
                                        @break

                                        @case('actual_salary')
                                        @case('actual_salary_gcg')
                                        <td class="text-right">{{number_format($division->$column,2)}}</td>
                                        @break

                                        @case('adjustment_date')
                                        @case('appointment_date')
                                        <td class="text-right">
                                            {{Helper::dateFormat($division->incumbentEmployee->$column ?? null,'m/d/Y')}}
                                        </td>
                                            @break
                                        @case('employee_name')
                                            <td class="">
                                                {{$division->incumbentEmployee->lastname ?? ''}}
                                                {{!empty($division->incumbentEmployee) ? ',':''}}
                                                {{$division->incumbentEmployee->firstname ?? ''}}
                                            </td>
                                        @break
                                        @case('educ_att')
                                            <td>
                                                {{$division->incumbentEmployee?->employeeEducationalBackground?->last()?->course}}
                                            </td>
                                            @break
                                        @case('eligibility')
                                            <td>
                                                @if(!empty($division->incumbentEmployee->employeeEligibility))
                                                    @foreach($division->incumbentEmployee->employeeEligibility as $elig)
                                                        {{$elig?->eligibility}};
                                                    @endforeach
                                                @endif
                                            </td>
                                            @break
                                        @default
                                            <td class="">{{$division->$column}}</td>
                                        @break
                                    @endswitch
                                @endforeach

                            </tr>
                        @else
                            <tr>
                                <td colspan="{{count($columns)}}" style="padding-left: 15px" class="division">{{$key}}</td>
                            </tr>
                            @foreach($division as $key2 => $section)
                                @if(is_numeric($key2))
                                    <tr>
                                        @foreach($columns as $column)
                                            @switch($column)
                                                @case('numbering')
                                                <td class="text-center"></td>
                                                @break

                                                @case('actual_salary')
                                                @case('actual_salary_gcg')
                                                    <td class="text-right">{{number_format($section->$column,2)}}</td>
                                                @break

                                                @case('last_promotion')
                                                @case('appointment_date')
                                                    <td class="text-right">
                                                        {{Helper::dateFormat($section->incumbentEmployee->$column ?? null,'m/d/Y')}}
                                                    </td>
                                                    @break
                                                @case('employee_name')
                                                    <td class="">
                                                        {{$section->incumbentEmployee->lastname ?? ''}}
                                                        {{!empty($section->incumbentEmployee) ? ',':''}}
                                                        {{$section->incumbentEmployee->firstname ?? ''}}
                                                    </td>
                                                    @break
                                                @case('educ_att')
                                                    <td>
                                                        {{$section->incumbentEmployee?->employeeEducationalBackground?->last()?->course}}
                                                    </td>
                                                    @break
                                                @case('eligibility')
                                                    <td>
                                                        @if(!empty($section->incumbentEmployee->employeeEligibility))
                                                            @foreach($section->incumbentEmployee->employeeEligibility as $elig)
                                                                {{$elig?->eligibility}};
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    @break
                                                @default
                                                <td class="">{{$section->$column}}</td>
                                                @break
                                            @endswitch
                                        @endforeach
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="{{count($columns)}}" style="padding-left: 30px;" class="section">{{$key2}}</td>
                                    </tr>
                                    @foreach($section as $item)
                                        <tr>
                                            @foreach($columns as $column)
                                                @switch($column)
                                                    @case('numbering')
                                                    <td class="text-center"></td>
                                                    @break
                                                    @case('actual_salary')
                                                    @case('actual_salary_gcg')
                                                        <td class="text-right">{{number_format($item->$column,2)}}</td>
                                                        @break
                                                    @case('last_promotion')
                                                    @case('appointment_date')
                                                        <td class="text-right">
                                                            {{Helper::dateFormat($item->incumbentEmployee->$column ?? null,'m/d/Y')}}
                                                        </td>
                                                        @break
                                                    @case('employee_name')
                                                        <td class="">
                                                            {{$item->incumbentEmployee->lastname ?? ''}}
                                                            {{!empty($item->incumbentEmployee) ? ',':''}}
                                                            {{$item->incumbentEmployee->firstname ?? ''}}
                                                        </td>
                                                        @break
                                                    @case('educ_att')
                                                        <td>
                                                            {{$item->incumbentEmployee?->employeeEducationalBackground?->last()?->course}}
                                                        </td>
                                                        @break
                                                    @case('eligibility')
                                                        <td>
                                                            @if(!empty($item->incumbentEmployee->employeeEligibility))
                                                                @foreach($item->incumbentEmployee->employeeEligibility as $elig)
                                                                    {{$elig?->eligibility}};
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        @break
                                                    @default
                                                    <td class="">{{$item->$column}}</td>
                                                    @break
                                                @endswitch
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach
</body>
</html>