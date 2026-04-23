<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLedger extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function stock()
    {
        return $this->belongsTo(Stocks::class,'stock_uuid','uuid');
    }
}
