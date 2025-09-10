<?php

namespace App\Http\Controllers;

use App\Exports\ApplicantsReportMainExporter;
use App\Models\Applicant;
use App\Models\ApplicantPositionApplied;
use App\Models\Course;
use App\Models\DepartmentUnit;
use App\Models\Document;
use App\Models\HRPayPlanitilla;
use App\Swep\Helpers\__sanitize;
use App\Swep\Helpers\Arrays;
use App\Swep\Repositories\ApplicantRepository;
use App\Swep\Services\ApplicantService;
use App\Http\Requests\Applicant\ApplicantFormRequest;
use App\Http\Requests\Applicant\ApplicantFilterRequest;
use App\Http\Requests\Applicant\ApplicantReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class ApplicantController extends Controller{



	protected $applicant;
    protected $applicantRepository;


    public function __construct(ApplicantService $applicant, ApplicantRepository $applicantRepository){

        $this->applicant = $applicant;
        $this->applicantRepository = $applicantRepository;
    }




	public function create(){
        return redirect(route('dashboard.applicant.index').'?initiator=create');
        return view('dashboard.applicant.create');

    }

    private function checkDuplicate($request){
        $applicant = Applicant::query()
            ->where('lastname','=',$request->lastname)
            ->where('firstname','=',$request->firstname)
            ->where('received_at','=',Carbon::parse($request->received_at)->format('Y-m-d'))
            ->first();
        if(!empty($applicant)){
            abort(507,$applicant->slug);
        }
    }


	public function store(ApplicantFormRequest $request){
//        $this->checkDuplicate($request);
        $payPlantillas = Arrays::payPlantillas();
        $applicant = new Applicant;
        $applicant->applicant_id = $this->applicantRepository->getApplicantIdInc();
        $applicant->slug = Str::random();
        $applicant->course = strtoupper($request->course);
        $applicant->lastname = strtoupper($request->lastname);
        $applicant->firstname = strtoupper($request->firstname);
        $applicant->middlename = strtoupper($request->middlename);
        $applicant->fullname = strtoupper($request->firstname).' '.strtoupper($request->lastname);
        $applicant->gender = $request->gender;
        $applicant->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $applicant->civil_status = $request->civil_status;
        $applicant->address = $request->address;
        $applicant->contact_no = $request->contact_no;
        $applicant->email = $request->email;
        $applicant->school = $request->school;
        $applicant->received_at = Carbon::parse($request->received_at)->format('Y-m-d');
        $positions = explode(',',$request->position_applied);
        if(count($positions) > 0){
            $positions_to_db = [];
            foreach ($positions as $position){
                $data = $position;
                $item_no = Str::replace(' ','',Str::after(Str::before($position,'-'),'ITEM'));
                if(isset($payPlantillas[$item_no])){
                    array_push($positions_to_db,[
                        'applicant_slug' => $applicant->slug,
                        'position_applied' =>  $payPlantillas[$item_no],
                        'item_no' => $item_no,
                    ]);
                }else{
                    array_push($positions_to_db,[
                        'applicant_slug' => $applicant->slug,
                        'position_applied' =>  strtoupper($position),
                        'item_no' => '',
                    ]);
                }
            }

        }
        if($applicant->save()){
            ApplicantPositionApplied::insert($positions_to_db);
            return $applicant->only('slug');
        }
        abort(503,'Error saving applicant data.');
    	return $this->applicant->store($request);

    }




	public function index(ApplicantFilterRequest $request){

        if($request->ajax() && $request->has('draw')){
            $applicants = Applicant::query()
                ->with(['positionApplied.item']);
            if(!is_null($request->course)){
                $applicants = $applicants->where('course','=',$request->course);
            }
            if(!is_null($request->sex)){
                $applicants  = $applicants->where('gender','=',$request->sex);
            }
            if(!is_null($request->civil_status)){
                $applicants  = $applicants->where('civil_status','=',$request->civil_status);
            }
            if(!is_null($request->position_applied)){
                $applicants  = $applicants->whereHas('positionApplied',function ($query) use($request){
                    $query->where('position_applied','=',$request->position_applied);
                });
            }
            if(!is_null($request->item_no)){
                $applicants  = $applicants->whereHas('positionApplied',function ($query) use($request){
                    $query->where('item_no','=',$request->item_no);
                });
            }
            return \DataTables::of($applicants)
                ->addColumn('action',function($data){
                    return view('_hru.applicants.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('date_of_birth',function($data){
                    return Carbon::parse($data->date_of_birth)->age;
                })
                ->addColumn('position_applied',function($data){
                    return view('_hru.applicants.dtPositionsApplied')->with([
                        'data' => $data,
                    ]);

                })
                ->addColumn('sl',function($data){
                    if($data->is_on_short_list == 1){
                        return '<i class="fa fa-check"></i>';
                    }
                })
                ->editColumn('course',function($data){
                    return view('_hru.applicants.dtCourse')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('received_at',function($data){
                    return Carbon::parse($data->received_at)->format('m/d/Y');
                })
                ->editColumn('fullname',function($data){
                    return  view('_hru.applicants.dtFullname')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
		return view('_hru.applicants.index');

    }

    public function findBySlug($slug){
        $applicant = Applicant::query()->where('slug','=',$slug)->first();
        if(!empty($applicant)){
            return $applicant;
        }
        abort(503,'Applicant not found.');
    }



	public function show($slug){

		return $this->applicant->show($slug);

    }




	public function edit($slug){
        $applicant = $this->findBySlug($slug);
        return view('_hru.applicants.edit')->with([
            'applicant' => $applicant,
        ]);

    }




	public function update(ApplicantFormRequest $request, $slug){

        $payPlantillas = Arrays::payPlantillas();
        $applicant = $this->findBySlug($slug);
        $applicant->course = strtoupper($request->course);
        $applicant->lastname = strtoupper($request->lastname);
        $applicant->firstname = strtoupper($request->firstname);
        $applicant->middlename = strtoupper($request->middlename);
        $applicant->fullname = strtoupper($request->firstname).' '.strtoupper($request->lastname);
        $applicant->gender = $request->gender;
        $applicant->date_of_birth = Carbon::parse($request->date_of_birth)->format('Y-m-d');
        $applicant->civil_status = $request->civil_status;
        $applicant->address = $request->address;
        $applicant->contact_no = $request->contact_no;
        $applicant->email = $request->email;
        $applicant->school = $request->school;
        $applicant->received_at = Carbon::parse($request->received_at)->format('Y-m-d');
        $positions = explode(',',$request->position_applied);
        if(count($positions) > 0){
            $positions_to_db = [];
            foreach ($positions as $position){
                $data = $position;
                $item_no = Str::replace(' ','',Str::after(Str::before($position,'-'),'ITEM'));
                if(isset($payPlantillas[$item_no])){
                    array_push($positions_to_db,[
                        'applicant_slug' => $applicant->slug,
                        'position_applied' =>  $payPlantillas[$item_no],
                        'item_no' => $item_no,
                    ]);
                }else{
                    array_push($positions_to_db,[
                        'applicant_slug' => $applicant->slug,
                        'position_applied' =>  strtoupper($position),
                        'item_no' => '',
                    ]);
                }
            }

        }

        if($applicant->update()){
            $applicant->positionApplied()->delete();
            ApplicantPositionApplied::insert($positions_to_db);
            return $applicant->only('slug');
        }
        abort(503,'Error saving applicant data.');
		return $this->applicant->update($request, $slug);

    }




	public function destroy($slug){
        $applicant = $this->findBySlug($slug);
        if($applicant->delete()){
            $applicant->positionApplied()->delete();
            return 1;
        }
		return $this->applicant->destroy($slug);

    }




	public function report(){

		return view('_hru.applicants.report')->with(['columns' => $this->report_columns()]);

    }




	public function reportGenerate(Request $request){
        $activity = activity()
            ->performedOn(new Applicant())
            ->causedBy(Auth::user()->id)
            ->withProperties(['attributes' => 'Generated report on Applicants.'])
            ->log('generated');

        $applicants_db = Applicant::with(['course','departmentUnit','positionApplied'])->orderBy('lastname','asc');
        $filters = [];
        if($request->course != '' || !empty($request->course)){
            $applicants_db = $applicants_db->where('course',$request->course);
            $course_db = Course::where('course_id',$request->course)->first();
        }

        if($request->has('date_range')){
            $date_range = __sanitize::date_range($request->date_range);
            $applicants_db = $applicants_db->whereBetween('received_at',$date_range);
        }

        if($request->unit_applied != '' || !empty($request->unit_applied)){
            $applicants_db = $applicants_db->where('department_unit_id',$request->unit_applied);
            $unit_db = DepartmentUnit::where('department_unit_id',$request->unit_applied)->first();
            if(!empty($course_db)){
                $filters['UNIT APPLIED'] = $unit_db->description;
            }else{
                $filters['UNIT APPLIED'] = 'Course not found';
            }
        }

        if($request->position_applied != '' || !empty($request->position_applied)){
            $position_applied = $request->position_applied;
            $applicants_db = $applicants_db->whereHas('positionApplied',function ($query) use($position_applied){
               return $query->where('position_applied',$position_applied);
            });
            $filters['POSITION APPLIED'] = $request->position_applied;
        }
        if($request->item_no != '' || !empty($request->item_no)){
            $item_no = $request->item_no;
            $applicants_db = $applicants_db->whereHas('positionApplied',function ($query) use($item_no){
                return $query->where('item_no',$item_no);
            });

            $filters['ITEM NO'] = $item_no;
        }

        $applicants_db = $applicants_db->get();
        $applicants = [];
        if($request->layout == 'all'){
            foreach ($applicants_db as $applicant_db){
                $applicants['ALL APPLICANTS'][$applicant_db->slug] = ['applicant_obj' => $applicant_db];
                $applicants['ALL APPLICANTS']['label'] = 'ALL APPLICANTS';
            }
        }

        if($request->layout == 'by_course'){
            foreach ($applicants_db as $applicant_db){
                $applicants[$applicant_db->course][$applicant_db->slug] = ['applicant_obj' => $applicant_db];

                $applicants[$applicant_db->course][$applicant_db->slug] = ['applicant_obj'=>$applicant_db];
                $applicants[$applicant_db->course]['label'] = $applicant_db->course;
            }
        }

        if($request->layout == 'by_unit'){
            foreach ($applicants_db as $applicant_db){

                if(!empty($applicant_db->departmentUnit)){
                    $applicants[$applicant_db->department_unit_id]['label'] = $applicant_db->departmentUnit->description;
                    $applicants[$applicant_db->department_unit_id][$applicant_db->slug] = ['applicant_obj' => $applicant_db];
                }else{
                    $applicants['NULL']['label'] = 'No Unit Stated';
                    $applicants['NULL'][$applicant_db->slug] = ['applicant_obj' => $applicant_db];
                }
            }
        }


        if($request->layout == 'by_position_applied'){
            foreach ($applicants_db as $applicant_db){
                foreach ($applicant_db->positionApplied as $position_applied){

                    $applicants[$position_applied->position_applied][$applicant_db->slug] = ['applicant_obj'=>$applicant_db];
                    $applicants[$position_applied->position_applied]['label'] = $position_applied->position_applied;
                }
            }
        }
        if($request->layout == 'by_item_no'){
            foreach ($applicants_db as $applicant_db){
                foreach ($applicant_db->positionApplied as $position_applied){
                    $number = 0;
                    if($position_applied->item_no != null || $position_applied->item_no != ''){
                        $number = $position_applied->item_no;
                        $applicants[$position_applied->item_no][$applicant_db->slug] = ['applicant_obj'=>$applicant_db];
                        $applicants[$number]['label'] = $position_applied->item_no .' - '.$position_applied->item->position;
                    }
                    else{
                        $number = 1000;
                        $applicants[$number][$applicant_db->slug] = ['applicant_obj'=>$applicant_db];
                        $applicants[$number]['label'] = 'NO ITEM INDICATED';
                    }


                }
            }
            if($request->item_no != '' || !empty($request->item_no)){
                foreach ($applicants as $key=> $applicant){
                    if($request->item_no != $key){
                        unset($applicants[$key]);
                    }
                }
            }
        }

        ksort($applicants);
        $data = [
            'grouped_applicants' => $applicants,
            'columns' => $this->report_columns(),
            'requested_columns' => $request->columns,
            'request' => $request,
            'filters' => $filters,
        ];
        if($request->excel == true){
            return Excel::download(
                new ApplicantsReportMainExporter($data),
                'Applicants Report.xlsx',
            );
        }

        return view('printables.applicant.report_3')->with($data);

    }




	public function addToShortList($slug){
        $applicant = $this->findBySlug($slug);
        $applicant->is_on_short_list = 1;

        if($applicant->update()){
            return $slug;
        }
        abort(503,'Error adding applicant to short list');
		return $this->applicant->addToShortList($slug);

    }




	public function removeToShortList($slug){
        $applicant = $this->findBySlug($slug);
        $applicant->is_on_short_list = 0;

        if($applicant->update()){
            return $slug;
        }
        abort(503,'Error removing applicant to short list');
		return $this->applicant->removeToShortList($slug);

    }


    
    private function report_columns(){
        return [
            'numbering' => 'Numbering',
            'received_at' => 'Date of Application',
            'fullname' => 'Fullname',
            'course' => 'Course',
            'department_unit' => 'Unit Applied',
            'gender' => 'Gender',
            'date_of_birth' => 'Date of Birth',
            'civil_status' => 'Civil Status',
            'address' => 'Address',
            'contact_no' => 'Contact #',
            'email' => 'Email Address',
            'school' => 'School',
            'remarks' => 'Remarks',
            'position_applied' => 'Position Applied',
        ];
    }

    
}
