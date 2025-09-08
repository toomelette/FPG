<?php

namespace App\Swep\Services\HRU;

use App\Models\Employee;
use App\Models\HRU\Deductions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DeductionRegistryService
{
    protected $start;
    public function __construct()
    {
        $this->start = '2025-01-01';
    }

    private function yearsToShow()
    {
        $startYear = Carbon::parse($this->start)->year;
        $now = Carbon::now()->month;
        $endYear = Carbon::now()->year;
        if($now == 12){
            //It's december (add another year)
            $endYear++;
        }
        $monthsArray = [];
        for($i = $endYear; $i >= $startYear; $i--){
            $months = [];
            for ($m = 1; $m <= 12;$m++){
                $months[] = $i.'-'.Str::of($m)->padLeft(2,0)->toString().'-01';
            }
            $monthsArray[$i] = $months;
        }
        return $monthsArray;

    }


    public function index(Request $request, $deductionGroup)
    {
        if($request->ajax() && $request->has('getDeductions') && $request->getDeductions == true){
            $employees = Employee::query()
                ->whereJsonContains('deduction_groups',$deductionGroup)
                ->permanent()
                ->active()
                ->applyProjectId()
                ->orderBy('lastname')
                ->get();

            $deductions = Deductions::query()
                ->where('groupings','=',$deductionGroup)
                ->get();

            return view('_payroll.deduction-registry.content')->with([
                'month' => $request->month,
                'employees' => $employees,
                'deductions' => $deductions,
            ]);
        }
        return view('_payroll.deduction-registry.index')->with([
            'start' => $this->start,
            'monthsArray' => $this->yearsToShow(),
            'deductionGroup' => $deductionGroup,
        ]);
    }
}