<html>
<head>
    <style>
        body{
            font-family: Calibri !important;
        }

        .edit_form{
            margin-bottom: 0px;
        }

    </style>
    <link type="text/css" rel="stylesheet" href="{{asset('css/print.css')}}?rand={{\Illuminate\Support\Str::random()}}">
    <script type="text/javascript" src="{{ asset('template/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <title>
        SERVICE RECORD
    </title>
</head>
<body onload="window.print();">
    @php
        $srArray = [];
        if(!empty($employee->employeeServiceRecord)){
            foreach ($employee->employeeServiceRecord as $sr){
                array_push($srArray,$sr);
            }
        }

    @endphp
    @php($numberOfItems = \Illuminate\Support\Facades\Request::get('no_of_items') ?? 30)
    @if(count($employee->employeeServiceRecord)  % $numberOfItems == 0)
        @php($pages = $employee->employeeServiceRecord->count() / $numberOfItems)
    @else
        @php($pages = floor($employee->employeeServiceRecord->count() / $numberOfItems) + 1)
    @endif

    @for($i = 0; $i < $pages; $i++)
        <table style="width: 100%" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td  rowspan="3" class="" style="width: 27%">
                    <div style=" width: 100%">
                        <div style="width: 100%; float: left">
                            <center>
                                <img src="{{ asset('images/sra.png') }}" style="width:80px; float: right">
                            </center>
                        </div>

                    </div>
                </td>
                <td rowspan="3" class="text-center no no-border-bottom no-border-left" style="width: 35%">
                    <p class="no-margin">Republic of the Philippines</p>
                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                    <p class="no-margin">{{App\Swep\Helpers\Get::setting('header_address')->string_value ?? 'SET HEADER !!!'}}</p>
                </td>
                <td style="width: 20%; vertical-align: top; text-align: right">
                    <p class="no-margin" style="font-size: 11px">Page {{$i+1}} of {{$pages}}</p>
                </td>
            </tr>

            </tbody>
        </table>


        <div {!! ($i+1 == $pages) ? '' : 'style="break-after: page"' !!}>
            <table style="width: 100%; font-size: 11px">
                <tbody>
                <tr>
                    <td>
                        @if(env('SERVER_LOCATION','VIS') == 'VIS')
                            BP Number: <span class="text-strong b-bottom">{{$employee->gsis}}</span>
                        @else

                        @endif
                    </td>
                    <td></td>

                </tr>
                <tr>
                    <td>Emp No.: <span class="text-strong b-bottom">{{$employee->employee_no}}</span> </td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-center" >
                        <p class="no-margin text-strong" style="font-size: 28px"> SERVICE RECORD</p>
                        <p class="no-margin">(To Be Accomplished By Employer)</p>
                    </td>
                </tr>
                </tbody>
            </table>
            <table style="width: 100%; font-size: 13px">
                <tbody>
                <tr>
                    <td>NAME</td>
                    <td class="b-bottom text-strong" style="font-size: 15px">{{$employee->lastname}}</td>
                    <td class="b-bottom text-strong" style="font-size: 15px">{{$employee->firstname}} {{$employee->name_ext}}</td>
                    <td class="b-bottom text-strong" style="font-size: 15px">{{$employee->middlename}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Surname</td>
                    <td>Given Name</td>
                    <td>Middle Name</td>
                </tr>
                <tr >
                    <td style="margin-top: 15px">BIRTH</td>
                    <td class="b-bottom text-strong" style="font-size: 15px">{{\Illuminate\Support\Carbon::parse($employee->date_of_birth)->format('F d, Y')}}</td>
                    <td>
                        PLACE OF BIRTH
                    </td>
                    <td class="b-bottom text-strong" style="font-size: 15px">{{$employee->place_of_birth}}</td>
                </tr>
                </tbody>
            </table>
            <p style="font-size: 9px">This is to certify that the employee hereinabove actually rendered services in this Office as shown by the service record below, each line of which is supported by appointment and other papers actually issued by this office.</p>
            <table style="width: 100%; font-size: 10px" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th colspan="2" class="b-top b-left b-bottom">SERVICE</th>
                    <th colspan="3" class="b-top b-left b-bottom">RECORD OF APPOINTMENT</th>
                    <th rowspan="2" class="b-top b-left b-bottom">OFFICE/STATION</th>
                    <th rowspan="2" class="b-top b-left b-bottom">LEAVE W/o PAY</th>
                    <th colspan="2" class="b-top b-left b-bottom">SEPARATION</th>
                    <th rowspan="2" class="b-top b-left b-bottom b-right" style="width: 12%">REMARKS</th>
                </tr>
                <tr>
                    <th class="b-bottom b-left">From</th>
                    <th class="b-bottom b-left">To</th>
                    <th class="b-bottom b-left">Designation</th>
                    <th class="b-bottom b-left">Status</th>
                    <th class="b-bottom b-left">Salary</th>
                    <th class="b-bottom b-left">Date</th>
                    <th class="b-bottom b-left">Cause</th>
                </tr>
                </thead>
                <tbody>
                @foreach($srArray as $key => $sr)
                    @if($key <= ($i + 1) * $numberOfItems - 1 && $key >= $i * $numberOfItems)
                        <tr>
                            <td class="text-center">{{\Illuminate\Support\Carbon::parse($srArray[$key]->from_date)->format('m/d/Y')}}</td>
                            <td class="text-center">{{($srArray[$key]->upto_date == 1) ? 'PRESENT' : \Illuminate\Support\Carbon::parse($srArray[$key]->to_date)->format('m/d/Y')}}</td>
                            <td>{{$srArray[$key]->position}}</td>
                            <td>{{$srArray[$key]->appointment_status}}</td>
                            <td>{{number_format($srArray[$key]->salary,2)}} / A</td>
                            <td class="text-center">{{$srArray[$key]->station}}</td>
                            <td class="text-center">{{$srArray[$key]->lwp}}</td>
                            <td class="text-center">{{$srArray[$key]->spdate}}</td>
                            <td class="text-center">{{$srArray[$key]->status}}</td>
                            <td class="text-center" style="font-size: 8px">{{$srArray[$key]->remarks}}</td>
                        </tr>
                    @endif

                @endforeach
                <tr>
                    <td colspan="10" class="b-top"></td>
                </tr>
                </tbody>
            </table>
            @if ($i+1 == $pages)
                <p style="font-size:9px;">Issued in Compliance with No. 54 dated August 10, 1954 and in accordance with Circular No. 58 dated August 10, 1954 of the System.</p>

                <br>

                <table style="width: 100%;font-size: 14px">
                    <tbody>
                        <tr>
                            <td style="width: 15%; font-size: 13px">PREPARED BY:</td>
                            <td style="width: 35%"></td>
                            <td style="width: 15%; font-size: 13px">CERTIFIED CORRECT:</td>
                            <td style="width: 33%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="b-bottom text-center text-strong" style="font-size: 15px"><br>{{\Illuminate\Support\Facades\Request::get('pn')}}</td>
                            <td></td>
                            <td class="b-bottom text-center text-strong" style="font-size: 15px"><br>{{\Illuminate\Support\Facades\Request::get('cn')}}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center">(Chief or Head of Office)</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="b-bottom text-center"><br>{{\Illuminate\Support\Facades\Request::get('pp')}}</td>
                            <td></td>
                            <td class="b-bottom text-center"><br>{{\Illuminate\Support\Facades\Request::get('cp')}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">(Designation)</td>
                            <td></td>
                            <td class="text-center">(Designation)<td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%;font-size: 14px">
                    <tbody>
                        @if(\Illuminate\Support\Facades\Request::get('an') != '')
                            <tr>
                                <td></td>
                                <td class="text-center">APPROVED BY:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="b-bottom text-center text-strong" style="font-size: 15px">
                                    <br><br>
                                    {{\Illuminate\Support\Facades\Request::get('an')}}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center">
                                    {{\Illuminate\Support\Facades\Request::get('ap')}}
                                </td>
                                <td></td>
                            </tr>
                        @endif

                        <tr>
                            <td  style="width: 30%"></td>
                            <td class="b-bottom text-center text-strong" style="font-size: 15px">
                                <br>
                                {{\Illuminate\Support\Carbon::now()->format('F d, Y')}}
                            </td>
                            <td  style="width: 30%"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                Date
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    @endfor

</body>
</html>