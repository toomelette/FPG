<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SSL extends Model
{
    protected $table = 'su_ssl';
    protected $casts = [
        'salary_grade' => 'integer',
        'step1' => 'float',
        'step2' => 'float',
        'step3' => 'float',
        'step4' => 'float',
        'step5' => 'float',
        'step6' => 'float',
        'step7' => 'float',
        'step8' => 'float',
    ];
}