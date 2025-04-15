<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class AQ extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'aq_quotations';

    public function sup()
    {

    }
}