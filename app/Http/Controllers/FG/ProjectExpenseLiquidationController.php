<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ProjectExpenseLiquidationFormRequest;
use App\Models\FG\ProjectExpenseLiquidation;
use App\Models\FG\ProjectExpenseLiquidationDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectExpenseLiquidationController extends Controller
{
    private $folder;
    public function __construct()
    {
        $this->folder = 'fg.project-expense-liquidation.';
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $projectExpenseLiquidations = ProjectExpenseLiquidation::query()
                ->with([
                    'project.client',
                ]);
            return DataTables::of($projectExpenseLiquidations)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('details',function ($data){

                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function create()
    {
        return view($this->folder.'create');
    }


    public function store(ProjectExpenseLiquidationFormRequest $request)
    {
        $projectExpenseLiquidation = new ProjectExpenseLiquidation();
        $projectExpenseLiquidation->uuid = Str::uuid();
        $projectExpenseLiquidation->control_no = $request->control_no;
        $projectExpenseLiquidation->date = $request->date;
        $projectExpenseLiquidation->project_uuid = $request->project_uuid;
        $details = collect($request->details)->values();

        $details = $details->map(function ($item) use ($projectExpenseLiquidation){
            return $item;
        });

        try {
            DB::transaction(function ($transaction) use ($projectExpenseLiquidation, $details){
                $projectExpenseLiquidation->save();
                $projectExpenseLiquidation->details()->createMany($details->toArray());
            });
            return $projectExpenseLiquidation->only('uuid');
        }catch (\Exception $exception){
            abort(503);
        }

    }

    public function edit($uuid)
    {
        $projectExpenseLiquidation = ProjectExpenseLiquidation::query()
            ->with([
                'details','project'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'projectExpenseLiquidation' => $projectExpenseLiquidation
        ]);
    }

    public function update(ProjectExpenseLiquidationFormRequest $request,$uuid)
    {

        $projectExpenseLiquidation = ProjectExpenseLiquidation::query()
            ->findOrFail($uuid);
        $projectExpenseLiquidation->control_no = $request->control_no;
        $projectExpenseLiquidation->date = $request->date;
        $projectExpenseLiquidation->project_uuid = $request->project_uuid;
        $details = collect($request->details)->values();

        $details = $details->map(function ($item) use ($projectExpenseLiquidation){
            return $item;
        });

        DB::transaction(function ($transaction) use ($projectExpenseLiquidation, $details){
            $projectExpenseLiquidation->save();
            $projectExpenseLiquidation->details()->delete();
            $projectExpenseLiquidation->details()->createMany($details->toArray());
        });
        if($projectExpenseLiquidation->id){
            return $projectExpenseLiquidation->only('uuid');
        }
        abort(503);
    }

    public function destroy($uuid)
    {
        $projectExpenseLiquidation = ProjectExpenseLiquidation::query()
            ->findOrFail($uuid);
        try {
            DB::transaction(function ($q) use ($projectExpenseLiquidation){
                $projectExpenseLiquidation->delete();
                $projectExpenseLiquidation->details()->delete();
            });
            return 1;
        }catch (\Exception $e){
            abort(503);
        }
    }
}