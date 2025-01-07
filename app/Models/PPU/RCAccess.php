<?php

namespace App\Models\PPU;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RCAccess extends Model
{
    protected $connection = 'mysql_ppu';
    protected $table = 'user_details';

    public function __construct()
    {
        if(Auth::user()->project_id == 1){
            $this->connection = 'mysql_ppu_vis';
        }
    }


}