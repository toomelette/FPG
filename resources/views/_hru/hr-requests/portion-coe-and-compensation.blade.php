<x-adminkit.html.card>
    <form class="generate-document-form" id="coe-form">
        <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
            Employee Details
        </x-adminkit.html.alert>
        <div class="row">
            @php
                $firstParagraph = 'This is to certify that <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong> is an employee of the Sugar Regulatory Administration since '.Helper::dateFormat($hrRequest->employee->firstday_sra,'F d, Y').', to date. '.($hrRequest->employee->sex == 'MALE' ? 'He' : 'She').' holds a permanent appointment of '.$hrRequest->employee->position.'.';
                $payTemplate = \App\Models\HRU\TemplateIncentives::query()->where('employee_slug','=',$hrRequest->employee_slug)->get();
                $purposeParagraph = 'This certification is issued for whatever legal purpose it may serve.'
            @endphp

            <x-forms.textarea label="First Paragraph" name="first_paragraph" cols="12" id="editor" :value="$document_fields['first_paragraph'] ?? $firstParagraph"/>
            <div class="col-md-12 mt-2">
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>BASIC SALARY</td>
                        <td style="width: 200px"><x-forms.input label="Monthly Basic" class="autonum text-end" name="monthly_basic" cols="12" :value="$document_fields['monthly_basic'] ?? $hrRequest->employee->monthly_basic" :input-only="true"/></td>
                    </tr>
                    <tr>
                        <td>PERA</td>
                        <td><x-forms.input label="PERA" class="autonum text-end" name="pera" cols="12" :input-only="true" :value="$document_fields['pera'] ?? 2000"/></td>
                    </tr>
                    <tr>
                        <td>RA</td>
                        <td><x-forms.input label="Representation Allowance" class="autonum text-end" name="ra" cols="12" :input-only="true" :value="$document_fields['ra'] ?? $hrRequest?->employee?->payrollSettings?->ra_rate"/></td>
                    </tr>
                    <tr>
                        <td>TA</td>
                        <td><x-forms.input label="Transportation Allowance" class="autonum text-end" name="ta" cols="12" :input-only="true" :value="$document_fields['ta'] ?? $hrRequest?->employee?->payrollSettings?->ta_rate"/></td>
                    </tr>
                </table>
            </div>

            <div class="col-md-12">
                Other Compensation:
            </div>
            @php
                $incentivesForCoe = \App\Models\HRU\Incentives::query()->where('coe','=',1)->get();
            @endphp
            <div class="col-md-12 mt-2">
                <table class="table table-sm table-bordered">
                    @forelse($incentivesForCoe as $incentive)
                        <tr>
                            <td>{{$incentive->incentive_code}} <small> | {{$incentive->description}}</small></td>

                            <td style="width: 200px">
                                @if($incentive->incentive_code == 'MYB' || $incentive->incentive_code == 'YEB')
                                    <x-forms.input class="autonum text-end" label="{{$incentive->incentive_code}}" name="other_incentives[{{$incentive->description}}]" cols="12" :input-only="true" :value="$document_fields['other_incentives'][$incentive->description] ?? $hrRequest->employee->monthly_basic"/>
                                @else
                                    <x-forms.input class="autonum text-end" label="{{$incentive->incentive_code}}" name="other_incentives[{{$incentive->description}}]" cols="12" :input-only="true" :value="$document_fields['other_incentives'][$incentive->description] ?? $payTemplate->where('incentive_code',$incentive->incentive_code)->first()?->amount"/>
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </table>
            </div>


            <x-forms.textarea label="Purpose clause" name="purpose_paragraph" id="editor2" cols="12" :value="$document_fields['purpose_paragraph'] ?? $purposeParagraph" rows="3"/>
            <x-forms.input label="Memo Code" name="memo_code" cols="6 mt-1" :value="$document_fields['memo_code'] ?? null" />
            <x-forms.input label="Date on certificate" name="date" cols="6 mt-1" type="date" :value="$document_fields['date'] ?? Carbon::now()->format('Y-m-d')"/>
            <x-forms.select :options="[]" label="Name of Signatory" name="signatory_name" cols="12 mt-2" class="select2-coe-signatories" :value="$document_fields['signatory_name'] ?? null"/>
            <x-forms.input label="Position" name="signatory_position" cols="12 mt-2" :value="$document_fields['signatory_position'] ?? null"/>
            <div class="col-md-12 mt-3">
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Generate</button>
            </div>
        </div>

    </form>
</x-adminkit.html.card>