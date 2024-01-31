<?php

namespace App\Models\QC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeEducationalBackground extends Model{

    use SoftDeletes;

    protected $connection = 'afd_qc';

	protected $table = 'hr_employee_educational_background';

    protected $dates = [];

    public $timestamps = false;





    protected $attributes = [
        
        'employee_no' => '',
        'level' => '',
        'school_name' => '',
        'course' => '',
        'date_from' => null,
        'date_to' => null,
        'units' => null,
        'graduate_year' => 0,
        'scholarship' => '',
        'honor' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo(Employee::class,'employee_no','employee_no');
    }
    






    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('graduate_year', 'asc')->get();

    }





    
    
}
