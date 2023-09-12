<?php

namespace App\Swep\Services\Accounting;

use App\Models\Accounting\JEV;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CashReceiptsService
{
    public function newJevNo($ref_book, $date){
        $cashReceipts = JEV::query()
            ->where('jev_no','like',Carbon::parse($date)->format('y').'%')
            ->orderBy('ref_book','desc')
            ->cashReceiptsOnly()
            ->first();
        $lastFourDigits = Str::substr($cashReceipts->jev_no ?? Carbon::parse($date)->format('y-m-0000'),6,4) ?? 0;
        $lastFourDigits = $lastFourDigits + 1;

        $newLastFourDigits = str_pad($lastFourDigits,4,'0',STR_PAD_LEFT);
        $newJevNo = Carbon::parse($date)->format('y-m-').$newLastFourDigits;
        return $newJevNo;
    }

    public function findBySlug($slug){
        $cashReceipt = JEV::query()
            ->with(['details.chartOfAccount'])
            ->where('slug','=',$slug)
            ->cashReceiptsOnly()
            ->first();
        return $cashReceipt ?? abort(503,'JEV not found');
    }
}