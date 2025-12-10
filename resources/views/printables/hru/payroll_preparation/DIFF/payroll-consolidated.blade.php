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
        @php
            $code = 'DIFFL';
            $colspan = $payrollMasters->count() + 2;
        @endphp

        @foreach($usedCodes as $code)
            <div style="break-after: page">
                @foreach($tree as $group => $rcs)

                    <table style="width: 100%; break-after: page" class=" tbl-padded">
                        <thead>

                        <tr>
                            <th style="width: 25%; padding: 0; border: none"></th>
                            @forelse($payrollMasters as $payrollMaster)
                                <th style="border: none; width: {{(100-25-5) / $payrollMasters->count()}}%"></th>
                            @empty
                            @endforelse
                            <th style="padding: 0; border: none;width: 5%"></th>
                        </tr>


                        <tr>
                            <td colspan="{{$colspan}}">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 20%;">
                                            <p class="no-margin text-strong">CONSOLIDATED DIFFERENTIAL - {{$code}}</p>
                                            <p>PAY PERIOD: {{Carbon::parse($payrollMasters->pluck('date')->sort()->first())->format('M. Y')}} to {{Carbon::parse($payrollMasters->pluck('date')->sort()->last())->format('M. Y')}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                            <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                            <p class="no-margin">{{\App\Swep\Helpers\Get::headerAddress()}}</p>
                                        </td>

                                        <td style="width: 20%;">
                                            STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                            DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                            TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollEmployeesBySlug->count() }}</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <th>
                                Name of Employee
                            </th>
                            @forelse($payrollMasters as $payrollMaster)
                                <th style="width: {{(100-25-5) / $payrollMasters->count()}}%" class="text-center">{{Carbon::parse($payrollMaster->date)->format('M')}}</th>
                            @empty
                            @endforelse
                            <th class="text-strong text-center">
                                TOTAL
                            </th>
                        </tr>

                        </thead>
                        <tbody>



                        @php
                            $sumPerGroup = [];
                            $sumPerGroupSundry = [];
                            $sumPerGroup['pay15'] = null;
                            $sumPerGroup['pay30'] = null;
                        @endphp
                        <tr>
                            <td colspan="" class="text-strong" style="background-color: #f0ffef">{{$group}}</td>
                        </tr>
                        @forelse($rcs as $rcCode => $rc)
                            @php
                                $payrollEmployeesPerRc = $payrollEmployeesGroupedByRespCenter[$rcCode] ?? [];
                                $sumPerRc = [];
                                $sumPerRcSundry = [];
                            @endphp
                            @if(!empty($payrollEmployeesPerRc))

                                <tr>
                                    <td colspan="{{$colspan}}" class="indent text-strong" style="background-color: #e6f8ff">{{$rc->first()->responsibilityCenter->desc ?? ''}}</td>
                                </tr>

                                @forelse($payrollEmployeesPerRc as $payrollEmployee /** @var App\Models\HRU\PayrollMasterEmployees $payrollEmployee **/)
                                    <tr>
                                        <td>
                                            <span class="text-strong">{{$payrollEmployee->saved_employee_data['full_name'] ?? ''}}</span> <br>
                                            <p  class="indent no-margin"><small>{{$payrollEmployee->saved_employee_data['position']}}</small></p>
                                        </td>

                                        @forelse($payrollMasters as $payrollMaster)
                                            <td class="text-right text-top">
                                                {{ Helper::toNumber($payrollMaster->hmtDetails->where('code','=',$code)->where('employeePayroll.employee_slug','=',$payrollEmployee->employee_slug)->sum('amount')) }}
                                            </td>
                                        @empty
                                        @endforelse

                                        <td class="text-right text-top text-strong">
                                            {{
                                                Helper::toNumber($payrollMasters->sum(function ($payrollMaster) use($payrollEmployee,$code){
                                                    return $payrollMaster->hmtDetails->where('code','=',$code)->where('employeePayroll.employee_slug','=',$payrollEmployee->employee_slug)->sum('amount');
                                                }))
                                            }}
                                        </td>
                                    </tr>
                                @empty
                                @endforelse

                                {{--TOTALS PER RC FOOTER--}}
                                <tr>
                                    <td class="indent b-top text-strong text-strong">TOTAL {{$rc->first()->responsibilityCenter->desc ?? ''}}</td>
                                    @forelse($payrollMasters as $payrollMaster)
                                        <td class="text-right b-top">
                                            {{ Helper::toNumber($payrollMaster->hmtDetails->where('code','=',$code)->where('employeePayroll.saved_employee_data.resp_center','=',$rc->first()->resp_center)->sum('amount') )  }}
                                        </td>
                                    @empty
                                    @endforelse
                                    <td class="text-right text-top b-top text-strong">
                                        {{
                                            Helper::toNumber($payrollMasters->sum(function ($payrollMaster) use($payrollEmployee,$rc,$code){
                                                return $payrollMaster->hmtDetails->where('code','=',$code)->where('employeePayroll.saved_employee_data.resp_center','=',$rc->first()->resp_center)->sum('amount');
                                            }) )
                                        }}
                                    </td>
                                </tr>
                            @endif
                        @empty
                        @endforelse


                        {{-- TOTALS PER GROUP --}}
                        <tr class="text-strong">
                            <td class="b-top">TOTAL {{$group}}</td>




                            @forelse($payrollMasters as $payrollMaster)
                                <td class="text-right b-top text-strong">
                                    {{ Helper::toNumber($payrollMaster->hmtDetails->where('code','=',$code)->whereIn('employeePayroll.saved_employee_data.resp_center',$rcs->keys()->toArray())->sum('amount') )  }}
                                </td>
                            @empty
                            @endforelse

                            <td class="text-right text-top b-top text-strong">
                                {{
                                    Helper::toNumber($payrollMasters->sum(function ($payrollMaster) use($payrollEmployee,$rcs,$code){
                                        return $payrollMaster->hmtDetails->where('code','=',$code)->whereIn('employeePayroll.saved_employee_data.resp_center',$rcs->keys()->toArray())->sum('amount');
                                    }))
                                }}
                            </td>

                        </tr>
                        {{-- END TOTALS PER GROUP--}}

                        </tbody>
                    </table>

                @endforeach



                <table style="width: 100%" class="tbl-padded">
                    <thead>
                    <tr>
                        <th style="width: 25%; padding: 0; border: none"></th>
                        @forelse($payrollMasters as $payrollMaster)
                            <th style="border: none; width: {{(100-25-5) / $payrollMasters->count()}}%"></th>
                        @empty
                        @endforelse
                        <th style="padding: 0; border: none;width: 5%"></th>
                    </tr>
                    <tr>
                        <td colspan="{{$colspan}}">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 20%;">
                                        <p class="no-margin text-strong">CONSOLIDATED DIFFERENTIAL - {{$code}}</p>
                                        <p>PAY PERIOD: {{Carbon::parse($payrollMasters->pluck('date')->sort()->first())->format('M. Y')}} to {{Carbon::parse($payrollMasters->pluck('date')->sort()->last())->format('M. Y')}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="no-margin">REPUBLIC OF THE PHILIPPINES</p>
                                        <p class="no-margin text-strong">SUGAR REGULATORY ADMINISTRATION</p>
                                        <p class="no-margin">{{\App\Swep\Helpers\Get::headerAddress()}}</p>
                                    </td>
                                    <td style="width: 20%;">
                                        STATION:  <span class="text-strong">{{Auth::user()->project_id == 1 ? 'VISAYAS' : 'LUZON/MINDANAO'}}</span> <br>
                                        DEPT:  <span class="text-strong">{{$group}}</span> <br>
                                        TOTAL EMPLOYEES: <span class="text-strong"> {{ $payrollEmployeesBySlug->count() }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <th>
                            Name of Employee
                        </th>
                        @forelse($payrollMasters as $payrollMaster)
                            <th class="text-center">{{Carbon::parse($payrollMaster->date)->format('M')}}</th>
                        @empty
                        @endforelse
                        <th class="text-strong text-center">Total</th>
                    </tr>

                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="{{$colspan}}" class="b-bottom"><br></td>
                    </tr>
                    <tr class="text-strong">
                        <td>
                            GRAND TOTAL
                        </td>

                        @forelse($payrollMasters as $payrollMaster)
                            <th class="text-right b-top">
                                {{ Helper::toNumber($payrollMaster->hmtDetails->where('code','=',$code)->sum('amount'))  }}
                            </th>

                        @empty
                        @endforelse
                        <td class="text-right text-top b-top">
                            {{
                                Helper::toNumber($payrollMasters->sum(function ($payrollMaster) use($payrollEmployee,$rcs,$code){
                                    return $payrollMaster->hmtDetails->where('code','=',$code)->sum('amount');
                                }))
                            }}
                        </td>

                    </tr>
                    </tbody>
                </table>








            </div>
        @endforeach

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