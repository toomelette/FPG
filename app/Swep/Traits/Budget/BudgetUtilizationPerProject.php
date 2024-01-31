<?php

namespace App\Swep\Traits\Budget;

use App\Models\PPU\Pap;
use Illuminate\Http\Request;

trait BudgetUtilizationPerProject
{
    public function budgetUtilizationPerProject(Request $request){
        $pap = Pap::query()
            ->with(['orsAppliedProjects'])
            ->withSum('orsAppliedProjects','co')
            ->withSum('orsAppliedProjects','mooe')
            ->orderBy('pap_code','asc');
        if($request->has('dept') && $request->dept != ''){
            $pap = $pap->whereHas('responsibilityCenter.description',function ($q) use ($request){
                return $q->where('rc','=',$request->dept);
            });
        }
        $pap = $pap->get();

        return view('printables.ors.reports.budget_utilization_per_project')->with([
            'paps' => $pap,
        ]);
    }
}