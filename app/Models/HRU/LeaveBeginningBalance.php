<?php

namespace App\Models\HRU;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class LeaveBeginningBalance extends Model
{
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
    protected $table = 'hr_leave_begbal';
    public $incrementing = false;
    protected $primaryKey = 'slug';
    protected $fillable = ['slug','employee_slug','vl','sl','as_of'];

    public function employee(){
        return $this->hasOne(Employee::class,'slug','employee_slug');
    }
}