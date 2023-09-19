<?php

namespace App\Models\Accounting;

use App\Models\Budget\ChartOfAccounts;
use App\Models\PPU\PPURespCodes;
use App\Models\PPU\RCDesc;
use Illuminate\Database\Eloquent\Model;

class JEVDetails extends Model
{
    protected $table = 'acctg_jev_details';

    public function jev(){
        return $this->belongsTo(JEV::class,'jev_slug','slug');
    }

    public function chartOfAccount(){
        return $this->hasOne(ChartOfAccounts::class,'account_code','account_code');
    }

    public function responsibilityCenter(){
        return $this->belongsTo(PPURespCodes::class,'resp_center','rc_code');
    }

    public function department(){
        return $this->hasOne(RCDesc::class,'rc','resp_center');
    }
}