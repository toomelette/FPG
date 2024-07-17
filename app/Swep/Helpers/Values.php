<?php

namespace App\Swep\Helpers;

class Values
{
    public static function leaveApplicationCertification(){
        return [
            'name' => 'Lucille Mae M. Sy',
            'position' => 'HRMO IV',
        ];
    }

    public static function headerAddress(){
        return 'Sugar Center Bldg., North Avenue, Diliman, Quezon City';
    }

    public static function payrollBoxes(){
        if(\Auth::user()->project_id == 1){
            return [
                'a_name' => 'LUCILLE MAE M. SY',
                'a_position' => 'HRMO IV',
                'b_name' => 'FELICIDAD B. LOPEZ',
                'b_position' => 'OIC, Chief Finance Officer',
                'c_name' => 'ATTY. BRANDO D. NOROÑA',
                'c_position' => 'Deputy Administrator II',
                'd_name' => 'ALVIN CASUYON',
                'd_position' => 'Cashier III',
            ];
        }else{
            return [
                'a_name' => 'NARCISO R. CABALQUINTO JR',
                'a_position' => 'OIC, General Admin. Division',
                'b_name' => 'PORTIA I. ASENTISTA',
                'b_position' => 'OIC, Accounting Division',
                'c_name' => 'ATTY. BRANDO D. NOROÑA',
                'c_position' => 'Deputy Administrator II',
                'd_name' => 'MARIE STELLA W. PATATAG',
                'd_position' => 'Cashier III',
            ];
        }
    }
}