<?php

namespace App\Http\Requests\FG;

use App\Models\FG\SalesInvoice;
use App\Models\FG\Stocks;
use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DeliveryReceiptsFormRequest extends FormRequest
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
        ]);

    }
    public function rules(): array
    {
        return [
            'type' => 'required',
            'control_no' => [
                'required',
//                'regex:/^'.preg_quote(Helper::shortProjectCode(), '/').'-'.now()->format('y').'\d{5}$/',
                Rule::unique('delivery_receipts','control_no')
                    ->ignore($this->route('delivery_receipt'),'uuid'),
            ],
            'date' => 'required|date_format:Y-m-d',
            'invoice_uuid' => 'required',
            'details' => 'required',
            'details.*.description' => 'required',
            'details.*.qty' => 'required',
            'details.*.uom' => 'required',
            //'details.*.unit_cost' => 'required',
        ];
    }

    public function messages()
    {
        return [
//            'control_no.regex' => "Control number must be in the format ".Helper::shortProjectCode()."-".now()->format('y')."xxxxx."
        ];
    }

    protected function passedValidation()
    {
        if(empty(SalesInvoice::query()->find($this->invoice_uuid))){
            $this->merge([
                'invoice_uuid' => null,
                'temp_name' => $this->invoice_uuid,
            ]);
        }else{
            $this->merge([
                'invoice_uuid' => $this->invoice_uuid,
                'temp_name' => null,
            ]);
        }
    }
}
