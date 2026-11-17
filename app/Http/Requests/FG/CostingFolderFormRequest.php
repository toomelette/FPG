<?php

namespace App\Http\Requests\FG;

use App\Models\FG\CostingFolders;
use Illuminate\Foundation\Http\FormRequest;

class CostingFolderFormRequest extends FormRequest
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
    public function rules(): array
    {

        if($this->getMethod() == 'POST'){
            $rules = [
                'folder_code' =>  [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z0-9._ -]+$/',
                ],
                'project_id' => $this->filled('parent_folder_uuid')  ? 'required' : 'nullable',
            ];
            return $rules;
        }

        if($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT'){
            $folder = CostingFolders::query()->findOrFail($this->route('costing_folder'));
            $rules = [
                'folder_code' =>  [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z0-9._ -]+$/',
                ],
            ];
            if(filled($folder->parent_folder_uuid)){
                $rules['project_id'] = 'required';

            }
            return $rules;
        }
    }
}
