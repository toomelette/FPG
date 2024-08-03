<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveCard\LeaveCardBegBalFormRequest;
use App\Models\Employee;
use App\Models\HRU\LeaveApplicationDates;
use App\Models\HRU\LeaveBeginningBalance;
use App\Models\LeaveCard;
use App\Swep\Services\LeaveCardService;
use App\Http\Requests\LeaveCard\LeaveCardFormRequest;
use App\Http\Requests\LeaveCard\LeaveCardFilterRequest;
use App\Http\Requests\LeaveCard\LeaveCardReportRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LeaveCardController extends Controller{
    



	protected $leave_card;



    public function __construct(LeaveCardService $leave_card){

        $this->leave_card = $leave_card;

    }



    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $employees = Employee::query()
                ->with(['leaveBegBal'])
                ->permanent();
            return \DataTables::of($employees)
                ->editColumn('lastname',function ($data){
                    return $data->full_name;
                })
                ->addColumn('action',function ($data){
                    return view('dashboard.leave_card.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('vlRemaining',function ($data){
                    return $data->leaveBegBal->vl ?? '';
                })
                ->addColumn('slRemaining',function ($data){
                    return $data->leaveBegBal->sl ?? '';
                })
                ->addColumn('details',function ($data){

                })
                ->setRowId('slug')
                ->escapeColumns([])
                ->toJson();
        }
        return view('dashboard.leave_card.index');
        return $this->leave_card->fetch($request);
    }




    public function create(){

        return view('dashboard.leave_card.create');
    
    }
    



    public function store(LeaveCardFormRequest $request){

        return $this->leave_card->store($request);
        
    }
    



    public function show($slug){
        $employee = Employee::query()->findOrFail($slug);
        return  view('dashboard.leave_card.show')->with([
            'employee' => $employee,
        ]);
    }



    public function viewPerLeaveType($employeeSlug,$leaveType, Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            if($request->for == 'leaveCredits'){
                return $this->leaveCreditsTable($employeeSlug,$leaveType,$request);
            }
            if($request->for == 'leaveApplications'){
                return  $this->leaveApplicationsTable($employeeSlug,$leaveType,$request);
            }
        }
        $employee = Employee::query()->findOrFail($employeeSlug);
        return  view('dashboard.leave_card.view_per_leave_type')->with([
            'employee' => $employee,
            'leaveType' => $leaveType,
        ]);
    }

    public function leaveCreditsTable($employeeSlug,$leaveType,Request $request)
    {
        $leaveCredits = LeaveCard::query()
            ->where('employee_slug','=',$employeeSlug)
            ->where('leave_card','=',strtoupper($leaveType));
        return \DataTables::of($leaveCredits)
            ->addColumn('action',function($data){

            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }
    public function leaveApplicationsTable($employeeSlug,$leaveType,Request $request)
    {
        $leaveApplications = LeaveApplicationDates::query()
            ->whereHas('leaveApplication',function (Builder $q) use ($employeeSlug){
                $q->where('employee_slug','=',$employeeSlug);
            });
        return \DataTables::of($leaveApplications)
            ->addColumn('action',function($data){

            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }
    public function storeLeaveCredit($employeeSlug,$leaveType,Request $request)
    {
        $leaveCredit = new LeaveCard;
        $leaveCredit->slug = \Str::random();
        $leaveCredit->employee_slug = $employeeSlug;
        $leaveCredit->month = $request->month;
        $leaveCredit->leave_card = strtoupper($leaveType);
        $leaveCredit->credits = $request->credits;
        $leaveCredit->remarks = $request->remarks;
        if($leaveCredit->save()){
            return $leaveCredit->only('slug');
        }
        abort(503,'Error saving data.');
    }




    //EDITS THE BEGINNING BALANCES
    public function edit($employeeSlug){
        $employee = Employee::query()->find($employeeSlug);
        $employee ?? abort(404,'Employee not found.');
        $leaveBegBal = LeaveBeginningBalance::query()
            ->where('employee_slug','=',$employeeSlug)
            ->first();
        return view('dashboard.leave_card.edit')->with([
            'employee' => $employee,
            'begBal' => $leaveBegBal,
        ]);
    }

    


    //UPDATES THE BEGINNING BALANCES
    public function update(LeaveCardBegBalFormRequest $request, $employeeSlug){
        $employee = Employee::query()->find($employeeSlug);
        $leaveBegBal = LeaveBeginningBalance::query()->where('employee_slug','=',$employee)->first();
        $employee ?? abort(404,'Employee not found.');
        $uoc = LeaveBeginningBalance::query()->updateOrCreate(
            ['employee_slug' => $employeeSlug],
            [
                'slug' => \Str::random(),
                'as_of' => $request->as_of,
                'sl' => $request->sl,
                'vl' => $request->vl,
            ]
        );
        if($uoc){
            return $employee->only('slug');
        }
        abort(503,'Error updating beginning balance.');
    }

    



    public function destroy($slug){
        
        return $this->leave_card->destroy($slug);

    }

    



    public function report(){

        return view('dashboard.leave_card.report');

    }

    



    public function reportGenerate(LeaveCardReportRequest $request){
        
        return $this->leave_card->reportGenerate($request);

    }


	
	


}
