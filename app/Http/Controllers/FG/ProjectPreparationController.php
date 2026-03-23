<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ProjectPreparationFormRequest;
use App\Models\FG\ProjectPreparations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectPreparationController extends Controller
{
    public function __construct(
        protected $folder = 'fg.project-preparation.',
    )
    {

    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $pps = ProjectPreparations::query()
                ->with([
                    'invoice.client',
                ])
                ->withSum('details','amount');
            return DataTables::of($pps)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
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
    }

    public function update(ProjectPreparationFormRequest $request,$uuid)
    {

        $pp = ProjectPreparations::query()->findOrFail($uuid);
        $pp->control_no = $request->control_no;
        $pp->date = $request->date;
        $pp->invoice_uuid = $request->invoice_uuid;
        $pp->remarks = $request->remarks;

        $details = collect($request->details)->values();
        try {
            DB::transaction(function () use ($pp,$request,$details){
                $pp->save();
                $pp->details()->delete();
                $pp->details()->createMany($details);
            });
            return $pp->only('uuid');
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
    }

    public function edit($uuid)
    {
        $pp = ProjectPreparations::query()
            ->with(['details','invoice.client'])
            ->withSum('details','amount')
            ->findOrFail($uuid);
        return view('fg.project-preparation.edit')->with([
            'pp' => $pp,
        ]);
    }

    public function destroy($uuid)
    {
        $pp = ProjectPreparations::query()->findOrFail($uuid);

        try {
            DB::transaction(function () use ($pp){
                $pp->delete();
                $pp->details()->delete();
            });
            return 1;
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }

    }
}
