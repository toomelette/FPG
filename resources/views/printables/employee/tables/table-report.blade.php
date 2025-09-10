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

    </tr>

    </thead>
    <tbody>

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
                                <td class="text-right">{{Helper::toNumber($employee->monthly_basic)}}</td>
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
                            @case('address_perm')
                                @php($perm = $employee->employeeAddress)
                                <td>
                                    @if(!empty($employee->employeeAddress))
                                        {{$perm->perm_address_street}}
                                        {{$perm->perm_address_village != null ? ', '.$perm->perm_address_village : ''}}
                                        {{$perm->perm_address_barangay != null ? ', '.$perm->perm_address_barangay : ''}}
                                        {{$perm->perm_address_city != null ? ', '.$perm->perm_address_city : ''}}
                                    @endif
                                </td>
                                @break
                            @case('address_res')
                                @php($res = $employee->employeeAddress)
                                <td>
                                    @if(!empty($employee->employeeAddress))
                                        {{$perm->res_address_street}}
                                        {{$perm->res_address_village != null ? ', '.$perm->res_address_village : ''}}
                                        {{$perm->res_address_barangay != null ? ', '.$perm->res_address_barangay : ''}}
                                        {{$perm->res_address_city != null ? ', '.$perm->res_address_city : ''}}
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
            </tr>
        @endforeach

    </tbody>
</table>
