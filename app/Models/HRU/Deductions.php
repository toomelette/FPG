<?php

namespace App\Models\HRU;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Deductions extends Model
{
    protected $table = 'hr_pay_deductions';

    public function scopeAvailable(Builder $query){
        $query->where('availables','=',1);
    }
}