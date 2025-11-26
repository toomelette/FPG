<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\Hru\BatchActionsFormRequest;
use App\Models\EmployeeServiceRecord;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;

class BatchActionsController
{
    public function index()
    {
        return view('_hru.employee.batch.index');
    }

    public function update(BatchActionsFormRequest $request,$slug)
    {
        $sr = EmployeeServiceRecord::query()->findOrFail($slug);
        $sr->item_no = $request->item_no;
        $sr->position = $request->position;
        $sr->salary_type = $request->salary_type;
        $sr->grade = $request->grade;
        $sr->due_to = $request->due_to;
        $sr->step = $request->step;
        $sr->monthly_basic = $request->monthly_basic;
        if($sr->update()){
            return $sr->only('slug');
        }
        abort(503,'Error saving service record.');
    }
}