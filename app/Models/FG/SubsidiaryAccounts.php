<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubsidiaryAccounts extends Model
{
    use HasFactory;
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
        });
    }

    /*Relationships*/

    public function account()
    {
        return $this->belongsTo(ChartOfAccounts::class,'parent_account_code','account_code');
    }

    public function client()
    {
        return $this->hasOne(Clients::class,'account_no','account_code');
    }
}
