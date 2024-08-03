<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Swep\Services\CourseService;
use App\Http\Requests\Course\CourseFormRequest;
use App\Http\Requests\Course\CourseFilterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CourseController extends Controller{



	protected $course;



    public function __construct(CourseService $course){

        $this->course = $course;

    }



    
    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $courses = Course::query();
            return DataTables::of($courses)
                ->addColumn('action',function($data){
                    return view('_hru.courses.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.courses.index');
        return $this->course->fetch($request);
    
    }

    


    public function create(){
        return redirect(route('dashboard.course.index').'?initiator=create');
        return view('dashboard.course.create');

    }

    


    public function store(CourseFormRequest $request){
        $course = new Course();
        $course->slug = Str::random();
        $course->course_id = $this->getCourseIdInc();
        $course->acronym = $request->acronym;
        $course->name = $request->name;
        if($course->save()){
            return $course->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function getCourseIdInc(){
        $id = 'C10001';
        $course = Course::query()
            ->select('course_id')
            ->orderBy('course_id', 'desc')
            ->first();
        if($course != null){
            if($course->course_id != null){
                $num = str_replace('C', '', $course->course_id) + 1;
                $id = 'C' . $num;
            }
        }
        return $id;

    }




    public function edit($slug){
        $course = Course::query()->findOrFail($slug);
        return view('_hru.courses.edit')->with([
            'course' => $course,
        ]);
    }




    public function update(CourseFormRequest $request, $slug){

        $course = Course::query()->findOrFail($slug);
        $course->acronym = $request->acronym;
        $course->name = $request->name;
        if($course->save()){
            return $course->only('slug');
        }
        abort(503,'Error saving data.');

    }

    


    public function destroy($slug){

        $course = Course::query()->findOrFail($slug);
        if($course->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }



    
}
