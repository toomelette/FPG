<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\HRU\Deductions;
use App\Models\Employee;
use Illuminate\Http\Request;

class DeductionRegistryController extends Controller
{
    public function index()
    {
        dd(url()->previous());
    }
    public function edit($deductionGroup)
    {
        $employees = Employee::query()
            ->permanent()
            ->active()
            ->applyProjectId()
            ->orderBy('lastname');
        $employeesUsingDeduction = (clone $employees)
            ->whereJsonContains('deduction_groups',$deductionGroup)
            ->get();


        return view('_payroll.deduction-registry.edit')->with([
            'employees' => $employees->get(),
            'employeesUsingDeduction' => $employeesUsingDeduction,
        ]);
    }

    public function update($deductionGroup, Request $request)
    {
        $selectedEmployeesSlug = $request->employees;
        $selectedEmployees = Employee::query()->whereIn('slug',$selectedEmployeesSlug)->get();
        $dataToUpsert = [];
        foreach ($selectedEmployees as $selectedEmployee){
            $employeeDeductionGroups = collect($selectedEmployee->deduction_groups);
            if(!$employeeDeductionGroups->contains($deductionGroup)){
                $employeeDeductionGroups->push($deductionGroup);
            }
            $dataToUpsert[] = [
                'slug' => $selectedEmployee->slug,
                'deduction_groups' => json_encode($employeeDeductionGroups->toArray()),
            ];

        }

        if(Employee::query()->upsert($dataToUpsert,'slug',['deduction_groups'])){
            return true;
        }
        abort(503,'Error saving employees');

    }
}