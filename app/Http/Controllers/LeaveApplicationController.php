<?php

namespace App\Http\Controllers;

use App\Models\HRU\LeaveApplicationDates;
use App\Models\LeaveApplication;
use App\Swep\Helpers\Helper;
use App\Swep\Helpers\Values;
use App\Swep\Services\LeaveApplicationService;
use App\Http\Requests\LeaveApplication\LeaveApplicationFormRequest;
use App\Http\Requests\LeaveApplication\LeaveApplicationFilterRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;


class LeaveApplicationController extends Controller{

    

    protected $leave_application;



    public function __construct(LeaveApplicationService $leave_application){

        $this->leave_application = $leave_application;

    }



    public function index(LeaveApplicationFilterRequest $request){

        if($request->ajax() && $request->has('draw')){
            $las = LeaveApplication::query()
                ->with([
                    'dates','employee'
                ]);
            return DataTables::of($las)
                ->editColumn('date_of_filing',function($data){
                    return Carbon::parse($data->date_of_filing)->format('M. d, Y');
                })
                ->addColumn('inclusive_dates',function($data){
                    return view('_hru.leave-applications.dtInclusiveDates')
                        ->with([
                            'data' => $data,
                        ]);
                })
                ->editColumn('leave_type',function($data){
                    return view('_hru.leave-applications.dtLeaveType')
                        ->with([
                            'data' => $data,
                        ]);
                })
                ->addColumn('status',function($data){

                })
                ->addColumn('action',function($data){
                    return view('_hru.leave-applications.dtActions')
                        ->with([
                            'data' => $data,
                        ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.leave-applications.index');
    
    }

    


    public function userIndex(LeaveApplicationFilterRequest $request){
        if($request->ajax() && $request->has('draw')){
            $las = LeaveApplication::query()
                ->with(['dates'])
                ->myData();
            return DataTables::of($las)
                ->editColumn('date_of_filing',function($data){
                    return Carbon::parse($data->date_of_filing)->format('M. d, Y');
                })
                ->addColumn('inclusive_dates',function($data){
                    return view('_hru.leave-applications.my-dtInclusiveDates')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('leave_type',function($data){
                    return view('_hru.leave-applications.my-dtLeaveType')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('employee',function($data){

                })
                ->addColumn('status',function($data){

                })
                ->addColumn('action',function($data){
                    return view('_hru.leave-applications.my-dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.leave-applications.my-index');
    
    }




    public function create(){
        return view('_hru.leave-applications.my-create')->with([
            'employee' => Auth::user()->employee,
        ]);
    }

    



    public function store(LeaveApplicationFormRequest $request){


        $la = new LeaveApplication;
        $la->slug = Str::random();
        $la->department = $request->department;
        $la->employee_slug = $request->employee_slug;
        $la->lastname = $request->lastname;
        $la->firstname = $request->firstname;
        $la->middlename = $request->middlename;
        $la->position = $request->position;
        $la->salary = Helper::sanitizeAutonum($request->salary);
        $la->date_of_filing = $request->date_of_filing;
        $la->leave_type = $request->leave_type;
        $la->leave_type_specify = null;
        if($la->leave_type == 'Others'){
            $la->leave_type_specify = $request->leave_type_specify;
        }
        $la->leave_details = $request->leave_details;
        $la->leave_specify = $request->leave_specify;
        $la->no_of_days = $request->no_of_days;
        $la->commutation = $request->commutation;
        $la->certified_by = Values::leaveApplicationCertification()['name'];
        $la->certified_by_position =  Values::leaveApplicationCertification()['position'];
        $la->recommended_by = $request->recommended_by;
        $la->recommended_by_position = $request->recommended_by_position;
        $la->approved_by = $request->approved_by;
        $la->approved_by_position = $request->approved_by_position;


        $insert = [];
        $inclusiveDatesArray = explode(',',$request->inclusive_dates);
        $monthCheck = [];
        foreach ($inclusiveDatesArray as $key => $date){
            $monthCheck[Carbon::parse($date)->format('Y-m')] = null;
            array_push($insert,[
                'slug' => Str::random(),
                'leave_application_slug' => $la->slug,
                'date' =>  Carbon::parse($date)->format('Y-m-d'),
            ]);
        }
        $inclusiveDatesArray = collect($inclusiveDatesArray)
            ->map(function ($d){
                return Carbon::parse($d)->format('Y-m-d');
            });
        //Check if employee has already filed a leave on dates selected
        $applications = LeaveApplication::query()
            ->where('employee_slug','=',$request->employee_slug)
            ->whereHas('dates',function ($q) use ($inclusiveDatesArray){
                return $q->where(function ($qu) use ($inclusiveDatesArray){
                    foreach ($inclusiveDatesArray as $date){
                        $qu->orWhere('date','=',$date);
                    }
                });

            })
            ->count();

        if($applications > 0){
            abort(503,'Leave application already exists on some of your dates selected.');
        }
        if(count($monthCheck) > 1){
            abort(503,'You can only file a leave for a specific month. Create another leave application for the other month');
        }
        if($la->save()){
            LeaveApplicationDates::insert($insert);
            return [
                'slug' => $la->slug,
                'printRoute' => route('dashboard.leave_application.print',$la->slug),
                'myLeaveApplicationsRoute' => route('dashboard.leave_application.user_index'),
            ];
        }
        abort(503,'Error creating leave application.');


        
    }

    



    public function show($slug){

        return $this->leave_application->show($slug);
        
    }




    
    public function edit($slug){

        $la = LeaveApplication::query()
            ->with(['dates'])
            ->where('slug','=',$slug)
            ->first();
        $la ?? abort(503,'Leave application not found.');
        return view('_hru.leave-applications.edit')->with([
            'la' => $la,
        ]);
    }

    


    
    public function update(LeaveApplicationFormRequest $request, $slug){
        $la = LeaveApplication::query()
            ->where('slug','=',$slug)
            ->first();
            $la ?? abort(503,'Leave application not found.');

        $la->department = $request->department;
        $la->employee_slug = $request->employee_slug;
        $la->lastname = $request->lastname;
        $la->firstname = $request->firstname;
        $la->middlename = $request->middlename;
        $la->position = $request->position;
        $la->salary = Helper::sanitizeAutonum($request->salary);
        $la->date_of_filing = $request->date_of_filing;
        $la->leave_type = $request->leave_type;
        $la->leave_type_specify = $request->leave_type_specify;
        $la->leave_details = $request->leave_details;
        $la->leave_specify = $request->leave_specify;
        $la->no_of_days = $request->no_of_days;
        $la->commutation = $request->commutation;
        $la->certified_by = Values::leaveApplicationCertification()['name'];
        $la->certified_by_position =  Values::leaveApplicationCertification()['position'];
        $la->recommended_by = $request->recommended_by;
        $la->recommended_by_position = $request->recommended_by_position;
        $la->approved_by = $request->approved_by;
        $la->approved_by_position = $request->approved_by_position;


        $insert = [];
        $inclusiveDatesArray = explode(',',$request->inclusive_dates);
        $monthCheck = [];
        foreach ($inclusiveDatesArray as $key => $date){
            $monthCheck[Carbon::parse($date)->format('Y-m')] = null;
            array_push($insert,[
                'slug' => Str::random(),
                'leave_application_slug' => $la->slug,
                'date' =>  Carbon::parse($date)->format('Y-m-d'),
            ]);
        }
        if(count($monthCheck) > 1){
            abort(503,'You can only file a leave for a specific month. Create another leave application for the other month');
        }
        if($la->save()){
            $la->dates()->delete();
            LeaveApplicationDates::insert($insert);
            return $la->only('slug');
        }
        abort(503,'Error saving data.');
        
    }

    



    public function destroy($slug){
        $la = LeaveApplication::query()->where('slug','=',$slug)->first();
        $la ?? abort(503,'Leave application not found.');

        if($la->delete()){
            $la->dates()->delete();
            return 1;
        }
        abort(503,'Error deleting leave application');
    }





    public function print($slug){
        $la = LeaveApplication::query()
            ->where('slug','=',$slug)
            ->first();
        $la ?? abort(503,'Leave application not found.');
        return  view('printables.hru.leave_application.print')->with([
            'la' => $la,
        ]);
        return $this->leave_application->print($slug, $type);

    }





    public function saveAs($slug){
        
        return $this->leave_application->saveAs($slug);

    }




}
