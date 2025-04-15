<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'transaction_details';

    public function transaction()
    {
        return $this->belongsTo(Transactions::class,'transaction_slug','slug');
    }
    public function offers()
    {
        return $this->hasMany(AQOffers::class,'item_slug','slug')->whereHas('aq');
    }
}