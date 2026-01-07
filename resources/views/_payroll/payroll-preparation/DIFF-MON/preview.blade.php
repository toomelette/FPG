@php
    $deductions = $payrollMaster->hmtDetails->where('type','DEDUCTION')->sortBy('account_code')->groupBy('code')->keys();

    $incentives = $payrollMaster->hmtDetails->where('type','INCENTIVE')->sortBy('priority')->groupBy('code')->keys();
@endphp
<div class="tscroll">
    <table class="table table-sm table-striped table-bordered table-hover" id="payroll-employees-table" style="width: 100%">
        <thead>
        <tr >
            <th class="first" style="width: 300px !important;"><span style="margin-right: 12em">Employee</span></th>
            <th class="text-center" style="width: 35px !important;"></th>


            <th class="text-center" style="min-width: 90px; width: 140px">
                Old Basic Pay
                <br>
                <button type="button" class="btn btn-outline-primary btn-sm fetch-mbs-btn"  data="old"><i class="fa fa-download"></i> Fetch</button>

            </th>

            <th class="text-center" style="min-width: 90px;width: 140px">
                New Basic Pay
                <br>
                <button type="button" class="btn btn-outline-primary btn-sm fetch-mbs-btn" data="new"><i class="fa fa-download"></i> Fetch</button>
            </th>
            <th class="text-center" style="min-width: 90px;width: 140px">
                Differential
            </th>
            <th class="text-center" style="width: 110px">
                # Wkng Days <br>
                <button type="button" class="btn btn-outline-primary btn-sm update-row-btn" data='{"element" : "diff_days" , "title" : "No of Working Days","type" : "number"}' data-bs-target="#update-row-modal" data-bs-toggle="modal"><i class="fa fa-edit"></i></button>
            </th>

            @forelse($incentives as $incentive)
                <th class="text-center" style="width: 120px !important;">{{$incentive}}</th>
            @empty
            @endforelse

            @forelse($deductions as $deduction)
                <th class="text-center" style="width: 120px !important;">{{$deduction}}</th>
            @empty
            @endforelse
            <th class="text-center" style="width: 120px">Net Amount Received</th>
        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr class="{{$loop->iteration % 5 == 0 ? 'fifth' : ''}} animate__animated" data="{{$employee->slug ?? null}}" data-emp="{{$employee->employee_slug}}">
                @include('_payroll.payroll-preparation.DIFF-MON.preview-row')
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>