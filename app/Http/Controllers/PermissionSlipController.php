<?php

namespace App\Http\Controllers;

use App\Http\Requests\Hru\PSUpdateTimeFormRequest;
use App\Models\Employee;
use App\Models\HRU\PS;
use App\Models\PermissionSlip;
use App\Swep\Helpers\Helper;
use App\Swep\Services\HRU\PSService;
use App\Swep\Services\PermissionSlipService;
use App\Http\Requests\PermissionSlip\PermissionSlipFormRequest;
use App\Http\Requests\PermissionSlip\PermissionSlipFilterRequest;
use App\Http\Requests\PermissionSlip\PermissionSlipReportRequest;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
                ->addColumn('ps_details',function ($data){
                    return view('_hru.permission-slips.dtPsDetails')->with([
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

    public function scan(Request $request)
    {
        if($request->ajax() && $request->has('scan') && $request->scan == true){
            return  $this->scannedData($request);
        }
        return view('_hru.permission-slips.scan');
    }

    public function scannedData(Request $request)
    {
        $psNo = $request->ps_no;
        $ps = PS::query()
            ->where('ps_no','=',$psNo)
            ->first();
        return view('_hru.permission-slips.update-in-out')->with([
            'ps' => $ps,
        ]);
    }

    public function updateTimeOutViaScan(Request $request)
    {
        $ps = PS::query()->findOrFail($request->slug);
        if($request->type == 'departure'){
            $ps->departure = Carbon::now();
            $ps->user_updated_departure = Auth::user()->user_id;
        }
        if($request->type == 'return'){
            $ps->return = Carbon::now();
            $ps->user_updated_return = Auth::user()->user_id;
        }
        if($ps->save()){
            return $ps->only('slug');
        }
        abort(503,'Error updating PS.');
    }
    public function my(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $ps = PS::query()->my();
            return DataTables::of($ps)
                ->addColumn('action',function ($data){
                    return view('_hru.permission-slips.my-dtActions')->with([
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
        if($request->personal_official == 'PERSONAL'){
            $psFrequencies = PS::query()
                ->selectRaw('employee_slug, count(employee_slug) as frequency')
                ->whereIn('employee_slug',collect($request->employees)->values()->toArray())
                ->where('date','like',Carbon::parse($request->date)->format('Y-m-').'%')
                ->where('personal_official','=','PERSONAL')
                ->groupBy('employee_slug')
                ->get();
        }
        $index = 0;
        $psNos = $this->PSService->newPsNo(count($request->employees));
        foreach ($request->employees as $employee){
            $toPush = [
                'slug' => Str::random(),
                'ps_no' => $psNos[$index],
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
            if($request->personal_official == 'PERSONAL'){
                $toPush['ps_frequency'] = ($psFrequencies->where('employee_slug',$employee)->first()->frequency ?? 0) + 1;
            }else{
                $toPush['ps_frequency'] = null;
            }
            $psArray[] = $toPush;
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
        $routeAccess = Helper::checkRouteAccess(Route::currentRouteName());
        $hasRouteAccess = true;
        if(empty($routeAccess)){
            $hasRouteAccess = false;
        }

        if($ps->status == 'LOCKED'){
            if (!$hasRouteAccess){
                abort(503,'This data is already locked from modification.');
            }
        }

        if($ps->user_created == Auth::user()->user_id || $ps->employee_slug == Auth::user()->employee->slug || $hasRouteAccess){
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

    public function editTime($slug)
    {
        $ps = PS::query()->findOrFail($slug);
        return view('_hru.permission-slips.edit-time')->with([
            'ps' => $ps,
        ]);
    }

    public function updateTime(PSUpdateTimeFormRequest $request,$slug)
    {
        $ps = PS::query()->findOrFail($slug);
        $departure = $ps->date.' '.$request->departure;
        $return = $ps->date.' '.$request->return;
        $timeSpent = 0;
        $timeExcluded = 0;


        if(!empty($request->departure) && !empty($request->return)){
            $timeSpent = $this->timeDiffExceptLunch($departure,$return);
        }

        $ps->departure = $departure;
        $ps->return = $return;
        $ps->time_spent = $timeSpent;
        $ps->user_updated_departure = $ps->departure != null ? Auth::user()->user_id : null;
        $ps->user_updated_return = $ps->return != null ? Auth::user()->user_id : null;
        $ps->status = $ps->departure != null || $ps->return != null ? 'LOCKED' : null;
        if($ps->update()){
            return $ps->only('slug');
        }
        abort(503,'Error updating PS.');
    }


    public function report(Request $request){
        if($request->has('generate')){
            return $this->reportGenerate($request);
        }
       return view('_hru.permission-slips.report');
    }

    


    public function reportGenerate(Request $request){

        $permissionSlips = PS::query()
            ->with('employee')
            ->where('date','like',$request->month.'%')
            ->orderBy('employee_name');
        if($request->has('personal_official') && $request->personal_official != ''){
            $permissionSlips = $permissionSlips->where('personal_official','=',$request->personal_official);
        }
        if($request->has('direct_nondirect') && $request->direct_nondirect != ''){
            $permissionSlips = $permissionSlips->where('direct_nondirect','=',$request->direct_nondirect);
        }

        $permissionSlips = $permissionSlips->get();

        $grouped = $permissionSlips->groupBy(function ($data){
            return $data?->employee?->full['LFEMi'] ?? $data->employee_name;
        })->sortKeys();


        return view('printables.hru.permission-slips.report')->with([
            'permissionSlips' => $permissionSlips,
            'grouped' => $grouped
        ]);
    }

    public function timeDiffExceptLunch( string $start, string $end)
    {
        $start = Carbon::parse($start);
        $end = Carbon::parse($end);

        $diff = $start->diffInMinutes($end);

// Define break span
        $breakStart = Carbon::parse(Carbon::parse($start)->format('Y-m-d').' 12:00:00');
        $breakEnd   = Carbon::parse(Carbon::parse($start)->format('Y-m-d').' 13:00:00');

// Check if break overlaps with working time
        if ($breakStart->between($start, $end) || $breakEnd->between($start, $end)) {
            $overlapStart = $breakStart->max($start);
            $overlapEnd   = $breakEnd->min($end);
            $breakMinutes = $overlapStart->diffInMinutes($overlapEnd);

            $diff -= $breakMinutes;
        }

        return $diff;
    }


    public function myPermissionSlips(){
        return view('dashboard.permission_slip.my_permission_slips');
    }

    
}
