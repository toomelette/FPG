@php
    $rand = Str::random();
@endphp
<form id="edit-template-form-{{$rand}}">

    <h3 class="box-title">
        <a href="{{route('dashboard.employee.index')}}?find={{$employee->employee_no}}" target="_blank"><span class="text-strong">{{$employee->full['LFEMi']}}</span></a>
        <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
    </h3>

    <div class="row">
        <div class="col-md-10">
            <div class="row">
                <div class="col-md-9">
                    <p class="no-margin">{{$employee->employee_no}}</p>
                    <p class="no-margin">{{$employee->plantilla->position ?? $employee->position}}</p>
                    <p class="text-info"><i>{{$employee->responsibilityCenter->desc ?? ''}}</i></p>

                </div>
                <div class="col-md-3">
                    <table>
                        <tr>
                            <td><small>Job Grade:</small></td>
                            <td><h4 class="no-margin">{{$employee->salary_grade}}</h4></td>
                        </tr>
                        <tr>
                            <td><small>Step Inc.:</small></td>
                            <td><h4 class="no-margin">{{$employee->step_inc}}</h4></td>
                        </tr>
                        <tr>
                            <td style="padding-right: 10px"><small>Monthly Basic:</small></td>
                            <td><h4 class="no-margin">{{number_format($employee->jg_monthly_basic,2)}}</h4></td>
                        </tr>
                    </table>
                </div>
                <hr class="no-margin">
            </div>
            <div class="row">
                <x-forms.checkbox label="Hazard Pay (PRC)" type="checkbox" name="receives_hazard_prc" cols="4" :options="['receives_hazard_prc' => 'Receives Hazard Pay (PRC)']" :value="[$employee?->payrollSettings?->receives_hazard_prc == 1 ? 'receives_hazard_prc' : null]"/>
                <x-forms.checkbox label="Representation Allowance (RA)" type="checkbox" name="receives_ra" cols="4" :options="['receives_ra' => 'Receives RA']" :value="[$employee?->payrollSettings?->receives_ra == 1 ? 'receives_ra' : null]"/>
                <x-forms.checkbox label="Transportation Allowance (TA)" type="checkbox" name="receives_ta" cols="4" :options="['receives_ta' => 'Receives TA']" :value="[$employee?->payrollSettings?->receives_ta == 1 ? 'receives_ta' : null]"/>
            </div>
            <div class="row">
                <x-forms.select label="Hazard Pay (PRC) Tax Rate" name="hazard_prc_tax_rate" cols="4" :options="\App\Swep\Helpers\Arrays::hazardPrcTaxRates()" :value="$employee?->payrollSettings->hazard_prc_tax_rate ?? null"/>
            </div>

        </div>
        <div class="col-md-2">
            <a href="#" class="thumbnail">
                @if($employee->photo != null && file_exists(public_path($employee->photo_path['300'])))
                    <img src="{{asset($employee->photo_path['300'])}}" alt="..." class="img-thumbnail rounded me-2 mb-2">
                @else
                    <img src="{{asset('images/avatar.jpeg')}}" class="img-thumbnail rounded me-2 mb-2">
                @endif

            </a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-striped table-sm" >
                <thead>
                <tr>
                    <th>Salaries/Incentives/Bonuses</th>
                    <th>Code</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $incentives = \App\Models\HRU\Incentives::query()
                        ->orderByRaw('ISNULL(n_priority), n_priority asc')
                        ->get();

                @endphp

                @forelse($incentives as $incentive)
                    <tr>
                        <td>{{$incentive->description}}</td>
                        <td>{{$incentive->incentive_code}}</td>
                        <td>
                            {!! \App\Swep\ViewHelpers\__form2::textboxOnly('incentives['.$incentive->incentive_code.']',[
                                'class' => 'input-xs text-end autonum_'.$rand,
                                'autocomplete' => 'off',
                            ],$employeeIncentivesArray[$incentive->incentive_code] ?? null) !!}
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-bordered table-striped table-sm" >
                <thead>
                <tr>
                    <th>Deductions</th>
                    <th>Code</th>
                    <th>Amount</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $deductions = \App\Models\HRU\Deductions::query()
                        ->orderByRaw('ISNULL(n_priority), n_priority asc')
                        ->available()
                        ->get();
                @endphp

                @forelse($deductions as $deduction)
                    <tr>
                        <td>{{$deduction->description}}</td>
                        <td>{{$deduction->deduction_code}} </td>
                        <td>
                            {!! \App\Swep\ViewHelpers\__form2::textboxOnly('deductions['.$deduction->deduction_code.']',[
                                'class' => 'input-xs text-end autonum_'.$rand,
                                'autocomplete' => 'off',
                            ],$employeeDeductionsArray[$deduction->deduction_code] ?? null) !!}
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>

<script>
    const autonumericElement_{{$rand}} =  AutoNumeric.multiple('.autonum_{{$rand}}');
    $("#edit-template-form-{{$rand}}").submit(function (e){
        e.preventDefault();
        let form = $(this);
        loading_btn(form);
        var url = '{{route("dashboard.payroll_template.update", $employee->slug)}}';
        $.ajax({
            url : url,
            data : $(this).serialize(),
            type: 'PATCH',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,false,false);
                toast('info','Template successfully updated.','Success!');
            },
            error: function (res) {

            }
        })
    })

</script>