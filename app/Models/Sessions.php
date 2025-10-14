<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sessions extends Model
{
    protected $table = 'sessions';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}