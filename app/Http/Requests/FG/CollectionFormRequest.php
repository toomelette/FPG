<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class CollectionFormRequest extends FormRequest
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

        $distributions = collect($this->distributions ?? [])
            ->map(function ($distribution){
                $distribution['amount'] = isset($distribution['amount']) ? (Helper::sanitizeAutonum($distribution['amount']) * 1) : null;
                return $distribution;
            });
        $checks = collect($this->checks ?? [])
            ->map(function ($check){
                $check['amount'] = isset($check['amount']) ? (Helper::sanitizeAutonum($check['amount']) * 1) : null;
                return $check;
            });

        $cwt = Helper::sanitizeAutonum($this->cwt);
        $totalCheck = $checks->sum('amount');
        $totalCash = Helper::sanitizeAutonum($this->total_cash) * 1;
        $totalAmount = $totalCash + $totalCheck;
        $this->merge([
            'distributions' => $distributions->toArray(),
            'checks' => $checks->toArray(),
            'total_check' => $totalCheck,
            'total_cash' => $totalCash,
            'total_amount' => $totalAmount,
            'cwt' => $cwt,
            'total_paid' => $totalAmount - $cwt,
        ]);
    }

    public function rules(): array
    {
        return [
            'payment_type' => 'required',
            'ref_no' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'payor' => 'required',
        ];
    }
}
