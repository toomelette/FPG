<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\COSEmployeesFormRequest;
use App\Imports\GSISImport;
use App\Models\Employee;
use App\Models\HRU\COS;
use App\Models\HRU\COSEmployees;
use App\Swep\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Yajra\DataTables\Facades\DataTables;
use function Symfony\Component\Translation\t;

class COSEmployeesController extends Controller
{
    public function index(Request $request,$slug)
    {
        if($request->has('viewEvaluation')){
            $cosEmployee = COSEmployees::query()->findOrFail($slug);
            return $this->viewEvaluation($cosEmployee);
        }
        if($request->has('printContract')){
            return $this->printContract($slug);
        }
        if($request->has('printMultiple')){
            return $this->printMultiple($slug);
        }
        if($request->ajax() && $request->has('draw')){

            $cosEmps = COSEmployees::query()
                ->with(['employee.responsibilityCenter'])
                ->where('cos_slug','=',$slug);

            return DataTables::of($cosEmps)
                ->addColumn('actions',function ($cosEmployee){
                    return view('_hru.cos-employees.dtActions')->with([
                        'cosEmployee' => $cosEmployee,
                    ]);
                })
                ->addColumn('print_contract',function ($cosEmployee){
                    return view('_hru.cos-employees.dtPrintContract')->with([
                        'cosEmployee' => $cosEmployee,
                    ]);
                    return view('_hru.cos-employees.dtAllowPrint')->with([
                        'cosEmployee' => $cosEmployee,
                    ]);
                })
                ->editColumn('evaluation_path',function ($data){
                    if($data->evaluation_path){
                        return view('_hru.cos-employees.dtViewFile')->with([
                            'data' => $data,
                        ]);
                    }
                })
                ->escapeColumns([])
                ->setRowId('hr_cos_employees_slug')
                ->toJson();
        }
        $cos = COS::query()->findOrFail($slug);
        return view('_hru.cos-employees.index')->with([
            'cos' => $cos,
        ]);
    }

    public function import($request, $slug)
    {
        $excel = Excel::toArray(new GSISImport(),$request->file('file'));
        $requiredHeaders = [
            'employee_no', 'name', 'position','cos_assignment','salary','type','resp_center',
        ];
        $excelHeaders = $excel[0][0];
        $differences = array_diff($requiredHeaders,$excelHeaders);
        $excelData = $excel[0];
        $empNoKey = array_search('employee_no',$excelHeaders);
        $nameKey = array_search('name',$excelHeaders);
        unset($excelData[0]);
        $toUpsert = [];
        $batchCode = Str::random(6);
        if(empty($differences)){

            $empNosFromExcel = array_column($excelData,$empNoKey);
            //check database of employees
            $empsFromDb = Employee::query()
                ->whereIn('employee_no',$empNosFromExcel)
                ->active()
                ->cos()
                ->get();
            $empNosFromDb =  $empsFromDb->pluck('employee_no');
            $checkDifferences = array_diff($empNosFromExcel,$empNosFromDb->toArray());


            foreach ($excelData as $excelDatum){
                $emp = [];
                foreach ($excelDatum as $key => $item){
                   if(array_search($excelHeaders[$key],$requiredHeaders) !== false){
                       $emp[$excelHeaders[$key]] = $item;
                   }
                }
                if(!empty($emp)){
                    $emp['hr_cos_employees_slug'] = Str::random();
                    $emp['cos_slug'] = $slug;
                    $emp['batch_code'] = $batchCode;
                    $empFromDtb = $empsFromDb->where('employee_no','=',$excelDatum[$empNoKey])->first();
                    if(!empty($empFromDtb)){
                        $emp['employee_slug'] = $empFromDtb->slug;
                        $emp['employee_fullname'] = $empFromDtb->full['FMiLE'];

                    }

                }
                $toUpsert[] = $emp;
            }



            if(empty($checkDifferences)){
                //continue insert
                $filteredToInsert = [];
                $except = ['employee_no','name','position','salary'];
                foreach ($toUpsert as $value){
                    $filteredToInsert[] = collect($value)->except($except)->toArray();
                }
                COSEmployees::query()->insert($filteredToInsert);

                //update employee data first
                if ($request->has('update')){
                    foreach ($toUpsert as $value){
                        $empFromDb = $empsFromDb->where('slug','=',$value['employee_slug'])->first();
                        $empFromDb->resp_center = $value['resp_center'];
                        $empFromDb->monthly_basic = $value['salary'];
                        $empFromDb->position = Str::upper($value['position']);
                        $empFromDb->save();
                    }
                }



                return 1;
                //
            }else{
                //alert user to check the excel file
                $nonExistingEmployees = [];
                foreach ($checkDifferences as $checkDifference){

//                    dd($excelData[array_search($checkDifference,$empNosFromExcel)]);
                    $targetNonExistentEmp = $excelData[array_search($checkDifference,$empNosFromExcel)+1];
                    $nonExistingEmployees[$targetNonExistentEmp[$empNoKey]] = $targetNonExistentEmp[$nameKey];
                }

                $error = [
                    'message' => 'Some employees in your excel file do not exist in the master list of COS Employees. :',
                    'dataArray' => $nonExistingEmployees,
                ];
                abort(515,json_encode($error));
            }
        }else{
            abort(503,'Some required headers are not present in your uploaded excel file: '.implode(',',$differences));
        }
    }
    public function store(COSEmployeesFormRequest $request,$slug)
    {
        if ($request->has('multiple')){
            return $this->storeMultiple($request,$slug);
        }
        if ($request->has('import')){
            return $this->import($request,$slug);
        }
        $cosEmp = new COSEmployees();
        $cosEmp->hr_cos_employees_slug = Str::random();
        $cosEmp->cos_slug = $slug;
        $cosEmp->employee_slug = $request->employee_slug;
        if ($cosEmp->save()){
            $cosEmp->load('employee');
            $cosEmp->employee_fullname = $cosEmp->employee->full['LFEMi'];
            $cosEmp->resp_center = $cosEmp->employee->resp_center;
            $cosEmp->cos_assignment = $cosEmp->employee->responsibilityCenter->long_name ?? $cosEmp?->employee?->responsibilityCenter?->desc;

            $cosEmp->saveQuietly();
            $cosEmp->cos->touch();
            return $cosEmp->only('slug');
        }
        abort(503,'Error adding employee.');
    }
    public function storeMultiple($request, $slug)
    {
        $employees = $request->employees;
        $insert = [];

        if( $employees && count($employees) > 0){
            $cos = COS::query()
                ->with(['employees'])
                ->findOrFail($slug);
            $employeesFromDb = Employee::query()
                ->with(['responsibilityCenter'])
                ->whereIn('slug',array_column($employees,'checked'))
                ->whereNotIn('slug',$cos->employees->pluck('employee_slug'))
                ->get();

            foreach ($employees as $employeeSlug => $employee) {
                if(isset($employee['checked'])){
                    $insert[] = [
                        'hr_cos_employees_slug' => Str::random(),
                        'cos_slug' => $slug,
                        'employee_slug' => $employee['checked'],
                        'cos_assignment' => $employee['assignment'],
                        'employee_fullname' => $employeesFromDb?->firstWhere('slug',$employeeSlug)?->full['LFEMi'],
                        'resp_center' => $employeesFromDb?->firstWhere('slug',$employeeSlug)?->responsibilityCenter?->rc_code,
                    ];
                }
            }
        }
        if(COSEmployees::query()->insert($insert)){
            return $slug;
        }
        abort(503,'Error adding employees.');

    }

    public function edit($slug)
    {
        $cosEmp = COSEmployees::query()
            ->with(['employee.responsibilityCenter'])
            ->findOrFail($slug);
        return view('_hru.cos-employees.edit',compact('cosEmp'));
    }

    public function update(Request $request, $slug)
    {
        if($request->has('allowPrint')){
            return $this->allowPrint($request,$slug);
        }
        $request->validate([
            'resp_center' => 'required',
            'cos_assignment' => 'required',
        ]);

        $cosEmp = COSEmployees::query()->findOrFail($slug);
        $cosEmp->resp_center = $request->resp_center;
        $cosEmp->cos_assignment = $request->cos_assignment;
        if($cosEmp->update()){
            return $cosEmp->only('hr_cos_employees_slug');
        }
        abort(503,'Error updating employee.');
    }

    public function allowPrint(Request $request,$slug)
    {
        $cosEmp = COSEmployees::query()->findOrFail($slug);
        $checked = filter_var($request->checked,258);
        if($checked){
            $cosEmp->status = 'APPROVED';
        }else{
            $cosEmp->status = null;
        }
        if($cosEmp->update()){
            return $request->only($slug);
        }
        abort(503,'Error updating employee.');
    }
    public function destroy($slug)
    {
        $cosEmp = COSEmployees::query()->findOrFail($slug);
        if ($cosEmp->delete()){
            return 1;
        }
        abort(503,'Error removing employee.');
    }

    public function myIndex(Request $request,$slug)
    {

        $cosEmp = COSEmployees::query()->findOrFail($slug);
        if($cosEmp->cos->is_active != 1){
            abort(404);
        }
        if($request->has('viewEvaluation')){
            if (($cosEmp->employee_slug == Auth::user()->employee->slug) || Helper::checkRouteAccess('dashboard.my_cos.index')){
                return $this->viewEvaluation($cosEmp);
            }else{
                abort(403,'Unauthorized access.');
            }


        }
        if($request->has('printContract')){
           return  $this->printContract($slug);
        }

        return view('_hru.cos-employees.my-index')->with([
            'cosEmp' => $cosEmp,
        ]);
    }

    public function viewEvaluation($cosEmp)
    {
        $storage = Storage::disk('contract_of_service');
        if ($storage->exists($cosEmp->evaluation_path)){
            return  $storage->response($cosEmp->evaluation_path);
        }
        abort(404,'File does not exist.');
    }
    public function uploadEvaluation(Request $request,$slug)
    {
        $request->validate([
            'doc_file' => 'required|mimes:pdf',
        ]);
        $cosEmployee = COSEmployees::query()->findOrFail($slug);
        if($cosEmployee->cos->is_active != 1){
            abort(503,'Contract of service not active.');
        }
        $baseName = 'Evaluation - '.Auth::user()->employee->employee_no.' - '.Carbon::now()->format('Y-m-d H,i,s');
        $fileName = $baseName.'.'.$request->file('doc_file')->getClientOriginalExtension();

        $storage = Storage::disk('contract_of_service');
        $store = $storage->putFileAs(null,$request->file('doc_file'),$fileName);

        if($store){
            $cosEmployee->evaluation_path = $fileName;
            $cosEmployee->evaluation_uploaded_at = Carbon::now();
            if($cosEmployee->save()){
                return $cosEmployee->only('slug');
            }
        }
        abort(503,'Error uploading file.');
    }

    public function updateData(Request $request,$slug)
    {
        $request->validate([
            'civil_status' => 'required',
            'address' => 'required',
            'witness_1' => 'required',
            'witness_2' => 'required',
            'valid_id' => 'required',
            'valid_id_issued_at' => 'required',
        ]);

        $witnesses = [
            $request->witness_1, $request->witness_2,
        ];
        $employees = Employee::query()->whereIn('slug',$witnesses)->get();
        $witness_1 = $employees->firstWhere('slug',$request->witness_1);
        $witness_2 = $employees->firstWhere('slug',$request->witness_2);

        $cosEmployee = COSEmployees::query()->findOrFail($slug);
        if($cosEmployee->cos->is_active != 1){
            abort(503,'Contract of service not active.');
        }
        $cosEmployee->other_data = [
            'civil_status' => $request->civil_status,
            'address' => $request->address,
            'witness_1' => $request->witness_1,
            'witness_2' => $request->witness_2,
            'witness_1_name' => $witness_1->full['FMiLE'] ?? null,
            'witness_2_name' => $witness_2->full['FMiLE'] ?? null,
            'witness_1_position' => $witness_1->plantilla?->position,
            'witness_2_position' => $witness_2->plantilla?->position,
            'valid_id' => $request->valid_id,
            'valid_id_issued_at' => $request->valid_id_issued_at,
        ];
        if($cosEmployee->save()){
            return $cosEmployee->only('slug');
        }
        abort(503,'Error updating data.');
    }

    public function printMultiple($slug)
    {
        $request = Request::capture();

        $cosEmps = COSEmployees::query()
            ->with(['cos','employee'])
            ->whereIn('resp_center',$request->rcs)
            ->get();

        return Pdf::view('printables.hru.cos.contract',[
            'pdfPrint' => true,
            'cosEmps' => $cosEmps,
        ])
            ->paperSize(215.9,330.2)
            ->margins(20,20, 20, 20)
            ->headers(['title' => 'aaaaa'])
            ->footerView('printables.hru.hr-requests.contract-of-service-footer')
            ->name('Contract of Service.pdf')
            ->withBrowsershot(function (Browsershot $browsershot){
                if(app()->environment('production')){
                    $browsershot->setNodeBinary(env('NODE_BINARY'))
                        ->setNpmBinary(env('NODE_BINARY'));
                }
            });
    }
    public function printContract($slug)
    {
        $cosEmp = COSEmployees::query()
            ->with(['cos','employee'])
            ->findOrFail($slug);

        if($cosEmp->cos->is_active != 1){
            abort(503,'Contract of service not active.');
        }

        return Pdf::view('printables.hru.cos.contract',[
            'pdfPrint' => true,
            'cosEmps' => [$cosEmp],
        ])
            ->paperSize(215.9,330.2)
            ->margins(20,20, 20, 20)
            ->headers(['title' => 'aaaaa'])
            ->footerView('printables.hru.hr-requests.contract-of-service-footer')
            ->name('Contract of Service.pdf')
            ->withBrowsershot(function (Browsershot $browsershot){
                if(app()->environment('production')){
                    $browsershot->setNodeBinary(env('NODE_BINARY'))
                        ->setNpmBinary(env('NODE_BINARY'));
                }
            });

        /*
        return view('printables.hru.hr-requests.contract-of-service')->with([
            'hrRequest' => $hrRequest,
            'witness_1' => $witness_1,
            'witness_2' => $witness_2,
        ]);
        */
    }
    public function create($slug)
    {
        $cos = COS::query()
            ->with(['employees.employee.responsibilityCenter'])
            ->findOrFail($slug);
        $existingEmployees = $cos->employees->pluck('employee_slug');
        $employees = Employee::query()
            ->whereNotIn('slug',$existingEmployees->toArray())
            ->orderBy('lastname')
            ->cos()
            ->applyProjectId()
            ->active()
            ->get();
        return view('_hru.cos-employees.create')->with([
            'cos' => $cos,
            'employees' => $employees,
        ]);
    }
}