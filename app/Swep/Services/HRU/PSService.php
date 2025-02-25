<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\PS;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PSService
{

    public function newPsNo($count = 1)
    {
        $year = Carbon::now()->format('y');
        $prefix = 'PS-'.$year.'-';
        $ps = PS::query()->where('ps_no','like',$prefix.'%')->orderBy('ps_no','desc')->first();
        $index = 1;
        if(!empty($ps)){
            $index = Str::of($ps->ps_no)->remove($prefix)->value() * 1 + 1;
        }

        $psNos = [];
        for ($i = 0;$i < $count;$i ++){
            $psNos[] = $newPsNo = $prefix.Str::of($index + $i)->padLeft(4,0);
        }

        return $psNos;
    }
}