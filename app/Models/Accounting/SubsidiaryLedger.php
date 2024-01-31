<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class SubsidiaryLedger extends Model
{
    protected $table = 'acctg_subsidiary_ledger';
    public function jevDetail(){
        return $this->belongsTo(JEVDetails::class,'jev_detail_slug','slug');
    }
}