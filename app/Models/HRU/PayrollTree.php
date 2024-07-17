<?php

namespace App\Models\HRU;

use App\Models\PPU\PPURespCodes;
use Illuminate\Database\Eloquent\Model;

class PayrollTree extends Model
{
    protected $table = 'hr_pay_tree';

    public function responsibilityCenter(){
        return $this->hasOne(PPURespCodes::class,'rc_code','resp_center');
    }
}