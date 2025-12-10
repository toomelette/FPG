@php
    $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
    $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
@endphp
<div class="tscroll">
    <table class="table table-sm table-striped table-bordered table-hover" id="payroll-employees-table" style="width: 100%">
        <thead>
        <tr>
            <th class="first" style="width: 350px !important;"><span style="margin-right: 12em">Employee</span></th>
            @forelse($incentives as $incentive)
                <th class="text-center" style="min-width: 90px">{{$incentive}} </th>
            @empty
            @endforelse
            @forelse($deductions as $deduction)
                <th class="text-center" style="min-width: 90px">{{$deduction}} <br> <button type="button" class="btn btn-outline-danger btn-sm remove-column-btn" code="{{$deduction}}"><i class="fa fa-trash"></i></button></th>
            @empty
            @endforelse
            <th class="text-center" style="min-width: 90px">Net Amount Received</th>
        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr class="{{$loop->iteration % 5 == 0 ? 'fifth' : ''}}" data="{{$employee->slug ?? null}}">
                @include('_payroll.payroll-preparation.CNA.preview-row')
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>