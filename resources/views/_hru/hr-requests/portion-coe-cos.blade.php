<style>
    .cke_top, .cke_bottom {
        display: none;
    }
    .cke_editable {
        font-size: 24px; /* Match the body font size */
    }
</style>
<div class="row">
    <div class="col-md-4">
        <x-adminkit.html.card>
            <form class="generate-document-form" id="coe-form">
                <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                    Employee Details
                </x-adminkit.html.alert>
                <div class="row">
                    @php
                        $firstParagraph = 'This is to certify that <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong> is currently engaged as a Contract of Service (COS) personnel of the Sugar Regulatory Administration, '.\App\Swep\Helpers\Get::headerCity().' City, occupying the position of '.$hrRequest->employee->position.' since '.Helper::dateFormat($hrRequest->employee->firstday_sra,'F d, Y').', to present.';
                        $payTemplate = \App\Models\HRU\TemplateIncentives::query()->where('employee_slug','=',$hrRequest->employee_slug)->get();
                        $purposeParagraph = 'This certification is issued upon the request of '.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->lastname.' for whatever legal purpose/s it may serve '.($hrRequest->employee->sex == 'MALE' ? 'him' : 'her').' best.'
                    @endphp

                    <x-forms.textarea label="First Paragraph" name="first_paragraph" cols="12" id="editor3" :value="$document_fields['first_paragraph'] ?? $firstParagraph"/>
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
    </div>
    <div class="col-md-8">
        <div>
            <x-adminkit.html.card>
                <div class="placeholder-container mt-5 pt-5 pb-5 mb-5">
                    <div class="text-center">
                        <h1 class="display-1 fw-bold text-muted"><i class="fa fa-print"></i></h1>
                        <p class="lead fw-normal mt-3 mb-4">Print Preview</p>
                    </div>
                </div>
                <div class="print-container" style="display:none;">
                    <button class="btn btn-sm btn-secondary float-end print-btn" type="button"><i class="fa fa-print"></i> Print</button>
                    <iframe src="" class="print-iframe" style="width: 100%; height: 1000px"></iframe>
                </div>
            </x-adminkit.html.card>
        </div>
    </div>
</div>