@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
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

    <div style="font-family: Cambria; {!! ($i+1 == $pages) ? '' : 'break-after: page' !!}" >
        <table style="width: 100%; font-size: 14px" class="">
            <tr>
                <td style="width: 25%;" class="text-top">Form No. CR-2</td>
                <td style="width: 50%;" class="text-center text-strong text-top">
                    SUGAR REGULATORY ADMINISTRATION <br>
                    {{\App\Swep\Helpers\Get::headerAddress()}}
                </td>
                <td style="width: 25%;" class="text-right text-top">
                    Employee No.: <u>{{$employee->employee_no}}</u><br>
                    BP No.: <u>{{$employee->gsis}}</u>
                </td>
            </tr>
        </table>
        <p class="no-margin text-center text-strong" style="margin-top: 10px; letter-spacing: 3px">SERVICE RECORD</p>
        <p class="no-margin text-center">(To be accomplished by Employer)</p>
        <table style="width: 100%" class="tbl-padded">
            <tr>
                <td style="width: 70%;" class="text-top b-top b-right b-bottom">
                    <table style="width: 100%;" class="">
                        <tr>
                            <td>NAME:</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; height: 30px" class="text-bottom text-strong">
                                {{$employee->lastname}}
                            </td>
                            <td style="font-size: 15px; height: 30px" class="text-bottom text-strong">
                                {{$employee->firstname}} {{$employee->name_ext}}
                            </td>
                            <td style="font-size: 15px; height: 30px" class="text-bottom text-strong">
                                {{$employee->middle_initial}}
                            </td>
                        </tr>
                        <tr>
                            <td class="b-top">
                                (SURNAME)
                            </td>
                            <td class="b-top">
                                (GIVEN NAME)
                            </td>
                            <td class="b-top">
                                (MIDDLE INITIAL)
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="text-top b-top b-bottom">
                    <table style="width: 100%" class="">
                        <tr>
                            <td>DATE OF BIRTH: <small style="display: none">(DATE HEREIN SHOULD BE CHECKED FROM BIRTH OF BAPTISMAL CERTIFICATE OR SOME OTHER RELIABLE DOCUMENT)</small></td>
                        </tr>
                        <tr>
                            <td class="text-strong">{{Carbon::parse($employee->date_of_birth)->format('F d, Y')}}</td>
                        </tr>
                        <tr>
                            <td class="b-top">PLACE OF BIRTH:</td>
                        </tr>
                        <tr>
                            <td class="text-strong">{{$employee->place_of_birth}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 9px">THIS IS TO CERTIFY THAT THE EMPLOYEE NAMED HEREIN ACTUALLY RENDERED SERVICE IN THIS OFFICE AS SHOWN BT THE SERVICE BELOW. EACH LINE OF WHICH IS SUPPORTED BY APPOINTMENTS AND OTHER PAPERS ACTUALLY ISSUED BY THIS OFFICE AND APPROVED BY THE AUTHORITIES CONCERNED.</td>
            </tr>
        </table>

        <table style="width: 100%; font-size: 9px; margin-top: 10px" class="tbl-padded">
            <thead>
            <tr>
                <th colspan="2" class="b-top b-left b-bottom text-center">SERVICE</th>
                <th colspan="3" class="b-top b-left b-bottom text-center">RECORD OF APPOINTMENT</th>
                <th rowspan="2" class="b-top b-left b-bottom text-center">OFFICE/STATION</th>
                <th rowspan="2" class="b-top b-left b-bottom text-center">LEAVE W/o PAY</th>
                <th colspan="2" class="b-top b-left b-bottom text-center">SEPARATION</th>
                <th rowspan="2" class="b-top b-left b-bottom b-right text-center" style="width: 10%">REMARKS</th>
            </tr>
            <tr>
                <th class="b-bottom b-left text-center">From</th>
                <th class="b-bottom b-left text-center">To</th>
                <th class="b-bottom b-left text-center">Designation</th>
                <th class="b-bottom b-left text-center">Status</th>
                <th class="b-bottom b-left text-center">Salary</th>
                <th class="b-bottom b-left text-center">Date</th>
                <th class="b-bottom b-left text-center">Cause</th>
            </tr>
            </thead>
            <tbody>
            @foreach($srArray as $key => $sr)
                @if($key <= ($i + 1) * $numberOfItems - 1 && $key >= $i * $numberOfItems)
                    <tr>
                        <td class="text-center">{{\Illuminate\Support\Carbon::parse($srArray[$key]->from_date)->format('m/d/Y')}}</td>
                        <td class="text-center">
                            @if(($srArray[$key]->upto_date == 1))
                                PRESENT
                            @else
                                @if(($srArray[$key]->to_date != null))
                                    {{\Illuminate\Support\Carbon::parse($srArray[$key]->to_date)->format('m/d/Y')}}
                                @endif
                            @endif
                        </td>
                        <td>{{$srArray[$key]->position}}</td>
                        <td>{{$srArray[$key]->appointment_status}}</td>
                        <td>{{number_format($srArray[$key]->salary,2)}} / {{$srArray[$key]->mode_of_payment ?? null}}</td>
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
            <table style="width: 100%; margin-top: 30px">
              <tr>
                  <td style="font-size: 9px; border-top: 3px double black" class=" b-bottom">ISSUED IN COMPLIANCE WITH EXECUTIVE ORDER NO. 54, DATED AUGUST 10, 1954, AND IN ACCORDANCE WITH CIRCULAR NO. 58, DATED AUGUST 10, 1954, OF THE SYSTEM.</td>
              </tr>
            </table>
            <table style="width: 100%; margin-top: 10px" class="">
                <tr>
                    <td rowspan="2" style="width: 25%;" class="text-bottom text-center">{{\Illuminate\Support\Carbon::now()->format('F d, Y')}}</td>
                    <td style="width: 30%;"></td>
                    <td>CERTIFIED CORRECT:</td>
                </tr>
                <tr>
                    <td></td>
                    <td style="height: 40px" class="text-bottom text-strong text-center">{{\Illuminate\Support\Facades\Request::get('cn')}}</td>
                </tr>
                <tr>
                    <td class="text-center b-top">DATE</td>
                    <td></td>
                    <td class="b-top text-center">{{\Illuminate\Support\Facades\Request::get('cp')}}</td>
                </tr>
            </table>

            <p class="text-right no-margin" style="font-size: 9px">
                FM-AFD-HRS-032, Rev. 00 <br>
                Effectivity date: March 12, 2015
            </p>
        @endif
    </div>

    @endfor
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection