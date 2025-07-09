<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Model;

class Timekeeping extends Model
{
    protected $table = 'hr_timekeeping';
    protected $primaryKey = 'slug';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }

    public function details()
    {
        return $this->hasMany(TimekeepingDetails::class,'timekeeping_slug','slug');
    }

}