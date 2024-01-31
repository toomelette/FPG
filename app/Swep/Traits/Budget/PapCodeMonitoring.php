<?php

namespace App\Swep\Traits\Budget;

use App\Models\Budget\ORS;
use App\Models\PPU\Pap;
use Illuminate\Http\Request;

trait PapCodeMonitoring
{
    public function papCodeMonitoring(Request $request){
        if(!$request->has('pap_code') || $request->pap_code == '' || $request->pap_code == null ){
            abort(504,'Please select PAP Code');
        }
        if(!$request->has('account_code') || $request->account_code == '' || $request->account_code == null ){
            abort(504,'Please select Account Code');
        }



        $pap = Pap::query()->where('pap_code','=',$request->pap_code)->first();

        $ors = ORS::query()
            ->with(['projectsApplied','orsEntries'])
            ->whereHas('projectsApplied',function ($q) use ($pap){
                return $q->where('pap_code','=',$pap->pap_code);
            })
            ->whereHas('orsEntries',function ($q) use ($request){
                return $q->where('account_code','=',$request->account_code);
            });

        if(($request->has('date_from') && $request->date_from != '') && $request->has('date_to') && $request->date_to != ''){
            $ors = $ors->whereBetween('ors_date',[$request->date_from,$request->date_to]);
        }
        $ors = $ors->get();

        return view('printables.ors.reports.pap_code_monitoring')->with([
            'ors' => $ors,
            'account_code' => $request->account_code,
            'request' => $request,
        ]);
        return $request;
    }
}