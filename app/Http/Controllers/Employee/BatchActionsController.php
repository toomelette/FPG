<?php

namespace App\Http\Controllers\Employee;

use App\Http\Requests\Hru\BatchActionsFormRequest;
use App\Models\Employee;
use App\Models\EmployeeServiceRecord;
use App\Models\HRPayPlanitilla;
use App\Models\Plantilla;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BatchActionsController
{
    public function index(Request $request)
    {
        if($request->has('bulkPrinting')){
            return $this->bulkPrinting($request);
        }
        return view('_hru.employee.batch.index');
    }

    public function update(Request $request,$slug)
    {

        if($request->has('updateLatestSr')){
            return $this->updateLatestSr($request,$slug);
        }
        if($request->has('newSr')){
            return $this->newSr($request,$slug);
        }
        dd($request->all());

    }

    public function bulkPrinting(Request $request)
    {
        $serviceRecords = EmployeeServiceRecord::query()
            ->with([
                'employee.employeeServiceRecord' => function ($employeeServiceRecord) {
                    $employeeServiceRecord->orderBy('sequence_no','desc');
                }
            ])
            ->where('batch_code','=',$request->batch_code)
            ->get();

        $srs = [];
        foreach ($serviceRecords as $serviceRecord){
            $latest = $serviceRecord->employee->employeeServiceRecord->first();
            $secondLatest = $serviceRecord->employee->employeeServiceRecord->skip(1)->first();
            $newRequest = new Collection();
            $newRequest->body = $request->body;
            $newRequest->header_date = $request->header_date;
            $newRequest->effectivity = $latest->from_date;
            $newRequest->new_salary_grade = $latest->grade;
            $newRequest->new_salary_type = $latest->salary_type;
            $newRequest->new_step_inc = $latest->step;
            $newRequest->new_monthly_salary = $latest->monthly_basic;
            $newRequest->salary_type = $secondLatest->salary_type;
            $newRequest->salary_grade = $secondLatest->grade;
            $newRequest->step_inc = $secondLatest->step;
            $newRequest->monthly_basic = $secondLatest->monthly_basic;
            $newRequest->signatory_name = $request->signatory_name;
            $newRequest->signatory_position = $request->signatory_position;
            $newRequest->new_position = $latest->position;

            $srs[] = [
                'request' => $newRequest,
                'employee' => $serviceRecord->employee,
            ];
        }

        return view('printables.employee.nosa-multiple')->with([
            'srs' => $srs,
        ]);
    }

    public function newSr(Request $request,$slug)
    {
        $request->merge([
            'monthly_basic' => Helper::sanitizeAutonum($request->monthly_basic),
        ]);
        $request->validate([
            'batch_code' => Rule::unique('hr_employee_service_records')->where(function ($q) use($request,$slug){
                $q->where('batch_code',$request->batch_code)
                    ->where('employee_slug',$slug)
                    ->whereNull('deleted_at');
            }),
            'from_date' => 'required',
            'item_no' => 'required|string',
            'salary_scale' => 'required',
            'salary_type' => 'required_with:grade,step',
            'grade' => [
                'int',
                'required_with:step,salary_type',
            ],
            'step' => [
                'int',
                'required_with:grade,salary_type'
            ],
            'monthly_basic' => 'required|numeric',
            'due_to'=>'required|string',
        ]);

        $employee = Employee::query()
            ->with(['employeeServiceRecordLatest'])
            ->findOrFail($slug);
        $plantilla = HRPayPlanitilla::query()
            ->where('item_no','=',$request->item_no)
            ->firstOrFail();

        $sr = new EmployeeServiceRecord();
        $sr->slug = Str::random();
        $sr->employee_slug = $slug;
        $sr->sequence_no = $employee?->employeeServiceRecordLatest?->sequence_no + 10;
        $sr->from_date = $request->from_date;
        $sr->to_date = $request->to_date;
        $sr->upto_date = $request->to_date == null ? 1 : null;
        $sr->item_no = $request->item_no;
        $sr->position = $plantilla?->position;
        $sr->appointment_status = $request->appointment_status;
        $sr->monthly_basic = $request->monthly_basic;
        $sr->salary = $request->monthly_basic * 12;
        $sr->due_to = $request->due_to;
        $sr->salary_type = $request->salary_type;
        $sr->grade = $request->grade;
        $sr->step = $request->step;
        $sr->salary_scale = $request->salary_scale;
        $sr->batch_code = $request->batch_code;

        if($sr->save()){
            $dayBeforeFromDate = Carbon::parse($sr->from_date)->subDay()->format('Y-m-d');
            $employee->employeeServiceRecordLatest->to_date = $dayBeforeFromDate;
            $employee->employeeServiceRecordLatest->upto_date = null;
            $employee->employeeServiceRecordLatest->system_remarks = $request->batch_code;
            $employee->employeeServiceRecordLatest->save();
            return $sr->only('slug');
        }
        abort(503,'Error saving service record.');
    }
    public function updateLatestSr(Request $request,$slug)
    {
        $request->merge([
            'monthly_basic' => Helper::sanitizeAutonum($request->monthly_basic),
        ]);
        $request->validate([
            'item_no' => 'required|string',
            'salary_type' => 'required_with:grade,step',
            'grade' => [
                'int',
                'required_with:step,salary_type',
            ],
            'step' => [
                'int',
                'required_with:grade,salary_type'
            ],
            'monthly_basic' => 'required|numeric',
            'due_to'=>'required|string',
            'position'=>'required|string|max:45',
        ]);

        $sr = EmployeeServiceRecord::query()->findOrFail($slug);
        $sr->item_no = $request->item_no;
        $sr->position = $request->position;
        $sr->salary_type = $request->salary_type;
        $sr->grade = $request->grade;
        $sr->due_to = $request->due_to;
        $sr->step = $request->step;
        $sr->monthly_basic = $request->monthly_basic;
        $sr->salary = $request->monthly_basic * 12;

        if($sr->update()){
            return $sr->only('slug');
        }
        abort(503,'Error saving service record.');
    }


}