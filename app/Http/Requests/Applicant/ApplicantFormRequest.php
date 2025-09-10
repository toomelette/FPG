<?php

namespace App\Http\Requests\Applicant;

use Illuminate\Foundation\Http\FormRequest;

class ApplicantFormRequest extends FormRequest{





    public function authorize(){

        return true;
    
    }

    



    public function rules(){

        $rows_edc_background = $this->request->get('row_edc_background');
        $rows_trainings = $this->request->get('row_training');
        $rows_exp = $this->request->get('row_exp');
        $rows_elig = $this->request->get('row_elig');

        $rules = [
            
            'lastname'=>'required|string|max:90',
            'firstname'=>'required|string|max:90',
//            'middlename'=>'required|string|max:90',
//            'gender'=>'required|string|max:11',
//            'date_of_birth' => 'required|date_format:"Y-m-d"',
//            'civil_status'=>'required|string|max:45',
//            'address'=>'required|string|max:255',
            'course'=>'required|string|max:255',
//            'plantilla_id'=>'nullable|string|max:11',
            'contact_no'=>'nullable|string|max:90',
            'email'=>'nullable|email|string|max:255',
//            'received_at' => 'required|date_format:"Y-m-d"',
//            'remarks'=>'nullable|string|max:255',
//            'position_applied' => 'required|string',

        ];

        // EDC Background
        if(!empty($rows_edc_background)){
            foreach($rows_edc_background as $key => $value){   
                $rules['row_edc_background.'.$key.'.course'] = 'required|string|max:255';
                $rules['row_edc_background.'.$key.'.school'] = 'required|string|max:255';
                $rules['row_edc_background.'.$key.'.units'] = 'nullable|string|max:45';
                $rules['row_edc_background.'.$key.'.graduate_year'] = 'required|string|max:11';
            } 
        }

        // Trainings
        if(!empty($rows_trainings)){
            foreach($rows_trainings as $key => $value){   
                $rules['row_training.'.$key.'.title'] = 'required|string|max:255';
                $rules['row_training.'.$key.'.date_from'] = 'nullable|date_format:"m/d/Y"';
                $rules['row_training.'.$key.'.date_to'] = 'nullable|date_format:"m/d/Y"';
                $rules['row_training.'.$key.'.venue'] = 'nullable|string|max:255';
                $rules['row_training.'.$key.'.conducted_by'] = 'nullable|string|max:255';
                $rules['row_training.'.$key.'.remarks'] = 'nullable|string|max:255';
            } 
        }

        // Experience
        if(!empty($rows_exp)){
            foreach($rows_exp as $key => $value){
                $rules['row_exp.'.$key.'.date_from'] = 'nullable|date_format:"m/d/Y"';
                $rules['row_exp.'.$key.'.date_to'] = 'nullable|date_format:"m/d/Y"';
                $rules['row_exp.'.$key.'.position'] = 'nullable|string|max:90';
                $rules['row_exp.'.$key.'.company'] = 'required|string|max:255';
                $rules['row_exp.'.$key.'.is_gov_service'] = 'required|string|max:11';
            } 
        }

        // Eligibility
        if(!empty($rows_elig)){
            foreach($rows_elig as $key => $value){
                $rules['row_elig.'.$key.'.eligibility'] = 'required|string|max:255';
                $rules['row_elig.'.$key.'.level'] = 'nullable|string|max:45';
                $rules['row_elig.'.$key.'.rating'] = 'required|numeric';
                $rules['row_elig.'.$key.'.exam_place'] = 'nullable|string|max:255';
                $rules['row_elig.'.$key.'.exam_date'] = 'nullable|date_format:"m/d/Y"';
            } 
        }

        return $rules;
    
    }





}
