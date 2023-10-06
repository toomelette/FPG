<?php


namespace App\Swep\Services\Budget;


use App\Models\Budget\ORSProjectsApplied;
use App\Models\PPU\Pap;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PapService
{
    public function getBalancesBySlug($slug){
        $pap = $this->findBySlug($slug);
        $appliedProjects = ORSProjectsApplied::query()
            ->selectRaw('sum(mooe) as mooe, sum(co) as co')
            ->where('pap_code','=',$pap->pap_code)->first();
        $arr = [
            'budget' => [
                'mooe' => $pap->mooe ?? 0,
                'co' => $pap->co ?? 0,
            ],
            'utilized' => [
                'mooe' => $appliedProjects->mooe ?? 0,
                'co' => $appliedProjects->co ?? 0,
            ],
        ];
        $arr['balance'] = [
            'mooe' => $arr['budget']['mooe'] - $arr['utilized']['mooe'],
            'co' => $arr['budget']['co'] - $arr['utilized']['co'],
        ];
        return $arr;
    }

    public function newPapCode($year , $respCenter){
        $year = Carbon::parse($year.'-01-01')->format('y');
        $basePapCode = $year.'-'.$respCenter.'-';
        $pap = PAP::query()->where('pap_code','like',$basePapCode.'%')->orderBy('pap_code','desc')->first();
        if(empty($pap)){
            return $newPapCode = $basePapCode.str_pad(1,2,'0',STR_PAD_LEFT);
        }else{
            $papSequence = $pap->pap_code;
            $basePapSequence = Str::substr($papSequence,-2,2);
            $newBasePapSequence = str_pad($basePapSequence + 1,2,'0',STR_PAD_LEFT);
            return $basePapCode.$newBasePapSequence;
        }

    }


    public function findBySlug($slug){
        $pap = Pap::query()
            ->with([
                'responsibilityCenter',
                'orsAppliedProjects',
                'procurementsPr' => function($q){
                    return $q->receivedAndNotCancelled();
                },
                'procurementsJr' => function($q){
                    return $q->receivedAndNotCancelled();
                },
                'increaseInBudget',
                'decreaseInBudget',
            ])
            ->where('slug','=',$slug)->first();
        return $pap ?? abort(503,'PAP not found.');
    }
}