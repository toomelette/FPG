<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\HRU\Deductions;
use App\Swep\Services\HRU\DeductionRegistryService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DeductionSudemupcoController extends Controller
{
    public $deductionGroup;
    public function __construct(protected DeductionRegistryService $deductionRegistryService)
    {

        $this->deductionGroup = 'SUDEMUPCO';
    }


    public function index(Request $request)
    {
        return $this->deductionRegistryService->index($request,$this->deductionGroup);
    }
}