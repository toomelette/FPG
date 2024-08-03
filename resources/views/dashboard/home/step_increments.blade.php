@if(count($employees_with_adjustments) > 0)
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th class="text-center">Employee</th>
            <th class="text-center">Last Promotion</th>
            <th class="text-center">JG</th>
            <th class="text-center">Curr. Step</th>
            <th class="text-center">Update to</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        @foreach($employees_with_adjustments as $employee)

                <tr>
                    <td class="align-top">
                        <span class="text-strong">{{$employee->lastname}}, {{$employee->firstname}}</span>
                        <div class="subdetail">
                            {{$employee->plantilla->position ?? $employee->position}}
                        </div>
                    </td>
                    <td class="text-center align-top">{{Carbon::parse($employee->adjustment_date)->format('M. d, Y')}}</td>
                    <td class="text-center align-top">{{$employee->salary_grade}}</td>
                    <td class="text-center align-top">{{$employee->step_inc}}</td>
                    <td class="text-center align-top">
                        @if($employee->step_inc+1 > 8)
                            N/A
                        @else
                            {{$employee->step_inc+1}}
                        @endif
                    </td>
                    <td style="width: 50px" class="text-center">
                        <a href="{{route('dashboard.employee.index')}}?find={{$employee->employee_no}}" target="_blank">
                            <button class="btn btn-outline-secondary btn-sm"><i class="fa fa-user"></i></button>
                        </a>
                    </td>
                </tr>
        @endforeach
    </table>
@else
    <x-adminkit.html.alert type="info alert-outline" :dismissible="false">
        No employees with adjustments for this month
    </x-adminkit.html.alert>

@endif