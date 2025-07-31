<x-adminkit.html.card>
    <form class="generate-document-form" id="coe-form">
        <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
            Employee Details
        </x-adminkit.html.alert>
        <div class="row">
            @php
                if(Helper::isPermanent($hrRequest->employee)){
                    $firstParagraph = 'This is to certify that <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong> is an employee of the Sugar Regulatory Administration, since '.Helper::dateFormat($hrRequest->employee->firstday_sra,'F d, Y').' and up to present. '.($hrRequest->employee->sex == 'MALE' ? 'He ' : 'She ').' holds a permanent appointment as '.Helper::indefiniteArticle($hrRequest->employee->position).'.';
                }else{
                    $firstParagraph = 'This is to certify that <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong> is a Contract of Service (COS) Personnel of the Sugar Regulatory Administration, since '.Helper::dateFormat($hrRequest->employee->firstday_sra,'F d, Y').' and up to present.';
                }
                $payTemplate = \App\Models\HRU\TemplateIncentives::query()->where('employee_slug','=',$hrRequest->employee_slug)->get();
                $purposeParagraph = 'This certification is issued for whatever legal purpose it may serve.';
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