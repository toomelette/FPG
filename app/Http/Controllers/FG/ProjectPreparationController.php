<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ProjectPreparationFormRequest;
use App\Models\FG\ProjectPreparations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectPreparationController extends Controller
{
    public function __construct(
        protected $folder = 'fg.project-preparation.',
    )
    {

    }

    public function index(Request $request)
    {
        return view($this->folder.'index');
    }

    public function create(Request $request)
    {
        return view($this->folder.'create');
    }

    public function store(ProjectPreparationFormRequest $request)
    {
        $pp = new ProjectPreparations();
        $pp->uuid = Str::uuid();
        $pp->control_no = $request->control_no;
        $pp->date = $request->date;
        $pp->invoice_uuid = $request->invoice_uuid;
        $pp->remarks = $request->remarks;

        $details = collect($request->details)->values();
        try {
            DB::transaction(function () use ($pp,$request,$details){
                $pp->save();
                $pp->details()->createMany($details);
            });
            return $pp->only('uuid');
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }

        dd($request->all());
    }
}
