<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ProjectFormRequest;
use App\Models\FG\Clients;
use App\Models\FG\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProjectsController extends Controller
{
    private $folder;
    public function __construct()
    {
        $this->folder = 'fg.projects.';
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $projects = Projects::query()
                ->with(['client']);
            return DataTables::of($projects)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with(['data' => $data]);
                })
                ->escapeColumns([''])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(ProjectFormRequest $request)
    {
        $project = new Projects();
        $project->client_uuid = $request->client_uuid;
        $project->uuid = Str::uuid();
        $project->project_code = $request->project_code;
        $project->project_name = $request->project_name;
        $project->delivery_date = $request->delivery_date;
        $project->delivery_address = $request->delivery_address;
        $project->date_started = $request->date_started;
        $project->project_amount = $request->project_amount;
        $project->details = $request->details;
        if($project->save()){
            return $project->only('uuid');
        }
        abort(503);
    }

    public function update(ProjectFormRequest $request,$uuid)
    {
        $project = Projects::query()->findOrFail($uuid);
        $project->client_uuid = $request->client_uuid;
        $project->project_code = $request->project_code;
        $project->project_name = $request->project_name;
        $project->delivery_date = $request->delivery_date;
        $project->delivery_address = $request->delivery_address;
        $project->date_started = $request->date_started;
        $project->project_amount = $request->project_amount;
        $project->details = $request->details;
        if($project->update()){
            return $project->only('uuid');
        }
        abort(503);
    }

    public function edit($uuid)
    {
        $project = Projects::query()
            ->with([
                'client'
            ])
            ->findOrFail($uuid);
        return view($this->folder.'edit')->with([
            'project' => $project,
        ]);
    }

    public function destroy($uuid)
    {
        $project = Projects::query()->findOrFail($uuid);
        if($project->delete()){
            return 1;
        }
        abort(503);
    }
}
