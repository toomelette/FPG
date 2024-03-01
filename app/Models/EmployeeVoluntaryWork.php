<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeVoluntaryWork extends Model{





	protected $table = 'hr_employee_voluntary_works';

    protected $dates = ['date_from', 'date_to'];

    public $timestamps = false;

    protected $touches = ['employee'];




    protected $attributes = [
        
        'employee_no' => '',
        'name' => '',
        'address' => '',
        'date_from' => null,
        'date_to' => null,
        'hours' => null,
        'position' => '',

    ];





    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }
    


    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('name', 'desc')->get();

    }






    
}
