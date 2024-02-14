<?php


namespace App\Http\Controllers;


use __static;
use App\Http\Requests\Employee\EmployeeFile201FormRequest;
use App\Http\Requests\Employee\EmployeeFile201UpdateFormRequest;
use App\Models\EmployeeFile201;
use App\Models\NewsAttachments;
use App\Swep\Helpers\Helper;
//use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class File201Controller extends Controller
{
    public function __construct()
    {
        $this->path = 'HR/File201/';
    }

    public function index(Request $request, EmployeeController $employeeController){
        if($request->draw != null){
            $file201 = EmployeeFile201::query();
            $employee = $employeeController->findEmployeeBySlug($request->employee);
            $file201 = $file201->where('employee_slug' ,'=',$employee->slug);
            $dt = DataTables::of($file201)
                ->addColumn('action',function ($data){
                    $destroy_route = "'".route("dashboard.file201.destroy","slug")."'";
                    $slug = "'".$data->slug."'";
                    return '<div class="btn-group btn-group-xs">
                                <button type="button" data="'.$data->slug.'" uri="'.route("dashboard.file201.edit",$data->slug).'" class="btn btn-default btn-xs edit_file201_btn" data-toggle="modal" data-target="#edit_file201_modal" title="" data-placement="top" data-original-title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" onclick="delete_data('.$slug.','.$destroy_route.')" data="'.$data->slug.'" class="btn btn-xs btn-danger" data-toggle="tooltip" title="" data-placement="top" data-original-title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>';
                })
                ->editColumn('filename',function ($data){
                    return '<a href="'.route("dashboard.view_document.index",[$data->slug,'view_201File']).'" target="_blank"><i class="fa fa-paperclip"></i> '.$data->filename.'</a>';
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->make(true);

            return $dt;
        }
        if(!empty($request->employee) && $request->employee == null){
            abort(503,'Missing Parameters');
        }

        $employee = $employeeController->findEmployeeBySlug($request->employee);
        return view('dashboard.employee.file201.index')->with([
            'employee' => $employee,
        ]);
    }

    public function create(Request $request, EmployeeController $employeeController){
        $employee = $employeeController->findEmployeeBySlug($request->employee);
        return view('dashboard.employee.file201.create')->with([
            'employee' => $employee,
        ]);
    }

    public function store(EmployeeFile201FormRequest $request, EmployeeController $employeeController){

        $filesArr = [];
        $employee = $employeeController->findEmployeeBySlug($request->employee);
        $file201 = new EmployeeFile201;
        $file201->slug =Str::random();
        $file201->title = ucfirst($request->title);
        $file201->description = ucfirst($request->description);

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

    private function findBySlug($slug){
        $file201 = EmployeeFile201::query()->where('slug','=',$slug)->first();
        if(empty($file201)){
            abort(405,'Data not found');
        }
        return $file201;
    }

    public function edit($slug){
        $file201 = $this->findBySlug($slug);
        return view('dashboard.employee.file201.edit')->with([
            'file201' => $file201,
        ]);
    }

    public function update(EmployeeFile201UpdateFormRequest $request,$slug,EmployeeController $employeeController){
        $file201 = $this->findBySlug($slug);
        $file201->title = $request->title;
        $file201->description = $request->description;

        $employee = $file201->employeeData;
        if($request->_changed == 'true'){
            if(!empty($request->doc_file)){
                $this->deleteFile($file201->employee_no,$file201->filename);
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
                    $file201->filename = $new_file_name_full;
                    $file201->original_filename =  $original_file_name_only.'.'.$original_ext;
                    $file201->file_ext = $original_ext;
                    $file201->full_path = $fullPath;
                }
            }else{
                abort(503,'At least 1 attachment is required.');
            }
        }
        if($file201->save()){
            return $file201->only('slug');
        }
        abort(503, 'Error saving data.');
    }

    private function deleteFile($employee_no,$filename){
        $path = __static::archive_dir().$this->path.$employee_no.'/'.$filename;
        if(\File::exists($path)){
            \File::delete($path);
            return true;
        }
        return false;
    }
    public function destroy($slug){
        $file201 = $this->findBySlug($slug);
        $this->deleteFile($file201->employee_no,$file201->filename);

        if($file201->delete()){
            return 1;
        }
        abort(503,'Error deleting 201 file although the physical file was deleted.');

    }
}