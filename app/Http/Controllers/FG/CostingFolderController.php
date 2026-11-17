<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CostingFolderFormRequest;
use App\Models\FG\CostingFolders;
use App\Models\FG\Costings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use function Ramsey\Uuid\v1;

class CostingFolderController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $folders = CostingFolders::query()
                ->withCount(['children'])
                ->parentsOnly();

            return DataTables::of($folders)
                ->addColumn('details',fn($data) => $data->children_count > 0 ? $data->children_count.' <small>folder(s) inside</small> ': '')
                ->addColumn('action',fn($data) => view('fg.costing-folder.dt-actions')->with(['data' => $data]))
                ->editColumn('folder_code',fn($data) => view('fg.costing-folder.dt-folder-code')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view('fg.costing-folder.index');
    }

    public function store(CostingFolderFormRequest $request)
    {
        $folder = new CostingFolders();
        $folder->uuid = Str::uuid();
        $folder->parent_folder_uuid = $request->parent_folder_uuid;
        $folder->folder_code = $request->folder_code;
        $folder->description = $request->description;
        $folder->project_id = $request->project_id;

        try {
            DB::transaction(function () use ($folder){
                $folder->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $folder->only('uuid');
    }

    public function edit($uuid)
    {
        $folder = CostingFolders::query()->findOrFail($uuid);
        return view('fg.costing-folder.edit')->with([
            'folder' => $folder,
        ]);
    }

    public function update(CostingFolderFormRequest $request, $uuid)
    {
        $folder = CostingFolders::query()->findOrFail($uuid);
        $folder->folder_code = $request->folder_code;
        $folder->description = $request->description;
        $folder->project_id = $request->project_id;

        try {
            DB::transaction(function () use ($folder){
                $folder->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $folder->only('uuid');
    }

    public function show($uuid, Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $costings = Costings::query()
                ->with(['latestLogs.user.employee'])
                ->where('folder_uuid','=',$request->route('costing_folder'));
            return DataTables::of($costings)
                ->addColumn('action',fn($data) => view('fg.costing-folder.show-dt-actions')->with(['data' => $data]))
                ->addColumn('details',fn($data) => view('fg.costing-folder.show-dt-details')->with(['data' => $data]))
                ->editColumn('description',fn($data) => view('fg.costing-folder.show-dt-description')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        $folder = CostingFolders::query()->findOrFail($uuid);
        return view('fg.costing-folder.show')->with([
            'folder' => $folder,
        ]);
    }

    public function children(Request $request,$uuid)
    {

        if($request->ajax() && $request->has('draw')){

            $folder = CostingFolders::query()
            ->withCount(['costings'])
            ->where('parent_folder_uuid','=',$uuid)
            ->childrenOnly();

            return DataTables::of($folder)
                ->addColumn('details',fn($data) => $data->costings_count > 0 ? $data->costings_count.' <small>file(s) inside</small> ': '')
                ->addColumn('action',fn($data) => view('fg.costing-folder.children-dt-actions')->with(['data' => $data]))
                ->editColumn('folder_code',fn($data) => view('fg.costing-folder.dt-folder-code')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        $parentFolder = CostingFolders::query()
            ->with(['children'])
            ->findOrFail($uuid);

        return view('fg.costing-folder.children-index')->with([
            'folder' => $parentFolder,
        ]);
    }

    public function destroy($uuid)
    {
        $disk = Storage::disk('costing-excels');
        $folder = CostingFolders::query()
            ->with(['children'])
            ->findOrFail($uuid);

        try {
            DB::transaction(function () use ($folder) {
                // Delete all child costing records
                $folder->costings()->delete();
                $folder->children()->delete();
                // Delete the folder record
                $folder->delete();
            });

            // Delete the actual directory and all its files
            $disk->deleteDirectory($folder->uuid);
            if($folder->children){
                foreach ($folder->children as $child){
                    $disk->deleteDirectory($child->uuid);
                }
            }


            return 1;

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete costing folder.',
            ], 500);
        }
    }
}
