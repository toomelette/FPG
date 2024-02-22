<?php

namespace App\Swep\Helpers;

use App\Models\Employee;

class Json
{
    public static function activeEmployeesSelect2(){
        $emps = Employee::query()
            ->where('is_active','=','ACTIVE')
            ->where(function ($q){
                $q->where('locations','=','VISAYAS')
                    ->orWhere('locations','=','LUZON/MINDANAO');
            })
            ->orderBy('lastname','asc')
            ->get();
        return $emps->map(function ($data){
            return [
                'id' => $data->slug,
                'text'=> $data->fullname,
                'position' => $data->position,
                'lastname' => $data->lastname,
                'firstname' => $data->firstname,
                'middlename' => $data->middlename,
                'monthly_basic' => $data->monthly_basic,
            ];
        })->toJson();
    }
}