@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        table>thead>tr>th{
            border: 1px solid black;
        }
    </style>
    <div style="font-family: Cambria">

        <div style="break-after: page">

            <table style="width: 100%" class=" tbl-padded">
                <thead>
                <tr>
                    <th style="width: 220px; padding: 0; border: none"></th>
                    <th style="padding: 0; border: none;"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 10%"></th>
                    <th style="padding: 0; border: none;width: 7%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                    <th style="padding: 0; border: none;width: 8%"></th>
                    <th style="padding: 0; border: none;width: 5%"></th>
                </tr>

                <tr>
                    <td colspan="9">
                        <table style="width: 100%;">
                            <tr>
                                <td class="text-center">
                                    <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                    <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                    <p class="no-margin">{{\App\Swep\Helpers\Get::headerAddress()}}</p> <br>

                                    <p class="no-margin text-strong">REPRESENTATION AND TRANSPORTATION ALLOWANCE</p>
                                    <p class="no-margin text-strong">{{Carbon::parse($payrollMaster->date)->format('F Y')}}</p> <br>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th class="text-center">Name of Employee</th>
                    <th class="text-center">Position</th>
                    <th class="text-center">Basic Pay</th>
                    <th class="text-center">RA</th>
                    <th class="text-center">TA</th>
                    <th class="text-center">Actual Days Worked</th>
                    <th class="text-center">Deductions</th>
                    <th class="text-center">Net Amount Received</th>
                    <th class="text-center">Signature</th>
                </tr>
                </thead>
                <tbody>
                @forelse($groupedByDept as $deptCode => $payrollEmployees)
                    @php
                        $dept = $usedRcsDB->where('rc','=',$deptCode)?->first();
                    @endphp
                    <tr>
                        <td colspan="9" class="text-strong">{{$dept?->description->name}}</td>
                    </tr>
                    @forelse($payrollEmployees as $payrollEmployee)
                        <tr>
                            <td class="indent">{{$payrollEmployee->saved_employee_data['full_name'] ?? null}}</td>
                            <td class="indent">{{$payrollEmployee->saved_employee_data['position'] ?? null}}</td>
                            <td class="indent text-right">{{Helper::toNumber($payrollEmployee->saved_employee_data['monthly_basic'] ?? null)}}</td>
                            <td class="indent text-right">{{Helper::toNumber($payrollEmployee->rata_ra_rate)}}</td>
                            <td class="indent text-right">{{Helper::toNumber($payrollEmployee->rata_ta_rate)}}</td>
                            <td class="indent text-right">{{Helper::toNumber(Helper::toNumber($payrollEmployee->rata_actual_days_worked),3)}}</td>
                            <td class="indent text-right">{{Helper::toNumber($payrollEmployee->rata_deductions,2,'0.00')}}</td>
                            <td class="indent text-right">{{Helper::toNumber($payrollEmployee->rata_net_amount)}}</td>
                            <td>_________________________</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr>
                        <td colspan="2" class="text-strong b-top">TOTAL {{$dept?->description->name}}</td>
                        <td class="text-right text-strong b-top">
                            {{Helper::toNumber($payrollEmployees->sum(function ($payrollEmployee){
                                return $payrollEmployee->saved_employee_data['monthly_basic'];
                            }))}}
                        </td>
                        <td class="text-right text-strong b-top">
                            {{Helper::toNumber($payrollEmployees->sum('rata_ra_rate'))}}
                        </td>
                        <td class="text-right text-strong b-top">
                            {{Helper::toNumber($payrollEmployees->sum('rata_ta_rate'))}}
                        </td>
                        <td class="text-right text-strong b-top">

                        </td>
                        <td class="text-right text-strong b-top">
                            {{Helper::toNumber($payrollEmployees->sum('rata_deductions'),2,'0.00')}}
                        </td>
                        <td class="text-right text-strong b-top">
                            {{Helper::toNumber($payrollEmployees->sum('rata_net_amount'))}}
                        </td>
                    </tr>
                @empty
                @endforelse
                <tr>
                    <td colspan="9"><br></td>
                </tr>
                <tr>
                    <td class="text-strong b-top" colspan="2">GRAND TOTAL</td>

                    <td class="text-right text-strong b-top">
                        {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum(function ($payrollEmployee){
                            return $payrollEmployee->saved_employee_data['monthly_basic'];
                        }))}}
                    </td>
                    <td class="text-right text-strong b-top">
                        {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('rata_ra_rate'))}}
                    </td>
                    <td class="text-right text-strong b-top">
                        {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('rata_ta_rate'))}}
                    </td>
                    <td class="text-right text-strong b-top">

                    </td>
                    <td class="text-right text-strong b-top">
                        {{Helper::toNumber($payrollMaster->payrollMasterEmployees->sum('rata_deductions'),2,'0.00')}}
                    </td>
                    <td class="text-right text-strong b-top">
                        {{Helper::toNumber($grandTotal = $payrollMaster->payrollMasterEmployees->sum('rata_net_amount'))}}
                    </td>
                </tr>
                </tbody>
            </table>







            <div style="break-before: page">
                <table style="width: 100%;">
                    <tr>
                        <td colspan="9">
                            <table style="width: 100%;">
                                <tr>
                                    <td class="text-center">
                                        <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                        <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                        <p class="no-margin">{{$payrollMaster->project_id == 1 ? 'Bacolod City' : 'Quezon City'}}</p> <br>

                                        <p class="no-margin text-strong">REPRESENTATION AND TRANSPORTATION ALLOWANCE</p>
                                        <p class="no-margin text-strong">{{Carbon::parse($payrollMaster->date)->format('F Y')}}</p> <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="width: 50%" class="b-top b-left b-right">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">A</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        CERTIFIED: Services duly rendered as stated.
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->a_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->a_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Authorized Official
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="b-top b-right">

                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">C</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        APPROVED FOR PAYMENT:
                                        <u>
                                            {{strtoupper(\Illuminate\Support\Number::spell(floor($grandTotal)))}} PESOS
                                            @if($grandTotal - floor($grandTotal) != 0)
                                                AND {{strtoupper(\Illuminate\Support\Number::spell(round($grandTotal - floor($grandTotal), 2) * 100))}} CENTAVOS
                                            @endif
                                            ONLY
                                        </u>
                                        (₱ {{Helper::toNumber($grandTotal)}})

                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->c_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->c_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Head of the Agency/Authorized Representative
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td class="b-top b-left b-right b-bottom">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">B</td>
                                    <td style="padding-left: 10px" class="text-strong">
                                        CERTIFIED: Supporting documents complete; and cash
                                        available in the amount of ₱{{Helper::toNumber($grandTotal)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px" class="text-center text-bottom">
                                        <p class="no-margin text-strong">{{$payrollMaster->b_name}}</p>
                                        <p class="no-margin">{{$payrollMaster->b_position}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="b-top text-center">
                                        Head, Accounting Unit
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <td class="b-top b-right b-bottom">
                            <table style="width: 90%; margin: 5%">
                                <tr>
                                    <td class="b-side b-tb text-center" style="font-size: 20px; width: 50px; height: 50px">D</td>
                                    <td style="padding-left: 10px; width: 70%; ; padding-right: 10px" class="text-strong">
                                        CERTIFIED: Each employee whose name appears above has been
                                        paid the amount indicated opposite his/her name,
                                    </td>
                                    <td class="b-left" style="padding-left: 10px"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="height: 100px; padding-right: 10px" class="text-center text-bottom">
                                        <table style="width: 100%">
                                            <tr>
                                                <td style="width: 65%;">
                                                    <p class="no-margin text-strong text-center">{{$payrollMaster->d_name}}</p>
                                                    <p class="no-margin text-center">{{$payrollMaster->d_position}}</p>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="b-top text-center">
                                                    Disbursing Officer
                                                </td>
                                                <td class="b-top text-center">
                                                    Date
                                                </td>
                                            </tr>
                                        </table>


                                    </td>
                                    <td class="b-left" style="padding-left: 10px">
                                        JEV NO. ____________ <br>
                                        DATE _______________
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="b-left" style="padding-left: 10px"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

        @endsection

        @section('scripts')
            <script type="text/javascript">
                print();
                $(document).ready(function () {
                    let set = 625;
                    if ($("#items_table_{{$rand}}").height() < set) {
                        let rem = set - $("#items_table_{{$rand}}").height();
                        $("#adjuster").css('height', rem)
                        // print();
                    }
                })
                window.onafterprint = function () {
                    // window.close();
                }
            </script>
@endsection