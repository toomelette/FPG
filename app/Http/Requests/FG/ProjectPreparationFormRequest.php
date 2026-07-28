<?php

namespace App\Http\Requests\FG;

use App\Models\FG\Stocks;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectPreparationFormRequest extends FormRequest
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
        $stocks = Stocks::query()->whereIn('uuid',collect($this->details)->pluck('description')->toArray())
            ->get();
        $details = collect($this->details ?? [])
            ->map(function ($detail) use ($stocks){
                $detail['unit_cost'] = isset($detail['unit_cost']) ? (Helper::sanitizeAutonum($detail['unit_cost']) * 1) : null;
                $detail['amount'] = $detail['unit_cost'] * $detail['qty'];
                $detail['stock_uuid'] = $stocks?->firstWhere('uuid',$detail['description'])?->uuid ?? null;
                $detail['description'] = $stocks?->firstWhere('uuid',$detail['description'])?->name ?? $detail['description'];
                $detail['warehouse']= Auth::user()->warehouse;
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
            'control_no' => [
                'required',
                'regex:/^'.preg_quote(Helper::shortProjectCode(), '/').'-'.now()->format('y').'\d{5}$/',
                Rule::unique('project_preparations','control_no')
                    ->ignore($this->route('project_preparation'),'uuid'),
            ],
            'date' => 'required|date_format:Y-m-d',
            'invoice_uuid' => 'required|uuid',
            'details' => 'required',
            'details.*.description' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            'details.*.unit_cost' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'control_no.regex' => "Control number must be in the format ".Helper::shortProjectCode()."-".now()->format('y')."xxxxx."
        ];
    }
}
