<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PS extends Model
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

    protected $table = 'hr_ps';
    public $incrementing = false;
    protected $primaryKey = 'slug';

    public function scopeMy(Builder $query)
    {
        $query->where(function ($q){
            $q->where('employee_slug','=',Auth::user()->employee->slug)
                ->orWhere('user_created','=',Auth::user()->user_id);
        });
        /*
        $query->where('employee_slug','=',Auth::user()->employee->slug)
        $query->where('user_created','=',Auth::user()->user_id);
        */
    }

}