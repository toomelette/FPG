<?php

namespace App\Swep\Services\HRU;

use App\Models\HRU\HRRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class HRRequestsService
{
    public function newTrackingNo()
    {
        $prefix = 'AFD-GAD-HRS-CERT-';
        $hrRequests = HRRequests::query()
            ->where('created_at','like',Carbon::now()->format('Y-').'%')
            ->orderBy('tracking_no','desc')
            ->first();

        if(empty($hrRequests)){
            $controlNo = 1;
        }else{
            $controlNo = Str::of($hrRequests->tracking_no)->replace($prefix,'')->toInteger() + 1;
        }
        return $prefix.Str::of($controlNo)->padLeft(4,'0');
    }
}