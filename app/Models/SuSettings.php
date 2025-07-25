<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SuSettings extends Model
{
    protected $table = 'su_settings';

    protected $casts = [
        'json_value' => 'array',
    ];

}