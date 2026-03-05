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
        $this->merge([
            'details' => $details,
        ]);
    }

    public function rules(): array
    {
        return [
            'control_no' => 'required',
            'date' => 'required|date_format:Y-m-d' ,
            'project_uuid' => 'required',
            'details' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            'details.*.unit_cost' => 'required',
            'total_amount_due' => 'required',

            'details.*.description' => 'required',
            'details.*.debit' => 'required_without:details.*.credit',
            'details.*.credit' => 'required_without:details.*.debit',
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
