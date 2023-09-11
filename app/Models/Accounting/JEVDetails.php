<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class JEVDetails extends Model
{
    protected $table = 'acctg_jev_details';

    public function jev(){
        return $this->belongsTo(JEV::class,'jev_slug','slug');
    }
}