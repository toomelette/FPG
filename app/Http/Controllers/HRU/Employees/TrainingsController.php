<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeTraining\EmployeeTrainingCreateForm;
use App\Http\Requests\EmployeeTraining\EmployeeTrainingEditForm;
use App\Models\Employee;
use App\Models\EmployeeTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainingsController extends Controller
{
    public function index($employeeSlug, Request $request)
    {

        if($request->has('draw')){
            $trainings = EmployeeTraining::query()
                ->where('employee_slug','=',$employeeSlug);
            return \DataTables::of($trainings)
                ->addColumn('action',function ($data){
                    return view('_hru.employee.trainings.dtActions')->with([
                        'data' => $data,
                    ]);
                })->editColumn('date_to',function ($data){
                    return ($data->date_to != '' ? Carbon::parse($data->date_to)->format('m/d/Y') : '');
                })
                ->editColumn('date_from',function ($data){
                    return ($data->date_from != '' ? Carbon::parse($data->date_from)->format('m/d/Y') : '');
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        if($request->has('edit')){
            return  $this->edit($employeeSlug);
        }
        if($request->has('print')){
            return  $this->print($employeeSlug);
        }
        $employee = Employee::query()
            ->with([
                'employeeTraining',
            ])
            ->findOrFail($employeeSlug);
        return view('_hru.employee.trainings.index')->with([
            'employee' => $employee,
        ]);
    }

    public function store($employeeSlug, EmployeeTrainingCreateForm $request)
    {
        $employee_trng = new EmployeeTraining;
        $employee_trng->employee_slug = $employeeSlug;
        $employee_trng->slug = Str::random(32);
        $employee_trng->sequence_no = $request->sequence_no;
        $employee_trng->title = $request->title;
        $employee_trng->type = $request->type;
        $employee_trng->date_from = Carbon::parse($request->date_from)->format('Y-m-d');
        $employee_trng->date_to = Carbon::parse($request->date_to)->format('Y-m-d');

        $employee_trng->detailed_period = $request->detailed_period;
        $employee_trng->hours = $request->hours;
        $employee_trng->conducted_by = $request->conducted_by;
        $employee_trng->venue = $request->venue;
        $employee_trng->remarks = $request->remarks;
        $employee_trng->is_relevant = $request->is_relevant;

        if($employee_trng->save()){
            return  $employee_trng->only('slug');
        };
        abort(503,'Error saving data.');
    }

    public function destroy($slug)
    {
        $t = EmployeeTraining::query()->findOrFail($slug);
        if($t->delete()){
            return 1;
        }
        abort(503,'Error deleting item.');
    }

    public function edit($slug)
    {
        $training = EmployeeTraining::query()->findOrFail($slug);
        return view('_hru.employee.trainings.edit')->with([
            'training' => $training,
        ]);
    }
    public function update($slug, EmployeeTrainingEditForm $request)
    {
        $employee_trng = EmployeeTraining::query()->findOrFail($slug);
        $employee_trng->sequence_no = $request->sequence_no;
        $employee_trng->title = $request->title;
        $employee_trng->type = $request->type;
        $employee_trng->date_from = Carbon::parse($request->date_from)->format('Y-m-d');
        $employee_trng->date_to = Carbon::parse($request->date_to)->format('Y-m-d');

        $employee_trng->detailed_period = $request->detailed_period;
        $employee_trng->hours = $request->hours;
        $employee_trng->conducted_by = $request->conducted_by;
        $employee_trng->venue = $request->venue;
        $employee_trng->remarks = $request->remarks;
        $employee_trng->is_relevant = $request->is_relevant;

        if($employee_trng->update()){
            return  $employee_trng->only('slug');
        };
        abort(503,'Error saving data.');
    }

    public function print($employeeSlug)
    {

        $emp = Employee::query()
            ->with([
                'employeeTraining'
            ])
            ->findOrFail($employeeSlug);
        $trainingsArray = [];
        $itemsPerPage = $request->items_per_sheet ?? 15;
        $allCount = $emp->employeeTraining()->count() ?? 0;
        $counter = 0;
        $arrayCounter = 0;
        $employeeTraining = $emp->employeeTraining();
        if(!empty($request->df)){
            $employeeTraining = $employeeTraining->where('date_from','>=',$request->df);
        }
        if(!empty($request->dt)){
            $employeeTraining =  $employeeTraining->where('date_to','<=',$request->dt);
        }

        $employeeTraining=$employeeTraining
            ->orderBy('sequence_no','desc')
            ->get();
        foreach ($employeeTraining as $training){
            if($counter < $itemsPerPage){
                $trainingsArray[$arrayCounter][$training->slug] = $training;
            }else{
                $arrayCounter++;
                $trainingsArray[$arrayCounter][$training->slug] = $training;
                $counter = 0;
            }
            $counter++;
        }


        return view('printables.employee.trainings')->with([
            'employee' => $emp,
            'trainingsArray' => $trainingsArray,
        ]);
    }
}