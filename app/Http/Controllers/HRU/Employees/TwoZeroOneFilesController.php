<?php

namespace App\Http\Controllers\HRU\Employees;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeFile201FormRequest;
use App\Models\Employee;
use App\Models\EmployeeFile201;
use App\Swep\Helpers\__static;
use App\Swep\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class TwoZeroOneFilesController extends  Controller
{
    public function __construct()
    {
        $this->path = 'HR/File201/';
    }

    public function index($slug,Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $files = EmployeeFile201::query()
                ->where('employee_slug','=',$slug);
            return DataTables::of($files)
                ->addColumn('action',function ($data){
                    return view('_hru.employee.201.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('filename',function ($data){
                    return '<a href="'.route("dashboard.view_document.index",[$data->slug,'view_201File']).'" target="_blank"> <i class="fas fa-file-pdf"></i> '.$data->filename.'</a>';
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        if($request->has('edit')){
            return  $this->edit($slug);
        }
        if($request->has('view-file')){
            return  1;
        }
        $employee = Employee::findOrFail($slug);
        return view('_hru.employee.201.index')->with([
            'employee' => $employee,
        ]);
    }

    public function edit($slug)
    {
        $file = EmployeeFile201::query()->findOrFail($slug);
        return view('_hru.employee.201.edit')->with([
            'file' => $file,
        ]);
    }

    public function store($employeeSlug, EmployeeFile201FormRequest $request)
    {
        $filesArr = [];
        $employee = Employee::query()->findOrFail($employeeSlug);
        $file201 = new EmployeeFile201();
        $file201->slug =Str::random();
        $file201->title = ucfirst($request->title);
        $file201->description = ucfirst($request->description);
        $file201->date = $request->date;
        $file201->type = $request->type;

        if(!empty($request->doc_file)){
            foreach ($request->file('doc_file') as $file){
                if(Helper::convertFromBytes($file->getSize(),'MB') > 5){
                    abort(503,'Max file size: 5Mb');
                }
                $original_ext = $file->getClientOriginalExtension();
                $original_file_name_only = str_replace('.'.$original_ext,'',$file->getClientOriginalName());
                $new_file_name_full = $original_file_name_only.'-'.Str::random(10).'.'.$original_ext;
                $fullPath = '/File201/'.$employee->employee_no.'/'.$new_file_name_full;
                \Storage::disk('local_hru')->put($fullPath,$file->get());
                $file201->employee_no = $employee->employee_no;
                $file201->employee_slug = $employee->slug;
                $file201->filename = $new_file_name_full;
                $file201->original_filename =  $original_file_name_only.'.'.$original_ext;
                $file201->file_ext = $original_ext;
                $file201->full_path = $fullPath;
            }
        }else{
            abort(503,'At least 1 attachment is required.');
        }

        if($file201->save()){
            return $file201->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($slug)
    {
        $file201 = EmployeeFile201::query()->findOrFail($slug);
        $this->deleteFile($file201->employee_no,$file201->filename);

        if($file201->delete()){
            return 1;
        }
        abort(503,'Error deleting 201 file, however, the physical file was deleted.');
    }

    private function deleteFile($employee_no,$filename){
        $path = __static::archive_dir().$this->path.$employee_no.'/'.$filename;
        if(\File::exists($path)){
            \File::delete($path);
            return true;
        }
        return false;
    }

    public function update(EmployeeFile201FormRequest $request,$slug)
    {
        $file201 = EmployeeFile201::findOrFail($slug);
        $file201->title = ucfirst($request->title);
        $file201->description = ucfirst($request->description);
        $file201->date = $request->date;
        $file201->type = $request->type;
        if($file201->save()){
            return $file201->only('slug');
        }
        abort(503,'Error updating 201 file.');
    }
}