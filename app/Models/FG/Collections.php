<?php

namespace App\Models\FG;

use App\Models\Scopes\FG\ProjectIdScope;
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
            $a->project_id = \Auth::user()->project_id;
        });

        static::creating(function ($a){
            $a->user_created = \Auth::user()->user_id ?? null;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
            $a->project_id = \Auth::user()->project_id;
        });
    }
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::addGlobalScope(new ProjectIdScope());
    }
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
