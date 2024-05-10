<div class="tscroll">
    <table class="table table-condensed table-striped table-bordered">
        <thead>
        <tr>
            <th class="first">Employee Name</th>
            @php
                $groupedIncentives= $payrollMaster->hmtDetails
                ->where('type','INCENTIVE')
                ->sortBy(function($data){
                    if($data->priority == null){
                        return 100000;
                    }else{
                        return $data->priority;
                    }
                })
                ->groupBy('code');

                $groupedDeductions = $payrollMaster->hmtDetails
                ->where('type','DEDUCTION')
                ->sortBy(function($data){
                    if($data->priority == null){
                        return 100000;
                    }else{
                        return $data->priority;
                    }
                })
                ->groupBy('code');
            @endphp

            @forelse($groupedIncentives as $incentive => $null)
                <th class="text-center">{{$incentive}}</th>
            @empty
            @endforelse

            @forelse($groupedDeductions as $ded => $null)
                <th class="text-center">{{$ded}}</th>
            @empty
            @endforelse
        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr>
                <td class="first" >{{$employee->employee->full_name ?? ''}}</td>
                @forelse($groupedIncentives as $incentive => $null)
                    <td class="text-right">
                        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
                    </td>
                @empty
                @endforelse
                @forelse($groupedDeductions as $ded => $null)
                    <td class="text-right">{{Helper::toNumber($employee->employeePayrollDetails->where('code',$ded)->first()->amount ?? null,2)}}</td>
                @empty
                @endforelse
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>