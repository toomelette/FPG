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
        ->where('amount','!=',null)
        ;
    })
    ->applyProjectId()
    ->active()
    ->permanent()
    ->orderBy('lastname','asc')
    ->get();
@endphp

<div class="row">
    <div class="col-md-9">
        <p class="no-margin ">Use the checkbox to exclude or include an employee to this payroll | <span id="checked" class="text-strong"> {{$employees->count()}} </span> / <span id="total"> {{$employees->count()}}</span> selected </p>
    </div>
    <div class="col-md-3" style="margin-bottom: 10px">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Search:</label>
            <div class="col-sm-10">
                <input type="email" class="form-control input-sm" id="search" placeholder="Search employee">
            </div>
        </div>
    </div>
</div>

<div style="overflow-y: scroll; height: calc(60vh - 3rem); border: 1px solid lightgrey">
    <table class="table table-condensed table-striped table-hover" id="employees_table">
        <thead>
        <tr>
            <th>
                <label>
                    <input id="overall_selector" type="checkbox" checked>
                </label>
            </th>
            <th>Employee</th>
            <th>Employee No.</th>
            <th>Position</th>
        </tr>
        </thead>
        <tbody>

        @forelse($employees as $employee)
            <tr>
                <td>
                    <label>
                        <input class="emp_selector" type="checkbox" checked name="employees[]" value="{{$employee->slug}}">
                    </label>
                </td>
                <td>{{$employee->full_name}}</td>
                <td>{{$employee->employee_no}}</td>
                <td>{{$employee->plantilla->position ?? ''}}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
</div>

<script>
    $("#overall_selector").iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-green'
    })
    $('.emp_selector').iCheck({
        checkboxClass: 'icheckbox_flat-blue checkbox-counter',
        radioClass   : 'iradio_flat-green'
    })
</script>