<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collections extends Model
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

    /* Relationships */
    public function distributions()
    {
        return $this->hasMany(CollectionDistributions::class,'collection_uuid','uuid');
    }
    public function checks()
    {
        return $this->hasMany(CollectionChecks::class,'collection_uuid','uuid');
    }
}
