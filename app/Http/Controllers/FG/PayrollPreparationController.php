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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

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
        $payrollMaster->date = Carbon::parse($request->date)->firstOfMonth()->format('Y-m-d');
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
                        'position' => $e->position,
                        'employee_no' => $e->employee_no,
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

    private function addAdjustment(Request $request,$uuid)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees',
                'employeeAdjustments'
            ])
            ->findOrFail($uuid);
        $codesUsed = $payrollMaster->employeeAdjustments->pluck('code')->unique();
        if(!$codesUsed->contains($request->adjustment_code)){
            $adjustment = PayrollAdjustments::query()->where('code','=',$request->adjustment_code)->firstOrFail();

            $employeeAdjustmentsToInsert = $payrollMaster->payrollEmployees->map(function ($payrollEmployee) use ($adjustment){
                return [
                    'payroll_employee_id' => $payrollEmployee->id,
                    'employee_uuid' => $payrollEmployee->employee_uuid,
                    'type' => $adjustment->type,
                    'code' => $adjustment->code,
                    'priority' => $adjustment->priority,
                ];
            });
            try {
                DB::transaction(function () use ($employeeAdjustmentsToInsert){
                    PayrollEmployeeAdjustments::query()->insert($employeeAdjustmentsToInsert->toArray());
                });
            }catch (\Exception $exception){
                abort(503,$exception->getMessage());
            }
        }else{
            throw ValidationException::withMessages([
                'adjustment_code' => ['The adjustment code selected is already added in this payroll.'],
            ]);
        }



    }
    public function update(PayrollPreparationFormRequest $request,$uuid)
    {
        if($request->has('addAdjustment')){
            return $this->addAdjustment($request,$uuid);
        }
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

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $payrollMasters = PayrollMaster::query()
                ->withCount(['payrollEmployees'])
                ->withSum('payrollEmployees','net_pay')
            ;
            return DataTables::of($payrollMasters)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-action')->with([
                        'data' => $data
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function destroy($uuid)
    {
        $payrollMaster = PayrollMaster::query()
            ->findOrFail($uuid);

        try {
            DB::transaction(function () use ($payrollMaster){
                $payrollMaster->delete();
                $payrollMaster->payrollEmployees()->delete();
                $payrollMaster->employeeAdjustments()->delete();
            });
        }catch (\Exception $e){
            abort(503,$e->getMessage());
        }
        return 1;
    }

    public function print($uuid,$type)
    {
        return $this->{Str::of($type)->camel()->toString()}($uuid);

    }

    private function payrollSummary($uuid)
    {
        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees'=> function ($payrollEmployees) {
                    $payrollEmployees->orderBy('saved_data->lastname','asc');
                },
                'payrollEmployees.employeeAdjustments',
                'employeeAdjustments' => function ($employeeAdjustments) {
                    $employeeAdjustments
                        ->orderBy('type','desc')
                        ->orderBy('priority')
                        ->groupBy('code')
                    ;
                },
            ])
            ->findOrFail($uuid);
        $deductionsUsed = $payrollMaster->employeeAdjustments
            ->where('type','=','DEDUCTION')
            ->sortBy(function ($adjustment){
                return $adjustment->priority;
            })
            ->groupBy('code')
            ->keys()
        ;
        $incentivesUsed = $payrollMaster->employeeAdjustments
            ->where('type','=','INCENTIVE')
            ->sortBy(function ($adjustment){
                return $adjustment->priority;
            })
            ->groupBy('code')
            ->keys()
        ;

        return view('fg.payroll-preparation.MID-MONTH.payroll')->with([
            'payrollMaster' => $payrollMaster,
            'deductionsUsed' => $deductionsUsed,
            'incentivesUsed' => $incentivesUsed,
        ]);
    }

    private function payslips($uuid)
    {
        $request = Request::capture();

        $payrollMaster = PayrollMaster::query()
            ->with([
                'payrollEmployees' => function ($payrollEmployees) use($request) {
                    if($request->has('single')){
                        $payrollEmployees->where('id','=',$request->employee);
                    }
                },
                'payrollEmployees.employeeAdjustments',
                'employeeAdjustments',

            ])
            ->findOrFail($uuid);
        return view('fg.payroll-preparation.MID-MONTH.print-payslips')->with([
            'payrollMaster' => $payrollMaster,
        ]);
    }
}
