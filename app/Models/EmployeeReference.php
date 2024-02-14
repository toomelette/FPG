<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeReference extends Model{





	protected $table = 'hr_employee_references';

    public $timestamps = false;
    





    protected $attributes = [
        
        'employee_no' => '',
        'fullname' => '',
        'address' => '',
        'tel_no' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    




    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('fullname', 'desc')->get();

    }






   
}
