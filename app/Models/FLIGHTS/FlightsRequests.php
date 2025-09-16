<?php

namespace App\Models\FLIGHTS;

use Illuminate\Database\Eloquent\Model;

class FlightsRequests extends Model
{
    protected $table = 'flights_requests';
    protected $primaryKey = 'slug';
    public $incrementing = false;


}