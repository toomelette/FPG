@if(!empty($loyaltys))
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th></th>
                <th>Name of Employee</th>
                <th>First day in SRA</th>
                <th>Years in govt. service</th>
                <th  style="width: 130px;">Action</th>
            </tr>
            </thead>
            @foreach($loyaltys as $employee)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <td class="text-strong">{{$employee->full['LFEM']}}</td>
                    <td>{{\Illuminate\Support\Carbon::parse($employee->firstday_sra)->format('F d, Y')}}</td>
                    <td>{{$employee->years_in_gov}} years</td>
                    <td>
                        <a href="{{route('dashboard.employee.index')}}?find={{$employee->employee_no}}" target="_blank"><button class="btn btn-outline-secondary btn-sm"><i class="fa fa-user"></i> View Employee</button></a></td>
                </tr>
            @endforeach
        </table>
    </div>

@endif