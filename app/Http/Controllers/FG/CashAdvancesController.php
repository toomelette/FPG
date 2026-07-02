<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\CashAdvancesFormRequest;
use App\Models\FG\CashAdvances;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CashAdvancesController extends Controller
{
    public function __construct()
    {
        $this->folder =  'fg.cash-advances.';
    }
    public function userIndex(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $cas = CashAdvances::query()
                ->user();
            return DataTables::of($cas)
                ->addColumn('action',fn($data) => view($this->folder.'user-dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'user-index');
    }

    public function store(CashAdvancesFormRequest $request)
    {
        $ca = new CashAdvances();
        $ca->uuid = Str::uuid();
        $ca->date = $request->date;
        $ca->type = $request->type;
        $ca->reason = $request->reason;
        $ca->requested_by = $request->requested_by;
        $ca->amount_requested = $request->amount_requested;

        try {
            DB::transaction(function () use ($ca){
                $ca->save();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return $ca->only('uuid');
    }

    public function edit($uuid, Request $request)
    {
        if($request->has('makeAction')){
            return  $this->makeAction($uuid,$request);
        }
        $ca = CashAdvances::query()->findOrFail($uuid);
        if(filled($ca->amount_approved)){
            abort(503,'Cash advance cannot be edited.');
        }
        return view($this->folder.'edit')->with([
            'ca' => $ca,
        ]);
    }

    public function update(CashAdvancesFormRequest $request,$uuid)
    {
        if($request->has('approve')){
            return  $this->approve($uuid,$request);
        }
        $ca = CashAdvances::query()->findOrFail($uuid);
        if(filled($ca->amount_approved)){
            abort(503,'Cash advance cannot be edited.');
        }
        $ca->date = $request->date;
        $ca->reason = $request->reason;
        $ca->requested_by = $request->requested_by;
        $ca->amount_requested = $request->amount_requested;

        try {
            DB::transaction(function () use ($ca){
                $ca->save();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return $ca->only('uuid');
    }
    public function destroy($uuid)
    {
        $ca = CashAdvances::query()->findOrFail($uuid);
        if(filled($ca->amount_approved)){
            if(!Helper::checkRouteAccess('cash-advances.destroy')){
                abort(503,'Cash advance cannot be deleted.');
            }
        }
        try {
            DB::transaction(function () use ($ca){
                $ca->delete();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return 1;
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $cas = CashAdvances::query();
            return DataTables::of($cas)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }

        return view($this->folder.'index');
    }

    public function makeAction($uuid, Request $request)
    {
        $ca = CashAdvances::query()->findOrFail($uuid);
        return view($this->folder.'make-action')->with([
            'ca' => $ca,
        ]);
    }
    
    public function approve($uuid,$request)
    {
        $ca = CashAdvances::query()->findOrFail($uuid);
        $ca->amount_approved = $request->amount_approved;
        $ca->user_approved = Auth::user()->user_id;
        $ca->approved_at = now();
        try {
            DB::transaction(function () use ($ca){
                $ca->saveQuietly();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return $ca->only('uuid');
    }

    public function print($uuid)
    {
        $ca = CashAdvances::query()->findOrFail($uuid);
        return view($this->folder.'print')->with([
            'ca' => $ca,
        ]);
    }

    public function reports(Request $request)
    {
        if($request->has('generate')){
            $report = Str::of($request->report_type)->camel()->toString();

            return $this->$report($request);
        }
        return view($this->folder.'reports');
    }
    private function summary(Request $request)
    {
        $cashAdvances =  CashAdvances::query()
            ->when(filled($request->project_id),function ($query) use ($request){
                $query->where('project_id','=',$request->project_id);
            })
            ->when(filled($request->type),function ($query) use ($request){
                $query->where('type','=',$request->type);
            })
            ->when(
                filled($request->date_from) && filled($request->date_to),
                fn($q) =>
                $q->whereBetween('date', [$request->date_from, $request->date_to])
            )
            ->when(
                filled($request->date_from) && !filled($request->date_to),
                fn($q) =>
                $q->whereDate('date', '>=', $request->date_from)
            )
            ->when(
                !filled($request->date_from) && filled($request->date_to),
                fn($q) =>
                $q->whereDate('date', '<=', $request->date_to)
            )
            ->orderBy('date')
            ->get();
        return view($this->folder.'print-summary')->with([
            'cashAdvances' => $cashAdvances,
        ]);
    }
}
