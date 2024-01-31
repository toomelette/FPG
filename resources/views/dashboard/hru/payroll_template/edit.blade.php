<h4 class="no-margin text-strong">
    {{$employee->lastname}}, {{$employee->firstname}}
</h4>

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
            @forelse($employee->templateIncentives as $templateIncentive)
                <tr>
                    <td>{{$templateIncentive->incentive->description}}</td>
                    <td>{{$templateIncentive->incentive_code}}</td>
                    <td>
                        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('incentives['.$templateIncentive->incentive_code.']',[
                            'class' => 'input-xs text-right'
                        ],$templateIncentive->amount) !!}
                    </td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>