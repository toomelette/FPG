<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\PayrollPreparationFormRequest;
use App\Models\Employee;
use App\Models\FG\PayrollAdjustments;
use App\Models\FG\PayrollEmployeeAdjustments;
use App\Models\FG\PayrollEmployees;
use App\Models\FG\PayrollMaster;
use App\Models\FG\PayrollTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PayrollPreparationController extends Controller
{
    public function __construct(
        private $folder = 'fg.payroll-preparation.',
    )
    {
    }

    public function create(Request $request)
    {
        if($request->ajax() && $request->has('updateTable')){
            return  $this->updateTable($request);
        }
        return view($this->folder.'create');
    }

    private function updateTable(Request $request)
    {
        $employees = Employee::query()
            ->permanent()
            ->active()
            ->get();
        return view($this->folder.'employee-list')->with([
            'employees' => $employees
        ]);
    }

    public function store(Request $request)
    {
        $payrollMaster = new PayrollMaster();
        $payrollMaster->uuid = Str::uuid()->toString();
        $payrollMaster->date = $request->date;
        $payrollMaster->type = $request->type;
        $payrollMaster->date_from = $request->date_from;
        $payrollMaster->date_to = $request->date_to;

        $employees = Employee::query()->whereIn('slug',$request->employees)->get();
        $payrollEmployees = [];
        foreach ($request->employees as $employee){
            $e = $employees->firstWhere('slug',$employee);
            if(!empty($e)){
                $payrollEmployees[] = [
                    'employee_uuid' => $employee,
                    'saved_data' => [
                        'lastname' => $e->lastname,
                        'firstname' => $e->firstname,
                        'middlename' => $e->middlename,
                        'monthly_basic' => $e->monthly_basic,
                        'LFEMi' => $e->full['LFEMi'],
                        'FMiLE' => $e->full['FMiLE'],
                    ],
                ];
            }
        }
        try {
            $adjustments = PayrollAdjustments::query()->whereIn('code',['MID-MONTH','SSS','PAG-IBIG','PHILHEALTH','WTAX'])->get();

            DB::transaction(function () use ($payrollMaster,$payrollEmployees,$adjustments){
                $payrollMaster->save();
                $createdEmployees = $payrollMaster->payrollEmployees()->createMany($payrollEmployees);
                $employeeAdjustments = [];
                //mid-month default adjustments
                foreach ($createdEmployees as $createdEmployee){
                    foreach ($adjustments as $adjustment){
                        $employeeAdjustments[] = [
                            'payroll_employee_id' => $createdEmployee->id,
                            'employee_uuid' => $createdEmployee->employee_uuid,
                            'type' => $adjustment->type,
                            'code' => $adjustment->code,
                            'priority' => $adjustment->priority,
                        ];
                    }
                }
                PayrollEmployeeAdjustments::query()->insert($employeeAdjustments);
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }

        return $payrollMaster->only('uuid');
    }

    public function edit($uuid,Request $request)
    {
        if($request->has('fetchTable')){
            return  $this->fetchTable($uuid);
        }
        if($request->has('fetchTemplate')){
            return  $this->fetchTemplate($uuid);
        }


        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees'
            ])
            ->findOrFail($uuid);

        return view($this->folder.'.'.$payrollMaster->type.'.edit')->with([
            'payrollMaster' => $payrollMaster
        ]);
    }
    private function fetchTable($uuid)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees'=> function ($payrollEmployees) {
                    $payrollEmployees->orderBy('saved_data->lastname','asc');
                },
                'employeeAdjustments' => function ($employeeAdjustments) {
                    $employeeAdjustments
                        ->orderBy('type','desc')
                        ->orderBy('priority')
                        ->groupBy('code')
                    ;
                },
            ])
            ->findOrFail($uuid);

        $header = view($this->folder.'.'.$payrollMaster->type.'.t-header')->with([
            'payrollMaster' => $payrollMaster,
        ])->render();
        $rows = [];
        $rand = randString();
        foreach ($payrollMaster->payrollEmployees as $payrollEmployee){
            $rows[] = [
                'view' => view($this->folder.'.'.$payrollMaster->type.'.t-row')->with([
                        'payrollEmployee' => $payrollEmployee,
                        'employeeAdjustments' => $payrollMaster->employeeAdjustments,
                        'rand' => $rand,
                    ])->render(),
                'payroll_employee_id' => $payrollEmployee->id,
                'employee_uuid' => $payrollEmployee->employee_uuid,
                'rand' => $rand,
            ];
        }
        return [
            'header' => $header,
            'body' => $rows,
        ];
    }

    private function fetchTemplate($uuid)
    {
        $request = Request::capture();
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees',
            ])
            ->findOrFail($uuid);

        $template = PayrollTemplate::query()
            ->where('code','=',$request->fetchTemplate)
            ->whereIn('employee_uuid',$payrollMaster->payrollEmployees->pluck('employee_uuid')->toArray())
            ->get()
            ->mapWithKeys(function ($data){
                return [
                    $data->employee_uuid => $data->amount
                ];
            })
            ->toArray();
        return $template ?? [];
    }

    public function update(PayrollPreparationFormRequest $request,$uuid)
    {
        $requestPayrollEmployees = nested_collection($request->data);

        $payrollEmployees = PayrollEmployees::query()
            ->whereIn('id',$requestPayrollEmployees->keys()->toArray())
            ->get();
        $requestAdjustmentCodes = $requestPayrollEmployees
            ->map(function ($data){
                return $data->keys();
            })
            ->flatten()
            ->unique()
            ->values();

        $adjustmentsDb = PayrollAdjustments::query()
            ->whereIn('code',$requestAdjustmentCodes->toArray())
            ->get();

        $upsert = [];
        foreach ($requestPayrollEmployees as $requestPayrollEmployeeId => $requestPayrollEmployee){
            foreach ($requestPayrollEmployee as $adjustmentCode => $amount){
                $adjustmentDb = $adjustmentsDb->firstWhere('code','=',$adjustmentCode);
                $upsert[] = [
                    'payroll_employee_id' => $requestPayrollEmployeeId,
                    'employee_uuid' => $payrollEmployees->firstWhere('id','=',$requestPayrollEmployeeId)?->employee_uuid,
                    'type' => $adjustmentDb->type,
                    'code' => $adjustmentCode,
                    'amount' => $amount,
                    'priority' => $adjustmentDb->priority,
                ];
            }
        }

        try {
            DB::transaction(function () use ($upsert){
                PayrollEmployeeAdjustments::query()
                    ->upsert(
                        $upsert,
                        ['payroll_employee_id','code'], //unique cols
                        ['amount','priority','type'], //cols to update,
                    );
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }

        //compute for net pay
        $payrollEmployees = $payrollEmployees->load([
            'employeeAdjustments',
        ]);
        $netPayUpsert = [];
        foreach ($payrollEmployees as $payrollEmployee){
            $employeeAdjustments = $payrollEmployee->employeeAdjustments;
            $netPayUpsert[] = [
                'id' => $payrollEmployee->id,
                'net_pay' => $employeeAdjustments->where('type','INCENTIVE')->sum('amount') - $employeeAdjustments->where('type','DEDUCTION')->sum('amount'),
            ];
        }
        try {
            DB::transaction(function () use ($netPayUpsert){
                PayrollEmployees::query()
                    ->upsert(
                        $netPayUpsert,
                        ['id'], //unique cols
                        ['net_pay'], //cols to update,
                    );
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return response()->noContent();
    }
}
