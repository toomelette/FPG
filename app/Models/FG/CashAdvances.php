<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CashAdvances extends Model
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
            $a->project_id =  \Auth::user()->project_id;
        });
    }

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    use HasFactory;


    public function scopeUser(Builder $builder)
    {
        $builder->where('user_created','=',Auth::user()->user_id);
    }
}
