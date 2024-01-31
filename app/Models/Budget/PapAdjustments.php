<?php

namespace App\Models\Budget;

use App\Models\PPU\Pap;
use Auth;
use Illuminate\Database\Eloquent\Model;

class PapAdjustments extends Model
{
    public static function boot()
    {
        parent::boot();
        static::updating(function($a){
            $a->user_updated = Auth::user()->user_id;
            $a->ip_updated = request()->ip();
            $a->updated_at = \Carbon::now();
        });

        static::creating(function ($a){
            $a->user_created = Auth::user()->user_id;
            $a->ip_created = request()->ip();
            $a->created_at = \Carbon::now();
        });
    }
    protected $table = 'budget_pap_adjustments';

    public function sourcePap(){
        return $this->belongsTo(Pap::class,'source_slug','slug');
    }
    public function destinationPap(){
        return $this->belongsTo(Pap::class,'destination_slug','slug');
    }
}