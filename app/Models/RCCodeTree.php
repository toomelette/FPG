<?php

namespace App\Models;

use App\Models\PPU\PPURespCodes;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class RCCodeTree extends Model
{
    use HasRecursiveRelationships;
    protected $table = 'su_resp_center_tree';

    public function getLocalKeyName()
    {
        return 'rc_code';
    }

    public function getParentKeyName()
    {
        return 'parent_rc_code';
    }

    public function respCenter(){
        return $this->hasOne(PPURespCodes::class,'rc_code','rc_code');
    }
}