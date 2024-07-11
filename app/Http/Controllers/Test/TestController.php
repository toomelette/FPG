<?php

namespace App\Http\Controllers\Test;

use App\Events\MisRequest\NewRequest;
use App\Events\TestWebsocket;
use App\Http\Controllers\Controller;
use App\Models\MisRequests;

class TestController extends Controller
{

    public function test(){
        $content = 'Istallation of MS OFFICE';
        $misRequest = MisRequests::query()->orderBy('id','desc')->first();
        event(new NewRequest($misRequest));
    }

    public function monitor(){
        return view('dashboard.test.monitor');
    }
}