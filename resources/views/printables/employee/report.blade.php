<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee PDS</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <link rel="stylesheet" href="{{ asset('template/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/print.css') }}?s={{\Illuminate\Support\Str::random()}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arial">

    <style type="text/css">
        body{
        @if($request->font != null)
               font-family: {{$request->font}};
        @endif
        }
        table tr th,td {
            vertical-align: top;
        @if($request->font_size != null)
               font-size: {{$request->font_size}};

        @endif
        }
    </style>
</head>



<body>
    @php($table_count = 0)
     @if(count($employees) >0)
         @foreach($employees as $k=>$category)
             @php($table_count++)
             @if($table_count <= 1)
                 @include('printables.employee.header')
                 <p class="text-center text-strong">
                     LIST OF EMPLOYEES
                 </p>
                 <div style="width: 100%; font-size: 11px; color: #0d6aad" class="text-right">
                     @if($filters_text != '')
                         FILTERS [<b>{{$filters_text}}</b>]
                     @endif
                 </div>
             @else
                @if($request->headers_per_table == 'headers_per_table')
                    @include('printables.employee.header')
                    <p class="text-center text-strong">
                        LIST OF EMPLOYEES
                    </p>
                    <div style="width: 100%; font-size: 11px; color: #0d6aad" class="text-right">
                        @if($filters_text != '')
                            FILTERS [<b>{{$filters_text}}</b>]
                        @endif
                    </div>
                @endif
             @endif


             <div {!! ($request->separate_page_per_table == 'separate_page_per_table') ? 'style="break-after: page"' : '' !!}>
                 <p class="text-strong">{{strtoupper($k)}}</p>
                 <table class="print-table">
                     <thead>
                     <tr>
                         <th>#</th>
{{--                         <th>Name</th>--}}
                         @if(!empty($selected_columns))
                             @foreach($selected_columns as $s_cols)
                                 <th>{{$all_columns[$s_cols]['name']}}</th>
                             @endforeach
                         @endif
                         @if($request->include_empty_field == 'include_empty_field')
                             <th></th>
                         @endif
                     </tr>

                     </thead>
                     <tbody>
                     @if(!empty($employees))
                         @php($num=0)
                         @foreach($category as $employee)
                             @php($num++)
                             <tr>
                                 <td style="width: 10px;">
                                     {{$num}}
                                 </td>
{{--                                 <td>{{$employee->lastname}}, {{$employee->firstname}} {{\Illuminate\Support\Str::limit($employee->middlename,1,'.')}}</td>--}}
                                 @if(!empty($selected_columns))
                                     @foreach($selected_columns as $s_cols)
                                         @switch($s_cols)
                                             @case('fullname')
                                             <td>{{$employee->full_name}} {{$employee->middle_initial}}</td>
                                             @break
                                             @case('age')
                                             <td>{{\Illuminate\Support\Carbon::parse($employee->date_of_birth)->age}}</td>
                                             @break
                                             @case('monthly_basic')
                                             <td class="text-right">{{number_format($employee->monthly_basic,2)}}</td>
                                             @break
                                             @case('date_of_birth')
                                             <td>{{\Illuminate\Support\Carbon::parse($employee->date_of_birth)->format('F d, Y')}}</td>
                                             @break
                                             @case('firstday_gov')
                                             <td>
                                                 {{($employee->firstday_gov != '') ? \Illuminate\Support\Carbon::parse($employee->firstday_gov)->format('F d, Y') : ''}}
                                             </td>
                                             @break
                                             @case('appointment_date')
                                             <td>
                                                 {{($employee->appointment_date != '') ? \Illuminate\Support\Carbon::parse($employee->appointment_date)->format('F d, Y') : ''}}
                                             </td>
                                             @break
                                             @case('adjustment_date')
                                             <td>
                                                 {{($employee->adjustment_date != '') ? \Illuminate\Support\Carbon::parse($employee->adjustment_date)->format('F d, Y') : ''}}
                                             </td>
                                             @break
                                            @case('cs_eligibility_level')
                                            <td>
                                                {{ucfirst(strtolower($employee->cs_eligibility_level))}} Level
                                            </td>
                                            @break
                                             @case('trainings')
                                             <td>
                                                 @if(!empty($employee->employeeTraining))
                                                     <ul style="padding-left: 20px !important;">
                                                         @foreach($employee->employeeTraining as $training)
                                                             <li>{{$training->title}} | {{$training->detailed_period}}</li>
                                                         @endforeach
                                                     </ul>
                                                 @endif
                                             </td>
                                             @break
                                             @case('service_records')
                                             <td>
                                                 @if(!empty($employee->employeeServiceRecord))
                                                     <ul style="padding-left: 20px !important;">
                                                         @foreach($employee->employeeServiceRecord as $sr)
                                                             <li>{{$sr->position}} [ {{$sr->from_date}} - {{($sr->upto_date != 1)? $sr->to_date : 'PRESENT'}} ]</li>
                                                         @endforeach
                                                     </ul>
                                                 @endif
                                             </td>
                                             @break
                                             @case('eligibility')
                                             <td>
                                                 @if(!empty($employee->employeeEligibility))
                                                     <ul style="padding-left: 20px !important;">
                                                         @foreach($employee->employeeEligibility as $el)
                                                             <li>{{$el->eligibility}}</li>
                                                         @endforeach
                                                     </ul>
                                                 @endif
                                             </td>
                                             @break
                                             @case('job_classification')
                                                 <td>
                                                     @if(!empty($employee->plantilla->classifications))
                                                         <ul style="padding-left: 20px !important;">
                                                             @foreach($employee->plantilla->classifications as $class)
                                                                 <li>{{$class->classification}}</li>
                                                             @endforeach
                                                         </ul>
                                                     @endif
                                                 </td>
                                                 @break
                                             @case('educational_background')
                                             <td>
                                                 @if(!empty($employee->employeeEducationalBackground))
                                                     <ul>
                                                         @foreach($employee->employeeEducationalBackground as $educ)
                                                             @if($educ->level != null)
                                                                 <li>{{$educ->level}} - {{$educ->school_name}} </li>
                                                             @endif
                                                         @endforeach
                                                     </ul>
                                                 @endif
                                             </td>
                                             @break
                                             @case('no_children')
                                             <td>
                                                 @if(!empty($employee->employeeChildren))
                                                     {{($employee->employeeChildren()->count() > 0) ? $employee->employeeChildren()->count() : ''}}
                                                 @endif
                                             </td>
                                             @break

                                             @case('dept_name')
                                                 <td>
                                                     {{$employee->responsibilityCenter->department ?? ''}}
                                                 </td>
                                             @break
                                             @case('division')
                                                 <td>
                                                     {{$employee->responsibilityCenter->division ?? ''}}
                                                 </td>
                                                 @break
                                             @case('section')
                                                 <td>
                                                     {{$employee->responsibilityCenter->section ?? ''}}
                                                 </td>
                                                 @break

                                             @default
                                             <td>{{$employee->$s_cols}}</td>
                                         @endswitch
                                     @endforeach
                                 @endif
                                 @if($request->include_empty_field == 'include_empty_field')
                                    <td style="width: 70px"></td>
                                 @endif
                             </tr>
                         @endforeach
                     @endif
                     </tbody>
                 </table>
                 <hr>
             </div>
             @if($request->separate_page_per_table == 'separate_page_per_table')
                 <div style="margin: 20px 0px" class="no-print">
                     <p class="no-margin" style="font-size: 12px; color: orangered">PAGE BREAK</p>
                     <div style="width: 100%; border: 1px dashed orangered" ></div>
                 </div>
             @endif

         @endforeach
     @else
         <h4 style="margin-top: 30px; text-align: center">No data found</h4>
     @endif


</body>
</html>