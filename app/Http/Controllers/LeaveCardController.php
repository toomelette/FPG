<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveCard\LeaveCardBegBalFormRequest;
use App\Models\Employee;
use App\Models\HRU\LeaveApplicationDates;
use App\Models\HRU\LeaveBeginningBalance;
use App\Models\LeaveApplication;
use App\Models\LeaveCard;
use App\Swep\Classes\LeaveTypes;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Helper;
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
                ->permanent()
                ->active();
            return \DataTables::of($employees)
                ->editColumn('lastname',function ($data){
                    return $data->full['LFEMi'];
                })
                ->addColumn('action',function ($data){
                    return view('_hru.leave-cards.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('vlRemaining',function ($data){
                    return Helper::toNumber($data->leave_balances['VL']['balance'] ?? '',3);
                })
                ->addColumn('slRemaining',function ($data){
                    return Helper::toNumber($data->leave_balances['SL']['balance'] ?? '',3);
                    return $data->leaveBegBal->sl ?? '';
                })
                ->addColumn('details',function ($data){

                })
                ->setRowId('slug')
                ->escapeColumns([])
                ->toJson();
        }
        return view('_hru.leave-cards.index');
    }




    public function create(){

        return view('dashboard.leave_card.create');
    
    }
    




    



    public function show($slug,LeaveTypes $leaveTypes){
//        $leaveApplications = LeaveApplicationDates::query()
//            ->selectRaw('charge_to, sum(deduct) as deduct')
//            ->whereHas('leaveApplication',function ($q) use ($slug){
//                $q->where('employee_slug','=',$slug);
//            })
//            ->leftJoin(
//                LeaveApplication::getModel()->getTable(),
//                LeaveApplication::getModel()->getTable().'.slug',
//                '=',
//                LeaveApplicationDates::getModel()->getTable().'.leave_application_slug')
//            ->groupBy('charge_to')
//            ->get();
//
//        $leaveCredits = LeaveCard::query()
//            ->selectRaw('leave_card, sum(credits) as credits')
//            ->where('employee_slug','=',$slug)
//            ->groupBy('leave_card')
//            ->get();
        $employee = Employee::query()->findOrFail($slug);
        $leaveBalances = $employee->leave_balances;

        return  view('_hru.leave-cards.show')->with([
            'employee' => $employee,
            'leaveTypeCodes' => Arrays::leaveTypeCodes(),
            'leaveBalances' => $leaveBalances,
        ]);
    }



    public function viewPerLeaveType($employeeSlug,$leaveType, Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            if($request->has('leaveCredits')){
                return $this->leaveCreditsTable($employeeSlug,$leaveType,$request);
            }
            if($request->has('leaveApplications')){
                return  $this->leaveApplicationsTable($employeeSlug,$leaveType,$request);
            }
        }

        $employee = Employee::query()->findOrFail($employeeSlug);


        $applications = LeaveApplication::query()
            ->selectRaw("date_of_filing as date,null as 'add',actual_deduction as 'less',null as usable_until")
            ->where('employee_slug','=',$employeeSlug)
            ->where('charge_to','=',$leaveType)
            ->received();
        $credits = LeaveCard::query()
                ->selectRaw("date,credits as 'add',deduction as 'less',usable_until")
            ->where('employee_slug','=',$employeeSlug)
            ->where('leave_card','=',$leaveType);
        $balances  = $applications->union($credits)->orderBy('date','asc')->get();

        return  view('_hru.leave-cards.view-per-leave-type')->with([
            'employee' => $employee,
            'leaveType' => $leaveType,
            'balances' => $balances,
        ]);
    }

    public function leaveCreditsTable($employeeSlug,$leaveType,Request $request)
    {
        $leaveCredits = LeaveCard::query()
            ->where('employee_slug','=',$employeeSlug)
            ->where('leave_card','=',strtoupper($leaveType))
            ->creditsOnly();
        return \DataTables::of($leaveCredits)
            ->addColumn('action',function($data){
                return view('_hru.leave-cards.leave-credits-dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }
    public function leaveApplicationsTable($employeeSlug,$leaveType,Request $request)
    {
        $leaveApplications = LeaveApplicationDates::query()
            ->with([
                'leaveApplication'
            ])
            ->whereHas('leaveApplication',function (Builder $q) use ($employeeSlug,$leaveType){
                $q->where('employee_slug','=',$employeeSlug)
                ->where('charge_to','=',$leaveType);
            });
        $leaveApplications = LeaveApplication::query()
            ->selectRaw('slug,date_of_filing as date,actual_deduction as deduction, "leave_application" as src')
            ->where('employee_slug','=',$employeeSlug)
            ->where('charge_to','=',$leaveType)
            ->received();

        $leaveDeductions = LeaveCard::query()
            ->selectRaw('slug,date,deduction,"leave_deduction" as src')
            ->where('employee_slug','=',$employeeSlug)
            ->where('leave_card','=',$leaveType)
            ->deductionsOnly();

        $union = $leaveApplications->union($leaveDeductions);
        return \DataTables::of($union)
            ->addColumn('actions',function ($data){
                return view('_hru.leave-cards.leave-applications-dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('date',function($data){
                return $data->date;
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

    public function store($employeeSlug,$leaveType,LeaveCardFormRequest $request){
        $leaveCredit = new LeaveCard;
        $leaveCredit->slug = \Str::random();
        $leaveCredit->employee_slug = $employeeSlug;
        $leaveCredit->date = $request->date.'-01';
        $leaveCredit->leave_card = strtoupper($leaveType);
        $leaveCredit->credits =  $request->credits;
        $leaveCredit->deduction =  $request->deduction;
        $leaveCredit->usable_until = strtoupper($leaveType) == 'VL' || strtoupper($leaveType) == 'SL' ? null : $request->usable_until;
        $leaveCredit->remarks = $request->remarks;
        $leaveCredit->type = $request->type;
        if($leaveCredit->save()){
            return $leaveCredit->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function edit($slug)
    {
        $leaveCard = LeaveCard::query()->findOrFail($slug);
        return view('_hru.leave-cards.edit')->with([
            'leaveCard' => $leaveCard,
        ]);
    }

    public function update($slug,LeaveCardFormRequest $request)
    {
        $leaveCard = LeaveCard::query()->findOrFail($slug);
        $leaveCard->date = $request->date.'-01';
        $leaveCard->credits = $request->credits;
        $leaveCard->deduction = $request->deduction;
        $leaveCard->remarks = $request->remarks;
        if($leaveCard->update()){
            return $leaveCard->only('slug');
        }
        abort(503,'Error saving data.');
    }


    //EDITS THE BEGINNING BALANCES
    public function editBeginningBalance($employeeSlug){

        $employee = Employee::query()->find($employeeSlug);
        $employee ?? abort(404,'Employee not found.');
        $leaveBegBal = LeaveBeginningBalance::query()
            ->where('employee_slug','=',$employeeSlug)
            ->first();
        return view('_hru.leave-cards.edit-beginning-balance')->with([
            'employee' => $employee,
            'begBal' => $leaveBegBal,
        ]);
    }

    


    //UPDATES THE BEGINNING BALANCES
    public function updateBeginningBalance(LeaveCardBegBalFormRequest $request, $employeeSlug){
        $employee = Employee::query()->find($employeeSlug);
        $leaveBegBal = LeaveBeginningBalance::query()->where('employee_slug','=',$employee)->first();
        $employee ?? abort(404,'Employee not found.');
        $begBalInsert = LeaveBeginningBalance::query()->updateOrCreate(
            ['employee_slug' => $employeeSlug],
            [
                'slug' => \Str::random(),
                'as_of' => $request->as_of,
                'sl' => $request->sl,
                'vl' => $request->vl,
            ]
        );
        if($begBalInsert){
            return $employee->only('slug');
        }
        abort(503,'Error updating beginning balance.');
    }

    



    public function destroy($slug){

        $leaveCard = LeaveCard::query()->findOrFail($slug);
        if($leaveCard->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }

    



    public function report(){

        return view('dashboard.leave_card.report');

    }

    



    public function reportGenerate(LeaveCardReportRequest $request){
        
        return $this->leave_card->reportGenerate($request);

    }


	
	


}
