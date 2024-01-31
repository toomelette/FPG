<?php


namespace App\Swep\Helpers;


use App\Models\SuSettings;
use Carbon\Carbon;

class Get
{
    public static function startAndEndOfQuarter($quarter,$year){
        $quarter = $quarter * 3;
        return [
            'startOfQuarter' => Carbon::parse($year.'-'.str_pad($quarter,2,'0',STR_PAD_LEFT).'-01')->startOfQuarter()->format('Y-m-d'),
            'endOfQuarter' => Carbon::parse($year.'-'.str_pad($quarter,2,'0',STR_PAD_LEFT).'-01')->lastOfQuarter()->format('Y-m-d'),
            'startOfYear' =>Carbon::parse($year.'-'.str_pad($quarter,2,'0',STR_PAD_LEFT).'-01')->firstOfYear()->format('Y-m-d')
        ];
    }

    public static function setting($setting){
        $s = SuSettings::query()->where('setting','=',$setting)->first();
        return $s;
    }

    public static function headerAddress(){
        $project_id = \Auth::user()->project_id;
        if($project_id == 1){
            return 'Araneta St., Singcang, Bacolod City';
        }elseif ($project_id == 2){
            return 'North Ave., Diliman, Quezon City';
        }else{
            abort(503,'PLEASE SET PROJECT ID TO USER | Current project_id assigned: '. ($project_id ?? 'NULL') );
        }
    }

}