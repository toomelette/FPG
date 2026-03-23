<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryReceiptDetails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [
        'id',
    ];
    /* RELATIONSHIPS */
    public function deliveryReceipt()
    {
        return $this->belongsTo(DeliveryReceipts::class,'delivery_receipt_uuid','uuid');
    }
    public function stock()
    {
        return $this->belongsTo(DeliveryReceipts::class,'stock_uuid','uuid');
    }
}
