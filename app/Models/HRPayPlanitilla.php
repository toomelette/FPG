<?php


namespace App\Models;


use App\Models\HRU\HrPlantillaClassification;
use Illuminate\Database\Eloquent\Model;

class HRPayPlanitilla extends Model
{
    protected $table = 'hr_pay_plantilla';
//    protected $connection = 'server5';
    public function incumbentEmployee(){
        return $this->hasOne(Employee::class,'item_no','item_no')->where('is_active','=','ACTIVE');
    }

//    public function occupants(){
//        return $this->hasMany(HrPayPlantillaEmployees::class,'item_no','item_no')->orderBy('appointment_date','desc');
//    }
    public function occupants(){
        return $this->hasMany(Employee::class,'item_no','item_no')->where('is_active','!=','ACTIVE');
    }

    public function applicants(){
        return $this->hasMany(ApplicantPositionApplied::class,'item_no','item_no');
    }

    public function classifications()
    {
        return $this->hasMany(HrPlantillaClassification::class,'item_no','item_no');
    }
}