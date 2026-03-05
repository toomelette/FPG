<?php

namespace App\Models\FG;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInvoiceDetails extends Model
{
    use HasFactory;


    public $timestamps = false;

    protected $guarded = [
        'uuid', 'id',
    ];
    /*Relationships*/
    public function salesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class,'sales_invoice_uuid','uuid');
    }

}
