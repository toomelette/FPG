<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class JEV extends Model
{
    protected $table = 'acctg_jev';

    public function details(){
        return $this->hasMany(JEVDetails::class,'jev_slug','slug');
    }

}