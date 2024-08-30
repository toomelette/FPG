<div class="tscroll">
    <table class="table table-sm table-striped table-bordered table-hover" id="payroll-employees-table">
        <thead>
        <tr>
            <th class="first" style="width: 1000px !important;"><span style="margin-right: 12em">Employee</span></th>

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
            <tr class="{{$loop->iteration % 5 == 0 ? 'fifth' : ''}}" data="{{$employee->slug ?? null}}">
                @include('_payroll.payroll-preparation.MONTHLY.preview-row')
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>