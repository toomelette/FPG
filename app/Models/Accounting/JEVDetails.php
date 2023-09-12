<?php

namespace App\Models\Accounting;

use App\Models\Budget\ChartOfAccounts;
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
}