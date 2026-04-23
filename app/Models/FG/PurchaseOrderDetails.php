<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetails extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];

    /*Relationships*/
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrders::class,'purchase_order_uuid','uuid');
    }

    public function stock()
    {
        return $this->belongsTo(Stocks::class,'stock_uuid','uuid');
    }
}
