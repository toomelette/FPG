<?php

namespace App\Http\Requests\FG;

use App\Swep\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class GeneralJournalsFormRequest extends FormRequest
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
        $entries = collect($this->entries ?? [])
            ->map(function ($entry){
                $entry['debit'] = isset($entry['debit']) ? (Helper::sanitizeAutonum($entry['debit']) * 1) : null;
                $entry['credit'] = isset($entry['credit']) ? (Helper::sanitizeAutonum($entry['credit']) * 1) : null;
                return $entry;
            });
        $subsidiaryLedgers = nested_collection(json_decode($this->subsidiary_ledgers));
        $this->merge([
            'entries' => $entries->toArray(),
            'check_amount' => Helper::sanitizeAutonum($this->check_amount) * 1,
            'subsidiary_ledgers' => $subsidiaryLedgers,
        ]);
    }

    public function rules(): array
    {
        if(collect($this->entries)->sum('debit') !== collect($this->entries)->sum('credit')){
            abort(503,'Debit and Credit not equal');
        }
        return [
            'control_no' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'entries.*.account_code' => 'required',
            'entries.*.debit'  => 'nullable|required_without:entries.*.credit',
            'entries.*.credit' => 'nullable|required_without:entries.*.debit',
        ];
    }
}
