<div class="tscroll">
    <table class="table table-sm table-striped table-bordered table-hover" id="payroll-employees-table" style="width: 100%">
        <thead>
        <tr>
            <th class="first" style="width: 350px !important;"><span style="margin-right: 12em">Employee</span></th>

            <th class="text-center" style="min-width: 90px">Basic Pay</th>
            <th class="text-center" style="min-width: 90px">Hazard Pay (PRC)</th>
            <th class="text-center" style="min-width: 90px">No of Days in a Month</th>
            <th class="text-center" style="min-width: 90px">Excluded Days</th>
            <th class="text-center" style="min-width: 90px">No. of days exposed to hazard</th>
            <th class="text-center" style="min-width: 90px">Less Tax</th>
            <th class="text-center" style="min-width: 90px">Net Amount Received</th>
        </tr>
        </thead>
        <tbody>
        @forelse($payrollMaster->payrollMasterEmployees as $employee)
            <tr class="{{$loop->iteration % 5 == 0 ? 'fifth' : ''}}" data="{{$employee->slug ?? null}}">
                @include('_payroll.payroll-preparation.HAZARDPRC.preview-row')
            </tr>
        @empty
        @endforelse

        </tbody>
    </table>
</div>