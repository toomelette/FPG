<?php

namespace App\Http\Requests\FG;

use App\Models\FG\Stocks;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
                $detail['amount'] = Helper::sanitizeAutonum($detail['unit_cost']) * $detail['qty'];
                $detail['stock_uuid'] = $stocks?->firstWhere('uuid',$detail['description'])?->uuid ?? null;
                $detail['description'] = $stocks?->firstWhere('uuid',$detail['description'])?->name ?? $detail['description'];
                $detail['warehouse']= Auth::user()->warehouse;
                return $detail;
            })
            ->toArray();
        $inventoryLedger = collect($this->details ?? [])
            ->map(function ($detail) use ($stocks){
                $detail['date'] = $this->date;
                $detail['reference_type'] = 'SALES INVOICE';
                $detail['movement_type'] = 'OUT';
                $detail['direction'] = -1;
                $detail['unit_cost'] = isset($detail['unit_cost']) ? (Helper::sanitizeAutonum($detail['unit_cost']) * 1) : null;
                $detail['amount'] = Helper::sanitizeAutonum($detail['unit_cost']) * $detail['qty'];
                $detail['stock_uuid'] = $stocks?->firstWhere('uuid',$detail['description'])?->uuid ?? null;
                $detail['description'] = $stocks?->firstWhere('uuid',$detail['description'])?->name ?? $detail['description'];
                $detail['warehouse']= Auth::user()->warehouse;
                unset($detail['description']);
                return $detail;
            })
            ->toArray();
        $this->merge([
            'details' => $details,
            'inventory_ledger' => $inventoryLedger,
            'tax_base' => Helper::sanitizeAutonum($this->tax_base),
            'vat' => Helper::sanitizeAutonum($this->vat),
            'total_amount_due' => Helper::sanitizeAutonum($this->total_amount_due),
        ]);
    }

    public function rules(): array
    {

        if($this->has('cancel')){
            return  [];
        }

        $rules = [
            'invoice_no' => [
                'required',
                Rule::unique('sales_invoices','invoice_no')
                    ->where('ref_book',$this->book)
                    ->ignore($this->route('sales_invoice'),'uuid'),
            ],
            'book' => 'required',
            'date' => 'required|date_format:Y-m-d' ,
            'client_uuid' => 'required|string',
            'details' => 'required',
            'details.*.description' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            'details.*.unit_cost' => 'required',
            'total_amount_due' => 'required',
        ];

        if($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT'){
            unset($rules['book']);
        }
        return  $rules;
    }

    public function messages()
    {
        return [
            'details.required' => 'At least one row in DETAILS is required',
        ];
    }
}
