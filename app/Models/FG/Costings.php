<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Costings extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;


    public function logs(){
        return $this->hasMany(CostingLogs::class,'costing_uuid','uuid');
    }
    public function latestLogs()
    {
        return $this->hasMany(CostingLogs::class, 'costing_uuid', 'uuid')
            ->orderByDesc('created_at')
            ->limit(5);
    }
}
