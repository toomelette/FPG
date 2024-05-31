
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
                ->groupBy('code')
                ;

            @endphp

            @forelse($groupedIncentives as $incentive => $null)
                <th class="text-center">{{$incentive}}</th>
            @empty
            @endforelse

            <th>
                Enter Number of Days
            </th>

            <th>
                Number of Days
            </th>

            <th>
                Total RA & TA
            </th>

        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr>

                <td class="first" >
                    {{$employee->employee->full_name ?? ''}}
                </td>

                @forelse($groupedIncentives as $incentive => $null)
                    <td class="text-right">
                        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
                    </td>
                @empty
                @endforelse

                <td>
                    <input type="number" name="dayNo[{{ $employee->slug }}]">
                </td>
                
                <td class="text-right">
                    {{Helper::toNumber($employee->rata_actualdays)}}
                </td>

                <td class="text-right">
                    {{Helper::toNumber($employee->rata_deduction,2)}}
                </td>

            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>
