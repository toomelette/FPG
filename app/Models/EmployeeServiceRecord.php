<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeServiceRecord extends Model{


    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }



	protected $table = 'hr_employee_service_records';

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = true;
    protected $touches = ['employee'];

    protected $primaryKey = 'slug';
    public $incrementing = false;
    use SoftDeletes;

    protected $casts = [
        'salary' => 'float',
    ];



    protected $attributes = [
        
        'slug' => '',
        'employee_no' => '',
        'sequence_no' => null,
        'date_from' => '',
        'date_to' => '',
        'position' => '',
        'appointment_status' => '',
        'salary' => 0.00,
        'mode_of_payment' => '',
        'station' => '',
        'gov_serve' => '',
        'psc_serve' => '',
        'lwp' => '',
        'spdate' => '',
        'status' => '',
        'remarks' => '',
        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];





    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo(Employee::class,'employee_slug','slug');
    }
    



    
    

}
