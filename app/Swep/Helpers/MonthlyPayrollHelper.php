<?php

namespace App\Swep\Helpers;

class MonthlyPayrollHelper
{
    public static function initialize($tree)
    {
        return new MonthlyPayrollHelper($tree);
    }

    public function __construct(
        $tree
    )
    {
        $this->tree = $tree;
    }


    public function recursive($tree){

        foreach ($tree as $item){
            if(!empty($item->children) && $item->children->count() > 0){
                echo view('printables.hru.payroll_preparation.tr_employee')
                    ->with([
                        'rc' => $item,
                        'chunkedIncentives' => $passedValues['chunkedIncentives'],
                        'chunkedDeductions' => $passedValues['chunkedDeductions'],
                        'payrollEmployeesBySlug' => $passedValues['payrollEmployeesBySlug'],
                        'chunkBy' => 3,
                        'depth' => $depth,
                    ])
                    ->render();
                $this->recursiveTree($item->children,$passedValues, $depth + 1);
            }else{
                echo view('printables.hru.payroll_preparation.tr_employee')
                    ->with([
                        'rc' => $item,
                        'chunkedIncentives' => $passedValues['chunkedIncentives'],
                        'chunkedDeductions' => $passedValues['chunkedDeductions'],
                        'payrollEmployeesBySlug' => $passedValues['payrollEmployeesBySlug'],
                        'chunkBy' => 3,
                        'depth' => $depth,
                    ])
                    ->render();
            }
        }
    }
}