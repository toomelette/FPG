<?php

namespace App\Models\FG;

use App\Models\ProjectPreparationDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPreparations extends Model
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
            $a->project_id = \Auth::user()->project_id;
        });
    }

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    /* RELATIONSHIPS */

    public function details()
    {
        return $this->hasMany(ProjectPreparationDetails::class,'project_preparation_uuid','uuid');
    }

    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class,'invoice_uuid','uuid');
    }
}
