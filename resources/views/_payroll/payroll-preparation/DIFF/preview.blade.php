@php
    $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('priority')->groupBy('code')->keys();
    $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
@endphp
<div class="tscroll">
    <table class="table table-sm table-striped table-bordered table-hover" id="payroll-employees-table" style="width: 100%">
        <thead>
        <tr>
            <th class="first" style="width: 350px !important;"><span style="margin-right: 12em">Employee</span></th>
            <th class="text-center" style="min-width: 90px">Old Basic Pay</th>
            <th class="text-center" style="min-width: 90px">
                From <br>
                <button type="button" class="btn btn-outline-primary btn-sm update-row-btn" data='{"element" : "diff_from" , "title" : "FROM","type" : "date"}' data-bs-target="#update-row-modal" data-bs-toggle="modal"><i class="fa fa-edit"></i></button>
            </th>
            <th class="text-center" style="min-width: 90px">
                To <br>
                <button type="button" class="btn btn-outline-primary btn-sm update-row-btn" data='{"element" : "diff_to" , "title" : "TO","type" : "date"}' data-bs-target="#update-row-modal" data-bs-toggle="modal"><i class="fa fa-edit"></i></button>

            </th>
            <th class="text-center" style="min-width: 90px">No. of working days</th>
            <th class="text-center" style="min-width: 90px">New Basic Pay</th>
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
                @include('_payroll.payroll-preparation.DIFF.preview-row')
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>