@if($employees->count() > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead>
            <tr>
                <th></th>
                <th>Name of Employee</th>
                <th>Retirement by</th>
            </tr>
            </thead>
            @foreach($employees as $employee)
                <tr>
                    <th>{{$loop->iteration}}</th>
                    <td class="text-strong">{{$employee->full['LFEMi']}}</td>
                    <td>{{\Carbon\Carbon::make($employee->date_of_birth)->format('M. d')}}</td>
            @endforeach
        </table>
    </div>
@else
    <x-adminkit.html.alert type="info alert-outline" :dismissible="false">
        No retiree for this year
    </x-adminkit.html.alert>
@endif