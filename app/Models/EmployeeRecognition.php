<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRecognition extends Model{





	protected $table = 'hr_employee_recognitions';

    public $timestamps = false;
    




    protected $attributes = [
        
        'employee_no' => '',
        'title' => '',

    ];







    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    
    


    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('title', 'desc')->get();

    }


    


    
}
