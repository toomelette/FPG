@php
    $rand = \Illuminate\Support\Str::random();
    /** @var \App\Models\HRU\PayrollMaster $payrollMaster **/
    $dedCodes = ['GSIS','HDMF'];

    $deductions = $payrollMaster->hmtDetails->where(function ($detail) use ($dedCodes){
        return in_array($detail->code,$dedCodes);
    })->groupBy('code');

@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria, Caladea">
        @forelse($deductions as $code => $employees)
            <div style="break-after: page">
                <div class="clearfix">
                    <img src="{{base_path('/public/images/sra.png')}}" style="width: 60px; float: left; margin-right: 15px;">
                    <p class="no-margin text-left" style="font-size: 14px"> <b>SUGAR REGULATORY ADMINISTRATION</b></p>
                    <p class="no-margin text-left" style="font-size: 12px;"> {{\App\Swep\Helpers\Get::headerAddress()}}</p>
                </div>

                <div style="text-align: left; margin-bottom: 20px">
                    <h3 class="no-margin text-strong" style="font-size: 18px">{{$code}}</h3>
                </div>

                <table style="width: 100%;" class="tbl-padded tbl-bordered-grey">
                    <thead>
                    <tr>
                        <th style="width: 8px;"></th>
                        <th class="text-center">Employee</th>
                        <th class="text-center">Monthly Basic</th>
                        <th class="text-center">Per. Share</th>
                        <th class="text-center">Govt. Share</th>
                        @if($code == 'GSIS')
                            <th class="text-center">EC Share</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($employees as $payrollMasterEmployee)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$payrollMasterEmployee->employeePayroll->saved_employee_data['full_name']}}</td>
                            <td class="text-right">{{Helper::toNumber($payrollMasterEmployee->employeePayroll->saved_employee_data['monthly_basic'])}}</td>
                            <td class="text-right">{{Helper::toNumber($payrollMasterEmployee->amount)}}</td>
                            <td class="text-right">{{Helper::toNumber($payrollMasterEmployee->govt_share)}}</td>
                            @if($code == 'GSIS')
                                <td class="text-right">{{Helper::toNumber($payrollMasterEmployee->ec_share)}}</td>
                            @endif
                        </tr>
                    @empty
                    @endforelse
                    <tr>
                        <th style="width: 8px;"></th>
                        <th >TOTAL</th>
                        <th class="text-right">
                            {{
                                Helper::toNumber($employees->sum(function ($payrollMasterEmployee){
                                    return $payrollMasterEmployee->employeePayroll->saved_employee_data['monthly_basic'];
                            }))}}
                        </th>
                        <th class="text-right">{{Helper::toNumber($employees->sum('amount'))}}</th>
                        <th class="text-right">{{Helper::toNumber($employees->sum('govt_share'))}}</th>
                        @if($code == 'GSIS')
                            <th class="text-right">{{Helper::toNumber($employees->sum('ec_share'))}}</th>
                        @endif
                    </tr>
                    </tbody>

                </table>
            </div>

        @empty
        @endforelse
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection