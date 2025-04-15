<?php

namespace App\Models\PPUV;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    protected $connection = 'mysql_ppu_vis';
    protected $table = 'suppliers';
}