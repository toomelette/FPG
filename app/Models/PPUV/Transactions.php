<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'transactions';

    public function details()
    {
        return $this->hasMany(TransactionDetails::class,'transaction_slug','slug');
    }

    public function aq()
    {
        return $this->hasMany(AQ::class,'aq_slug','slug');
    }
}