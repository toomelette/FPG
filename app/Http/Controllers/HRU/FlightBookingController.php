<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FlightBookingController extends Controller
{
    public function create(Request $request)
    {
        return view('_hru.flight-booking.create');
    }
}