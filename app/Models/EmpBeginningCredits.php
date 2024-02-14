<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpBeginningCredits extends Model{


    protected $table = 'hr_emp_beginning_credits';

    public $timestamps = false;


	/** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_slug','slug');
    }

    
}
