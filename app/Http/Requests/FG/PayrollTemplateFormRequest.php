<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PayrollTemplateFormRequest extends FormRequest
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

        $adjustments = collect($this->adjustments ?? [])
            ->mapWithKeys(function ($adjustment,$k){
                if(!empty($adjustment)){
                    return [
                        $k => Helper::sanitizeAutonum($adjustment) * 1
                    ];
                }
                return [];
            });
        $this->merge([
            'adjustments' => $adjustments->toArray(),
        ]);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
