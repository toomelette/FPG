<?php

namespace App\Swep\Services\HRU;

use App\Models\Employee;
use App\Models\LeaveCard;
use App\Models\SU\SuNotifications;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class LeaveCreditService
{
    public function monthlyCreditToEmployees()
    {
//        if(!Carbon::now()->isLastOfMonth()){
//            return false;
//        }
        $insert = [];
        $permanentEmployees = Employee::query()
            ->permanent()
            ->active()
            ->get();
        $employeesWithoutVLRemaining = [];
        foreach ($permanentEmployees as $employee){
            $vlBalance = $employee->leave_balances['VL']['balance'] ?? 0;
            if($vlBalance > 0){
                $insert[] = [
                    'slug' => Str::random(),
                    'employee_slug' => $employee->slug,
                    'date' => Carbon::now()->format('Y-m-d'),
                    'credits' => 1.25,
                    'leave_card' => 'VL',
                    'remarks' => 'MONTHLY SYSTEM CREDIT',
                    'type' => 'CREDIT',
                ];
            }else{
                $employeesWithoutVLRemaining = [
                    'type' => 'LEAVE_CARD',
                    'text' => $employee->full['LFEMi'].' has no VLs left for the month of '.Carbon::now()->format('F Y').'. Kindly encode the monthly VL credit manually.',
                    'subject' => $employee->slug,
                    'model' => get_class($employee),
                ];
            }
            $insert[] = [
                'slug' => Str::random(),
                'employee_slug' => $employee->slug,
                'date' => Carbon::now()->format('Y-m-d'),
                'credits' => 1.25,
                'leave_card' => 'SL',
                'remarks' => 'MONTHLY SYSTEM CREDIT',
                'type' => 'CREDIT',
            ];
        }
        $chunks = collect($insert)->chunk(200);
//        foreach ($chunks as $chunk){
//            LeaveCard::query()->insert($chunk->toArray());
//        }
//        SuNotifications::query()->insert($employeesWithoutVLRemaining);

        return true;
    }
}