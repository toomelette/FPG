<?php

namespace App\Models\FG;

use App\Models\Scopes\FG\ProjectIdScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class PettyCashLiquidations extends Model
{
    use HasFactory;
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

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
            $a->project_id = \Auth::user()->project_id;
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new ProjectIdScope());
    }

    /*Relationships*/
    public function attachments()
    {
        return $this->hasMany(PettyCashLiquidationAttachments::class,'petty_cash_liquidation_uuid','uuid');
    }
}
