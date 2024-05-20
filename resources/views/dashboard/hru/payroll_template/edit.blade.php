@php
    $rand = Str::random();
@endphp
<form id="edit_template_form_{{$rand}}">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">Payroll Template</h3>
            <span class="pull-right">
            <button class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </span>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="no-margin text-strong">
                        {{$employee->lastname}}, {{$employee->firstname}}


                    </h4>
                    <p class="no-margin">{{$employee->position}}</p>
                    <p class="text-info"><i>{{$employee->responsibilityCenter->desc ?? ''}}</i></p>
                    <hr class="no-margin">
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
                            <td><h4 class="no-margin">{{number_format($employee->monthly_basic,2)}}</h4></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2">
                    <a href="#" class="thumbnail">
                        @if($employee->photo != null && file_exists(public_path($employee->photo_path['300'])))
                            <img src="{{asset($employee->photo_path['300'])}}" alt="..." style="object-fit: cover" width="200" height="200">
                        @else
                            <img src="{{asset('images/avatar.jpeg')}}" alt="User Image">
                        @endif

                    </a>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped table-condensed" >
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
                                        'class' => 'input-xs text-right autonum_'.$rand,
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
                    <table class="table table-bordered table-striped table-condensed" >
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
                                        'class' => 'input-xs text-right autonum_'.$rand,
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
        </div>
    </div>
</form>

<script>
    const autonumericElement_{{$rand}} =  AutoNumeric.multiple('.autonum_{{$rand}}');
    $("#edit_template_form_{{$rand}}").submit(function (e){
        e.preventDefault();
        var url = '{{route("dashboard.payroll_template.update", $employee->slug)}}';
        $.ajax({
            url : url,
            data : $(this).serialize(),
            type: 'PATCH',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                console.log(res);
            },
            error: function (res) {
         
            }
        })
    })

</script>