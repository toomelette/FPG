@if(!empty($loyaltys))
    <table class="table table-bordered">
        <thead>
        <tr>
            <th></th>
            <th>Name of Employee</th>
            <th>First day in government</th>
            <th>Years in govt. service</th>
            <th>Action</th>
        </tr>
        </thead>
        @foreach($loyaltys as $employee)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td class="text-strong">{{$employee->lastname}}, {{$employee->firstname}}</td>
                <td>{{\Illuminate\Support\Carbon::parse($employee->firstday_gov)->format('F d, Y')}}</td>
                <td>{{$employee->years_in_gov}} years</td>
                <td style="width: 50px;"><a href="{{route('dashboard.employee.index')}}?find={{$employee->employee_no}}" target="_blank"><button class="btn btn-xs">View Employee</button></a></td>
            </tr>
        @endforeach
    </table>
@endif