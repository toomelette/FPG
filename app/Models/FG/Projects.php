<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    use HasFactory;

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

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    /*Relationships*/
    public function client()
    {
        return $this->belongsTo(Clients::class,'client_uuid','uuid');
    }

    public function liquidations()
    {
        return $this->hasMany(ProjectExpenseLiquidation::class,'project_uuid','uuid');
    }
}
