<?php 
namespace App\Swep\Services;


use App\Swep\Interfaces\LeaveCardInterface;
use App\Swep\Interfaces\EmployeeInterface;
use App\Swep\BaseClasses\BaseService;
use App\Swep\Repositories\EmployeeRepository;


class LeaveCardService extends BaseService{


    protected $leave_card_repo;
    protected $employee_repo;



    public function __construct(LeaveCardInterface $leave_card_repo, EmployeeRepository $employee_repo){

        $this->leave_card_repo = $leave_card_repo;
        $this->employee_repo = $employee_repo;
        parent::__construct();

    }






    public function fetch($request){

        $leave_cards = $this->leave_card_repo->fetch($request);

        $request->flash();
        return view('dashboard.leave_card.index')->with('leave_cards', $leave_cards);

    }






    public function store($request){

        $year = 0;
        $month = 0;
        $days = 0;
        $hrs = 0;
        $mins = 0;
        $credits = 0;

        $date_from = $this->carbon->parse($request->date_from);


        // Leave
        if ($request->doc_type == 'LEAVE') {

            $year = $request->year;
            $month = $request->month;
            $days = $date_from->diffInWeekdays($request->date_to) + 1;
            $credits = number_format($days * 1.000, 3);

        }


        //  OT, TARDY, UT
        if($request->doc_type == 'OT' || $request->doc_type == 'TARDY' || $request->doc_type == 'UT'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');
            $hrs = $request->hrs;
            $mins = $request->mins;
            $credits_hrs = number_format($hrs * .125, 3);
            $credits_mins = number_format($mins * .125/60, 3);

            $credits = $credits_hrs + $credits_mins;

        }


        //  MON
        if($request->doc_type == 'MON'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');
            $days = $request->days;
            $credits = number_format($days * 1.000, 3);
            
        }


        //  COM
        if($request->doc_type == 'COM'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');

            $days = $request->days;
            $hrs = $request->hrs;
            $mins = $request->mins;

            $credits_days = number_format($days * 1.000, 3);
            $credits_hrs = number_format($hrs * .125, 3);
            $credits_mins = number_format($mins * .125/60, 3);

            $credits = $credits_days + $credits_hrs + $credits_mins;
            
        }


        $leave_card = $this->leave_card_repo->store($request, $year, $month, $days, $hrs, $mins, $credits);

//        $this->event->dispatch('leave_card.store', $leave_card);
        return redirect()->back();

    }







    public function edit($slug){

        $leave_card = $this->leave_card_repo->findBySlug($slug);
        return view('dashboard.leave_card.edit')->with('leave_card', $leave_card);

    }







    public function update($request, $slug){

        $year = 0;
        $month = 0;
        $days = 0;
        $hrs = 0;
        $mins = 0;
        $credits = 0;

        $date_from = $this->carbon->parse($request->date_from);


        // Leave
        if ($request->doc_type == 'LEAVE') {

            $year = $request->year;
            $month = $request->month;
            $days = $date_from->diffInWeekdays($request->date_to) + 1;
            $credits = number_format($days * 1.000, 3);

        }


        // OT, TARDY, UT
        if($request->doc_type == 'OT' || $request->doc_type == 'TARDY' || $request->doc_type == 'UT'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');
            $hrs = $request->hrs;
            $mins = $request->mins;
            $credits_hrs = number_format($hrs * .125, 3);
            $credits_mins = number_format($mins * .125/60, 3);

            $credits = $credits_hrs + $credits_mins;

        }


        //  MON
        if($request->doc_type == 'MON'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');
            $days = $request->days;
            $credits = number_format($days * 1.000, 3);
            
        }


        //  COM
        if($request->doc_type == 'COM'){

            $year = $this->__dataType->date_parse($request->date, 'Y');
            $month = $this->__dataType->date_parse($request->date, 'm');

            $days = $request->days;
            $hrs = $request->hrs;
            $mins = $request->mins;

            $credits_days = number_format($days * 1.000, 3);
            $credits_hrs = number_format($hrs * .125, 3);
            $credits_mins = number_format($mins * .125/60, 3);

            $credits = $credits_days + $credits_hrs + $credits_mins;
            
        }
        

        $leave_card = $this->leave_card_repo->update($request, $year, $month, $days, $hrs, $mins, $credits, $slug);

//        $this->event->dispatch('leave_card.update', $leave_card);
        return redirect()->route('dashboard.leave_card.index');

    }






    public function show($slug){

        $leave_card = $this->leave_card_repo->findBySlug($slug);
        return view('dashboard.leave_card.show')->with('leave_card', $leave_card);

    }






    public function destroy($slug){

        $leave_card = $this->leave_card_repo->destroy($slug);

//        $this->event->dispatch('leave_card.destroy', $leave_card );
        return redirect()->back();

    }






    public function reportGenerate($request){

        if($request->r_type == 'loat'){

            $employees = $this->employee_repo->getByIsActive('ACTIVE');
            return view('printables.leave_card.loat')->with('employees', $employees);

        }elseif($request->r_type == 'ledger'){

            $start_date = $this->__dataType->date_parse('2018-8-01', 'm/d/y');
            $end_date = $this->carbon->now()->format('m/d/y');

            $employee = $this->employee_repo->findBySlug($request->s);
            $list_of_months = $this->__dynamic->months_between_dates($start_date, $end_date);

            return view('printables.leave_card.leave_ledger', compact('employee','list_of_months'));

        }elseif($request->r_type == 'comp'){

            $start_date = $this->__dataType->date_parse('2018-8-01', 'm/d/y');
            $end_date = $this->carbon->now()->format('m/d/y');

            $employee = $this->employee_repo->findBySlug($request->s);
            $list_of_months = $this->__dynamic->months_between_dates($start_date, $end_date);

            return view('printables.leave_card.ot_ledger', compact('employee','list_of_months'));

        }else{

            abort(404);

        }
        

    }







}