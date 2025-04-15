<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class AQOffers extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'aq_offer_details';

    public function aq()
    {
        return $this->belongsTo(AQ::class,'quotation_slug','slug');
    }
}