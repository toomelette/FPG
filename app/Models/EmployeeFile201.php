<?php


namespace App\Models;


use Auth;
use Illuminate\Database\Eloquent\Model;

class EmployeeFile201 extends Model
{
    public static function boot()
    {
        parent::boot();
        static::creating(function ($a){
            $a->user_created = Auth::user()->user_id;
            $a->ip_created = request()->ip();
        });

        static::updating(function ($a){
            $a->user_updated = Auth::user()->user_id;
            $a->ip_updated = request()->ip();
        });
    }

    protected $table = 'hr_employee_file201';

    public function employeeData(){
        return $this->belongsTo(Employee::class,'employee_slug','slug');
    }


}