<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class COS extends Model
{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = \Auth::user()->user_id ?? null;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id ?? null;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }
    protected $table = 'hr_cos';
    protected $primaryKey = 'slug';
    public $incrementing = false;

    public function employees()
    {
        return $this->hasMany(COSEmployees::class,'cos_slug','slug');
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('is_active','=',1);
    }

}