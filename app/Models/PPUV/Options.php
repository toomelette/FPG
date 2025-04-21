<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'options';
}