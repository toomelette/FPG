<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccounts extends Model
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
    public function subsidiaries()
    {
        return $this->hasMany(SubsidiaryAccounts::class,'parent_account_code','account_code');
    }

    public function lastSubsidiary()
    {
        return $this->hasOne(SubsidiaryAccounts::class,'parent_account_code','account_code')->latestOfMany('account_code');

    }
}
