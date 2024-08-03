<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EmployeeTraining extends Model{


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

    protected $table = 'hr_employee_trainings';

    protected $dates = ['date_from', 'date_to', 'created_at', 'updated_at'];

    public $timestamps = true;
    use SoftDeletes;
    protected $touches = ['employee'];
    protected $primaryKey = 'slug';
    public $incrementing = false;


    protected $attributes = [
        
        'employee_no' => '',
        'slug' => '',
        'title' => '',
        'type' => '',
        'date_from' => null,
        'date_to' => null,
        'hours' => null,
        'conducted_by' => '',
        'venue' => '',
        'remarks' => '',
        'is_relevant' => false,
        'created_at' => null, 
        'updated_at' => null,
        'ip_created' => '',
        'ip_updated' => '',
        'user_created' => '',
        'user_updated' => '',

    ];






    /** RELATIONSHIPS **/
    public function employee() {
    	return $this->belongsTo('App\Models\Employee','employee_no','employee_no');
    }
    




    /** Scopes **/
    public function scopePopulate($query){

        return $query->orderBy('date_to', 'desc')->get();

    }





}
