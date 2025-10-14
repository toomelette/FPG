<div class="card">
    <div class="card-body">
        <h5 class="card-title">Service Records</h5>
        <table class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <th>Date From</th>
                <th>Date To</th>
                <th>Position</th>
                <th>Appointment Status</th>
                <th>Salary</th>
            </tr>
            </thead>
            <tbody>
            @php
                $serviceRecords = $employee->employeeServiceRecord->sortByDesc('sequence_no');
            @endphp
            @forelse($serviceRecords as $serviceRecord)
                <tr>
                    <td>{{Helper::dateFormat($serviceRecord->from_date,'M. d, Y')}}</td>
                    <td>{{Helper::dateFormat($serviceRecord->to_date,'M. d, Y')}}</td>
                    <td>{{$serviceRecord->position}}</td>
                    <td>{{$serviceRecord->appointment_status}}</td>
                    <td class="text-end">{{Helper::toNumber($serviceRecord->salary)}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>