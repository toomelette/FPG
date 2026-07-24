<?php

namespace App\Http\Requests\FG;

use App\Models\FG\Stocks;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InventoryTransfersFormRequest extends FormRequest
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

        $inventoryLedger = [];
        $directions = [
            -1 => Auth::user()->warehouse,
            1 => $this->transfer_to,
        ];

        foreach ($this->details as $detail){
            foreach ($directions as $direction => $warehouse) {
                $inventoryLedger[] = [
                    'reference_type'  => 'INVENTORY TRANSFER',
                    'movement_type' =>'TRANSFER',
                    'direction' =>$direction,
                    'warehouse' =>$warehouse,
                    'qty' => $detail['qty'],
                    'date'  => $this->date,
                    'unit_cost'  => isset($detail['unit_cost']) ? (Helper::sanitizeAutonum($detail['unit_cost']) * 1) : null,
                    'amount'  => Helper::sanitizeAutonum($detail['unit_cost']) * $detail['qty'],
                    'stock_uuid'  => $stocks?->firstWhere('uuid',$detail['description'])?->uuid ?? null,
                    'description'  => $stocks?->firstWhere('uuid',$detail['description'])?->name ?? $detail['description'],
                ];
            }
        }

        $this->merge([
            'details' => $details,
            'inventory_ledger' => $inventoryLedger,
            'ewt' => Helper::sanitizeAutonum($this->tax_base),
            'ap' => Helper::sanitizeAutonum($this->vat),
            'total_amount_due' => Helper::sanitizeAutonum($this->total_amount_due),
        ]);
    }

    public function rules(): array
    {
        return [
            'control_no' => [
                'required',
                'regex:/^'.preg_quote(Helper::shortProjectCode(), '/').'-'.now()->format('y').'\d{5}$/',
                Rule::unique('inventory_transfers','control_no')
                    ->ignore($this->route('inventory_transfer'),'uuid'),
            ],
            'date' => 'required|date_format:Y-m-d' ,
            'remarks' => 'required|string',
            'transfer_from' => 'required|string',
            'transfer_to' => 'required|string',
            'details' => 'required',
            'details.*.description' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            'details.*.unit_cost' => 'required',
            //'details.*.warehouse' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'control_no.regex' => "Control number must be in the format ".Helper::shortProjectCode()."-".now()->format('y')."xxxxx."
        ];
    }
}
