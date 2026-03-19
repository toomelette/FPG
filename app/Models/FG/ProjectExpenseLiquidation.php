<?php

namespace App\Models\FG;


use App\Models\Scopes\FG\ProjectIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectExpenseLiquidation extends Model
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
    public function details()
    {
        return $this->hasMany(ProjectExpenseLiquidationDetails::class,'project_expense_liquidation_uuid','uuid');
    }

    public function invoice()
    {
        return $this->belongsTo(SalesInvoice::class,'invoice_uuid','uuid');
    }

}
