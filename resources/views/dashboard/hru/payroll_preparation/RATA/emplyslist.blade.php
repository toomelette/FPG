<input id="search">
    <div style="overflow-y: scroll; height: calc(60vh - 3rem)">
        <table class="table table-condensed table-striped table-hover" id="employees_table">
            <thead>
            <tr>
                <th></th>
                <th>Employee</th>
            </tr>
            </thead>
            <tbody>
            @php
                $employees = \App\Models\Employee::query()   
                    ->whereHas('templateIncentives',function($mpy){
                        $mpy
                        ->where(function($qry){
                            $qry
                            ->where('incentive_code','=','RA')
                            ->orWhere('incentive_code','=','TA')
                            ;
                        })
                        ;
                    })
                    ->applyProjectId()
                    ->active()
                    ->permanent()
                    ->orderBy('lastname','asc')
                    ->get();
            @endphp
            @forelse($employees as $employee)
                <tr>
                    <td>
                        <label>
                            <input class="emp_selector" type="checkbox" checked name="employees[]" value="{{$employee->slug}}">
                        </label>
                    </td>
                    <td>{{$employee->full_name}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
</div>