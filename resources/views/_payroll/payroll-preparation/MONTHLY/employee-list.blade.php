
<div class="row">
    <div class="col-md-6">
        <p class="no-margin ">Use the checkbox to exclude or include an employee to this payroll | <span id="checked" class="text-strong"> {{$employees->count()}} </span> / <span id="total"> {{$employees->count()}}</span> selected </p>
    </div>
    <div class="col-md-3" style="margin-bottom: 10px">
        <div class="mb-3 row">
            <label class="col-form-label col-sm-4 text-sm-end">Payroll Grp.</label>
            <div class="col-sm-8">
                <select type="text" class="form-control" id="filter-by-payroll-group-select">
                    <option value="">Select</option>
                    @foreach(\App\Swep\Helpers\Arrays::payrollGroups() as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


    <div class="col-md-3" style="margin-bottom: 10px">
        <div class="mb-3 row">
            <label class="col-form-label col-sm-3 text-sm-end">Search</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="search" placeholder="Search employee">
            </div>
        </div>
    </div>


</div>
<div style="overflow-y: scroll; height: calc(60vh - 3rem); border: 1px solid lightgrey">
    <table class="table table-sm table-striped table-hover" id="employees-table">
        <thead>
        <tr>
            <th>
                <label>
                    <input id="overall-selector" type="checkbox" checked>
                </label>
            </th>
            <th>Employee</th>
            <th style="display: none">Payroll Group</th>
            <th>Employee No.</th>
            <th>Position</th>
            <th style="width: 150px">Payroll Type</th>
            <th>JG</th>
            <th>Step</th>
            <th>Monthly Basic</th>
        </tr>
        </thead>
        <tbody>

        @forelse($employees as $employee)
            <tr>
                <td>
                    <label>
                        <input class="employee-selector" type="checkbox" checked name="employees[]" value="{{$employee->slug}}">
                    </label>
                </td>
                <td>{{$employee->full_name}}</td>
                <td style="display: none">{{$employee->payroll_group == '' || $employee->payroll_group == null ? 'REGULAR' : $employee->payroll_group}}</td>
                <td>{{$employee->employee_no}}</td>
                <td>{{$employee->plantilla->position ?? ''}}</td>
                <td>
                    <x-forms.select label="" cols="12" class="employee-select-payroll-group" name="payrollGroups[{{$employee->slug}}][]" :select-only="true" :options="\App\Swep\Helpers\Arrays::payrollGroups()" :value="$employee->payroll_group == '' || $employee->payroll_group == null ? 'REGULAR' : $employee->payroll_group"/>
                </td>
                <td>{{$employee->salary_grade}}</td>
                <td>{{$employee->step_inc}}</td>
                <td class="text-end">{{Helper::toNumber($employee->monthly_basic ?? null,2)}}</td>
            </tr>
        @empty
        @endforelse
        </tbody>
    </table>
</div>

<script>
    $("#overall-selector").iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass   : 'iradio_flat-green'
    })
    $('.employee-selector').iCheck({
        checkboxClass: 'icheckbox_flat-blue checkbox-counter',
        radioClass   : 'iradio_flat-green'
    })
</script>