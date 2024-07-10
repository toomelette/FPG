<?php

namespace App\Http\Controllers\Test;

use App\Events\TestWebsocket;
use App\Http\Controllers\Controller;

class TestController extends Controller
{

    public function test(){
        event(new TestWebsocket());
    }

    public function monitor(){
        return view('dashboard.test.monitor');
    }
}