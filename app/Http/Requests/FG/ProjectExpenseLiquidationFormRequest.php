<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class ProjectExpenseLiquidationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function prepareForValidation()
    {

        $details = collect($this->details ?? [])
            ->map(function ($detail){
                $detail['debit'] = isset($detail['debit']) ? Helper::sanitizeAutonum($detail['debit']) : null;
                $detail['credit'] = isset($detail['credit']) ? Helper::sanitizeAutonum($detail['credit']) : null;
                return $detail;
            })
            ->toArray();
        $projects = collect($this->projects ?? [])
            ->map(function ($project){
                unset($project['client']);
                $project['amount'] = isset($project['amount']) ? Helper::sanitizeAutonum($project['amount']) : null;
                return $project;
            })
            ->toArray();
        $this->merge([
            'details' => $details,
            'projects' => $projects,
        ]);
    }

    public function rules(): array
    {
        return [
            'control_no' => 'required',
            'date' => 'required|date_format:Y-m-d' ,
//            'invoice_uuid' => 'required',
            'details' => 'required',

            'details.*.description' => 'required',
            'details.*.debit' => 'required_without:details.*.credit',
            'details.*.credit' => 'required_without:details.*.debit',

            'projects' => 'required',
            'projects.*.sales_invoice_uuid' => 'required',
            'projects.*.amount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'details.*.credit.required_without' => 'The credit field is required if debit field is empty',
            'details.*.debit.required_without' => 'The debit field is required if credit field is empty',
            'details.required' => 'At least one row in DETAILS is required',

        ];
    }

}
