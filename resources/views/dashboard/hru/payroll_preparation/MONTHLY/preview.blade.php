<div class="tscroll">
    <table class="table table-condensed table-striped table-bordered" id="payroll-employees-table">
        <thead>
        <tr>
            <th class="first" style="width: 1000px !important;"><span style="margin-right: 12em">Employee</span></th>
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
                <th class="text-center" style="min-width: 90px">{{$incentive}}</th>
            @empty
            @endforelse
            <th style="min-width: 90px">SUBTOTAL</th>
            @forelse($groupedDeductions as $ded => $null)
                <th class="text-center" style="min-width: 90px">{{$ded}}</th>
            @empty
            @endforelse
            <th class="text-center" style="min-width: 90px">SUBTOTAL</th>
            <th class="text-center" style="min-width: 90px">TAKE HOME PAY</th>
            <th class="text-center" style="min-width: 90px">15th</th>
            <th class="text-center" style="min-width: 90px">30th</th>
        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr>
                <td class="first employee-options-btn" data="{{$employee->slug}}" emp-no="{{$employee->employee->employee_no}}"
                    content="{{$employee->employee->plantilla->item_no ?? ''}} | {{$employee->employee->plantilla->position ?? ''}} <br> ({{$employee->employee->salary_grade ?? ''}},{{$employee->employee->step_inc ?? ''}}) <br> {{$employee->employee->employee_no ?? ''}}"
                >{{$employee->employee->full_name ?? ''}}</td>
                @forelse($groupedIncentives as $incentive => $null)
                    <td class="text-right">
                        {{Helper::toNumber($employee->employeePayrollDetails->where('code',$incentive)->first()->amount ?? null,2)}}
                    </td>
                @empty
                @endforelse

                <td class="text-right text-info incentive-subtotal">
                    {{Helper::toNumber($incTotal = $employee->employeePayrollDetails->where('type','INCENTIVE')->sum('amount'),2)}}
                </td>

                @forelse($groupedDeductions as $ded => $null)
                    <td class="text-right">{{Helper::toNumber($employee->employeePayrollDetails->where('code',$ded)->first()->amount ?? null,2)}}</td>
                @empty
                @endforelse

                <td class="text-right text-info deduction-subtotal">{{Helper::toNumber($dedTotal = $employee->employeePayrollDetails->where('type','DEDUCTION')->sum('amount'),2)}}</td>
                <td class="text-right text-strong {{$incTotal - $dedTotal < 5000 ? 'text-danger bg-danger' : ''}}">
                    {{Helper::toNumber($incTotal - $dedTotal)}}
                </td>
                <td class="text-right {{$employee->pay15 < 2500 ? 'text-danger bg-danger' : ''}}">{{Helper::toNumber($employee->pay15,2)}}</td>
                <td class="text-right {{$employee->pay30 < 2500 ? 'text-danger bg-danger' : ''}}">{{Helper::toNumber($employee->pay30,2)}}</td>
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>