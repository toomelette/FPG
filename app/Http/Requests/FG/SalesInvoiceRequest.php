<?php

namespace App\Http\Requests\FG;

use App\Models\FG\Stocks;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class SalesInvoiceRequest extends FormRequest
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
                return $detail;
            })
            ->toArray();
        $this->merge([
            'details' => $details,
            'tax_base' => Helper::sanitizeAutonum($this->tax_base),
            'vat' => Helper::sanitizeAutonum($this->vat),
            'total_amount_due' => Helper::sanitizeAutonum($this->total_amount_due),
        ]);
    }

    public function rules(): array
    {
        return [
            'control_no' => 'required',
            'date' => 'required|date_format:Y-m-d' ,
            'project_uuid' => 'required',
            'details' => 'required',
            'details.*.description' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            'details.*.unit_cost' => 'required',
            'total_amount_due' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'details.required' => 'At least one row in DETAILS is required',
        ];
    }
}
