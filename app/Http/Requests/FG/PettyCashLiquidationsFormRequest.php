<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PettyCashLiquidationsFormRequest extends FormRequest
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
        $this->merge([
            'total_amount' => Helper::sanitizeAutonum($this->total_amount) * 1,
        ]);
    }

    public function rules(): array
    {
        return [
            //
        ];
    }
}
