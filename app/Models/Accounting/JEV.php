<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class JEV extends Model
{
    protected $table = 'acctg_jev';

    public function details(){
        return $this->hasMany(JEVDetails::class,'jev_slug','slug')->where('is_corollary','=',0);
    }
    public function corollaryDetails(){
        return $this->hasMany(JEVDetails::class,'jev_slug','slug')->where('is_corollary','=',1);
    }
    public function scopeCashReceiptsOnly(Builder $query){
        $query->where('ref_book','=','CR');
    }
}