<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\SubsidiaryFormRequest;
use Illuminate\Http\Request;

class SubsidiariesController extends Controller
{
    public function validateSubsidiaries(SubsidiaryFormRequest $request)
    {
        return response('Validated', 200);
    }
}