<tr>
    <th class="text-center">Employee</th>
    <th class="text-center">Monthly Basic</th>
    @forelse($payrollMaster->employeeAdjustments as $employeeAdjustment)
        <th class="text-center" style="width: 120px">
            <small>{{$employeeAdjustment->code}}</small><br>
            <button type="button" class="btn btn-sm btn-outline-secondary fetch-template-btn" data-code="{{$employeeAdjustment->code}}"><i class="fa fa-download"></i></button>
        </th>
    @empty
    @endforelse
    <th class="text-center" style="width: 150px;">Net Pay</th>
</tr>