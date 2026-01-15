<x-adminkit.html.card>
    <form class="generate-document-form" id="coe-form">
        <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
            Employee Details
        </x-adminkit.html.alert>
        <div class="row">
            @php
                $isPermanent = Helper::isPermanent($hrRequest->employee);
                $signatories = \App\Swep\Helpers\Get::setting('loi_signatories');
                $employeeSignatories = \App\Models\Employee::query()->with(['plantilla','responsibilityCenter.description'])->whereIn('item_no',$signatories->json_value)->active()->get();
                $notedBy = $employeeSignatories->where('item_no',$signatories->json_value['noted_by'])->first();
                $hrRepresentative = $employeeSignatories->where('item_no',$signatories->json_value['hr_representative'])->first();

                $addressTo = '<b>DULCE JOY J. GAYAT</b><br>AVP/Head, Bacolod Branch<br>Landbank of the Philippines<br>Bacolod Gatuslao Branch <br><br> Dear Ms. Amodia,';
                if(!$isPermanent){
                    $firstParagraph = 'In line with the approval of the Memorandum of Agreement between Landbank of the
                                        Philippines and the Sugar Regulatory Administration, may we request the issuance of an
                                        ATM (savings account payroll) card for <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong>, a Contract of Service (COS) - '.$hrRequest->employee->position.' of the Sugar Regulatory Administration.';
                }else{
                    $firstParagraph = 'May we request the issuance of an ATM (savings account payroll) card for <strong>'.($hrRequest->employee->sex == 'MALE' ? 'MR. ' : 'MS. ') .$hrRequest->employee->full['FMiLE'].'</strong>, '.$hrRequest->employee->position.' of the '.$hrRequest?->employee?->responsibilityCenter?->description?->descriptive_name.' Department, a permanent employee of the Sugar Regulatory Administration.';
                }
                $hrRepresentativeText = '<b>'.$hrRepresentative->full['FMiLE'].'</b> <br> '.$hrRepresentative->plantilla->position.' <br> '.$hrRepresentative?->responsibilityCenter?->description?->short_name.' Department';
                $notedByText = '<b>'.$notedBy->full['FMiLE'].'</b> <br> '.$notedBy->plantilla->position.' <br> '.$notedBy?->responsibilityCenter?->description?->short_name.' Department';

            @endphp
            <x-forms.textarea label="Address to" name="address_to" cols="12" id="ck-{{Str::random(6)}}" class="ck-180" :value="$document_fields['address_to'] ?? $addressTo"/>
            <x-forms.textarea label="First Paragraph" name="body" cols="12" id="editor3" :value="$document_fields['body'] ?? $firstParagraph"/>
            <x-forms.textarea label="HR Representative" name="hr_representative" class="ck-100" id="ck-{{Str::random(6)}}" cols="12" :value="$document_fields['hr_representative'] ?? $hrRepresentativeText" rows="3"/>
            <x-forms.textarea label="Noted by" name="noted_by" class="ck-100" id="ck-{{Str::random(6)}}" cols="12" :value="$document_fields['noted_by'] ?? $notedByText" rows="3"/>

            <x-forms.input label="Memo Code" name="memo_code" cols="6 mt-1" :value="$document_fields['memo_code'] ?? null" />
            <x-forms.input label="Date" name="date" cols="6 mt-1" type="date" :value="$document_fields['date'] ?? Carbon::now()->format('Y-m-d')"/>
            <div class="col-md-12 mt-3">
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Generate</button>
            </div>
        </div>
    </form>
</x-adminkit.html.card>
