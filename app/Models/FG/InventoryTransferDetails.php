<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransferDetails extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $timestamps = false;

    public function inventoryTransfer()
    {
        return $this->belongsTo(InventoryTransfers::class,'inventory_transfer_uuid','uuid');
    }
    public function stock()
    {
        return $this->belongsTo(Stocks::class,'stock_uuid','uuid');
    }


}
