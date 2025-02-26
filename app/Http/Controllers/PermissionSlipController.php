<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\HRU\PS;
use App\Swep\Services\HRU\PSService;
use App\Swep\Services\PermissionSlipService;
use App\Http\Requests\PermissionSlip\PermissionSlipFormRequest;
use App\Http\Requests\PermissionSlip\PermissionSlipFilterRequest;
use App\Http\Requests\PermissionSlip\PermissionSlipReportRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class PermissionSlipController extends Controller{







    public function __construct(private PSService $PSService){

    }




    public function index(Request $request){

        if($request->ajax() && $request->has('draw')){
            $ps = PS::query();
            return DataTables::of($ps)
                ->addColumn('action',function ($data){
                    return view('_hru.permission-slips.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('purpose',function ($data){
                    return view('_hru.permission-slips.dtPurpose')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date',function ($data){
                    return Carbon::make($data->date)->format('M. d, Y');
                })
                ->editColumn('personal_official',function ($data){
                    return view('_hru.permission-slips.dtPersonalOfficial')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns()
                ->setRowId('slug')
                ->toJson();
        }

        return view('_hru.permission-slips.index');
        return $this->permission_slip->fetch($request);
    
    }

    public function my(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $ps = PS::query()->my();
            return DataTables::of($ps)
                ->addColumn('action',function ($data){
                    return view('_hru.permission-slips.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('purpose',function ($data){
                    return view('_hru.permission-slips.dtPurpose')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date',function ($data){
                    return Carbon::make($data->date)->format('M. d, Y');
                })
                ->editColumn('personal_official',function ($data){
                    return view('_hru.permission-slips.dtPersonalOfficial')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns()
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.permission-slips.my-index');
    }
    


    public function create(){
        return view('_hru.permission-slips.create');
    }

    


    public function store(PermissionSlipFormRequest $request){
        $batchId = Str::random();
        $psArray = [];
        $employeesUsed = Employee::query()->whereIn('slug',collect($request->employees)->values()->toArray())->get();
        $psFrequencies = PS::query()
            ->selectRaw('employee_slug, count(employee_slug) as frequency')
            ->whereIn('employee_slug',collect($request->employees)->values()->toArray())
            ->where('date','like',Carbon::parse($request->date)->format('Y-m-').'%')
            ->where('personal_official','=','PERSONAL')
            ->groupBy('employee_slug')
            ->get();
        $index = 0;
        $psNos = $this->PSService->newPsNo(count($request->employees));
        foreach ($request->employees as $employee){
            $psArray[] = [
                'slug' => Str::random(),
                'ps_no' => $psNos[$index],
                'ps_frequency' => ($psFrequencies->where('employee_slug',$employee)->first()->frequency ?? 0) + 1,
                'employee_slug' => $employee,
                'employee_name' => $employeesUsed->where('slug',$employee)->first()->full['FMiLE'],
                "date" => $request->date,
                "personal_official" => $request->personal_official,
                "direct_nondirect" => $request->direct_nondirect,
                "purpose" => $request->purpose,
                "destination" => $request->destination,
                "mode_of_transportation" => $request->mode_of_transportation,
                "supervisor_name" => $request->supervisor_name,
                "supervisor_position" => $request->supervisor_position,
                "supervisor_date" => $request->supervisor_date,
                "user_created" => Auth::user()->user_id,
                "created_at" => Carbon::now(),
                'batch_id' => $batchId,
            ];
            $index++;
        }

        if(PS::query()->insert($psArray)){
            return [
                'batch_id' => $batchId,
            ];
        }
        abort(503, 'Error creating PS');
    }

    public function isAuthorized($ps)
    {
        if($ps->user_created == Auth::user()->user_id || $ps->employee_slug == Auth::user()->employee->slug){
            return true;
        }
        abort(403,'You do not have enough privilege to perform this action.');
    }

    public function print($slug)
    {
        $ps = PS::query()->findOrFail($slug);
        return view('printables.hru.permission-slips.ps')->with([
            'pss' => [
                $ps
            ],
        ]);
    }
    public function batchPrint($batchId)
    {
        $pss = PS::query()->where('batch_id','=',$batchId)->get();
        return view('printables.hru.permission-slips.ps')->with([
            'pss' => $pss,
        ]);
    }


    public function show($slug){
       return $this->permission_slip->show($slug);
    }




    public function edit($slug){
        $ps = PS::query()->findOrFail($slug);
        $this->isAuthorized($ps);
        return view('_hru.permission-slips.edit')->with([
            'ps' => $ps,
        ]);
    }




    public function update(PermissionSlipFormRequest $request, $slug){
        $ps = PS::query()->findOrFail($slug);
        $this->isAuthorized($ps);
        $ps->date = $request->date;
        $ps->personal_official = $request->personal_official;
        $ps->direct_nondirect = $request->direct_nondirect;
        $ps->purpose = $request->purpose;
        $ps->destination = $request->destination;
        $ps->mode_of_transportation = $request->mode_of_transportation;
        $ps->supervisor_name = $request->supervisor_name;
        $ps->supervisor_position = $request->supervisor_position;
        $ps->supervisor_date = $request->supervisor_date;
        if($ps->update()){
            return $ps->only('slug');
        }
        abort(503,'Error updating PS');
    }

    


    public function destroy($slug){
        $ps = PS::query()->findOrFail($slug);
        $this->isAuthorized($ps);
        if($ps->delete()){
            return 1;
        }
        abort(503,'Error deleting PS');
    }

    


    public function report(){
       return view('dashboard.permission_slip.report');
    }

    


    public function reportGenerate(PermissionSlipReportRequest $request){

       return $this->permission_slip->reportGenerate($request);

    }


    public function myPermissionSlips(){
        return view('dashboard.permission_slip.my_permission_slips');
    }

    
}
