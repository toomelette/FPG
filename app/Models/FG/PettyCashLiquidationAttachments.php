<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashLiquidationAttachments extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    /*Relationships*/
    public function pettyCash()
    {
        return $this->belongsTo(PettyCashLiquidations::class,'petty_cash_liquidation_uuid','uuid');
    }
}
