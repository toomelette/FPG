<?php

namespace App\Swep\Helpers;

class Defaults
{
    public static function budgetCertified(){
        $projectId = \Auth::user()->project_id;
        switch ($projectId){
            case 1 : return 'HELEN P. BALO';
            break;
            case 2 : return 'RESTY REANO';
            break;
            default: return 'not set';
            break;
        }
    }
    public static function budgetCertifiedPosition(){
        $projectId = \Auth::user()->project_id;
        switch ($projectId){
            case 1 : return 'BUDGET OFFICER IV';
                break;
            case 2 : return 'POSITION';
                break;
            default: return 'not set';
                break;
        }
    }

}