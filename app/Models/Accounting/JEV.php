<?php

namespace App\Models\Accounting;

use App\Models\PPU\RCDesc;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JEV extends Model
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
    protected $table = 'acctg_jev';

    /*RELATIONSHIPS*/
    public function details(){
        return $this->hasMany(JEVDetails::class,'jev_slug','slug')->where('is_corollary','=',0);
    }
    public function corollaryDetails(){
        return $this->hasMany(JEVDetails::class,'jev_slug','slug')->where('is_corollary','=',1);
    }





    /*SCOPES*/
    public function scopeCashReceiptsOnly(Builder $query){
        $query->where('ref_book','=','CR');
    }

    public function scopeCheckDisbursementsOnly(Builder $query){
        $query->where('ref_book','=','CD');
    }

    public function scopeGeneralJournalOnly(Builder $query){
        $query->where('ref_book','=','GJ');
    }

    public function scopeCashDisbursementsOnly(Builder $query){
        $query->where('ref_book','=','CADJ');
    }


}