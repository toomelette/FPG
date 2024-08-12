<?php

namespace App\Swep\Classes;

use App\Swep\Helpers\Arrays;

class LeaveTypes
{
    public $descriptiveName;
    public $children;
    public $accumulatesYearly;
    public $expiring;
    public function __construct()
    {

    }

    public function leave($leaveCode)
    {
        $this->expiring = $this->expiring()[$leaveCode];
        $this->accumulatesYearly = $this->accumulatesYearly()[$leaveCode];
        $this->descriptiveName = Arrays::leaveTypeCodes()[$leaveCode];
        $this->children = Arrays::leaveTypesTree()[$this->descriptiveName];
        return $this;
    }

    public function hasChildren()
    {
        if(is_array(Arrays::leaveTypesTree()[$this->descriptiveName])){
            return true;
        }else{
            return false;
        }
    }

    public function getCode($name)
    {
        $key = array_search ($name, Arrays::leaveTypeCodes());
        return $key;
    }

    private function accumulatesYearly()
    {
        return [
            'VL' => true,
            'SL' => true,
            'MATERNITY>' => false,
            'PATERNITY' => false,
            'SPECIAL' => false,
            'SOLO' => false,
            'STUDY' => false,
            'VAWC10' => false,
            'REHAB' => false,
            'SLBW' => false,
            'CALAMITY' => false,
            'ADOPTION' => false,
            'CTO' => false,
        ];
    }

    private function expiring()
    {
        return [
            'VL' => false,
            'SL' => false,
            'MATERNITY' => true,
            'PATERNITY' => true,
            'SPECIAL' => true,
            'SOLO' => true,
            'STUDY' => true,
            'VAWC10' => true,
            'REHAB' => true,
            'SLBW' => true,
            'CALAMITY' => true,
            'ADOPTION' => true,
            'CTO' => true,
        ];
    }



}