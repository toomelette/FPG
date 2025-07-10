<?php

namespace App\Http\Controllers\Api\DTR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QcDtrController extends Controller
{
    public function store(Request $request)
    {
        dd($request->all(),1);
    }
}