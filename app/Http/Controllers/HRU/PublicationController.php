<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\PublicationFormRequest;
use App\Models\HRU\PublicationDetails;
use App\Models\HRU\Publications;
use App\Swep\Helpers\Helper;
use App\Swep\Services\HRU\PlantillaService;
use App\Swep\Services\HRU\PublicationDetailService;
use App\Swep\Services\HRU\PublicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PublicationController extends Controller
{

    public function __construct(
        protected PublicationService $publicationService,
        protected PlantillaService $plantillaService,
        protected PublicationDetailService $publicationDetailService,
    )
    {
        $this->publicationService = $publicationService;

    }

    public function create(){
        return view('dashboard.hru.publication.create');
    }

    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            return  $this->dataTable($request);
        }
        return view('dashboard.hru.publication.index');
    }

    private function dataTable(Request $request){
        $publications = Publications::query()
            ->withCount('publicationDetails');
        return DataTables::of($publications)
            ->editColumn('date',function($data){
                return Helper::dateFormat($data->date,'F d, Y');
            })
            ->editColumn('deadline',function($data){
                return Helper::dateFormat($data->deadline,'F d, Y');
            })
            ->addColumn('details',function($data){
                return '<b>'.$data->publication_details_count.'</b> Plantilla item(s) included.';
            })
            ->editColumn('is_final',function($data){
                if($data->is_final == 1){
                    return 'FINAL';
                }
                return 'DRAFT';
            })
            ->addColumn('action',function($data){
                return view('dashboard.hru.publication.dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }

    public function store(PublicationFormRequest $request){
        $publication = new Publications();
        $publication->slug = Str::random();
        $publication->date = $request->date;
        $publication->deadline = $request->deadline;
        $publication->send_to = $request->send_to;
        $publication->send_to_position = $request->send_to_position;
        $publication->send_to_address = $request->send_to_address;
        $publication->send_to_email = $request->send_to_email;
        if($publication->save()){
            return $publication->only('slug');
        }
        abort(503,'Failed to save data.');
    }

    public function edit(Request $request,$slug){

        if($request->ajax() && $request->has('draw')){
            return $this->itemsDataTable($request,$slug);
        }
        $pub = $this->publicationService->findBySlug($slug);

        return view('dashboard.hru.publication.edit')->with([
            'publication' => $pub,
        ]);
    }

    public function update(Request $request,$slug){
        if($request->has('action') && $request->ajax() && $request->action == 'finalize'){
            $publication = $this->publicationService->findBySlug($slug);
            $publication->is_final = 1;
            if($publication->update()){
                return $publication->only('slug');
            }
        }
        abort(503,'Error updating publication');
    }



    /*ITEMS*/
    private function itemsDataTable(Request $request, $slug){
        $items = PublicationDetails::query()
            ->with(['publication'])
            ->withCount('applicants')
            ->where('publication_slug','=',$slug);
        return DataTables::of($items)
            ->addColumn('action',function($data){
                if($data->publication->is_final != 1){
                    return view('dashboard.hru.publication.items.dtActions')->with([
                        'data' => $data,
                    ]);
                }else{
                    if($data->applicants_count > 0){
                        return view('dashboard.hru.publication.items.dtActionsFinal')->with([
                            'data' => $data,
                        ]);
                    }else{
                        return  '<span class="text-danger">No applicant</span>';
                    }
                }
            })
            ->editColumn('monthly_salary',function($data){
                return number_format($data->monthly_salary,2);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }
    public function addItem(Request $request,$publicationSlug){
        $plantilla = $this->plantillaService->findByItemNo($request->item_no);
        /*check for duplicates in publication*/
        $p = PublicationDetails::query()
            ->where('item_no','=',$request->item_no)
            ->where('publication_slug','=',$publicationSlug)
            ->count('id');
        if($p > 0){
            abort(503,'Position already exists in this publication');
        }
        $publicationDetail = new PublicationDetails();
        $publicationDetail->slug = Str::random();
        $publicationDetail->item_no = $plantilla->item_no;
        $publicationDetail->salary_grade = $plantilla->job_grade;
        $publicationDetail->position = $plantilla->position;
        $publicationDetail->monthly_salary = $plantilla->actual_salary_gcg;
        $publicationDetail->publication_slug = $publicationSlug;
        $publicationDetail->qs_education = $plantilla->qs_education;
        $publicationDetail->qs_training = $plantilla->qs_training;
        $publicationDetail->qs_experience = $plantilla->qs_experience;
        $publicationDetail->qs_eligibility = $plantilla->qs_eligibility;
        $publicationDetail->qs_competency = $plantilla->qs_competency;
        $publicationDetail->place_of_assignment = $plantilla->place_of_assignment;
        if($publicationDetail->save()){
            return $publicationDetail->only('slug');
        }
        abort(503,'An error occurred while adding an item');
    }
    public function destroyItem($itemSlug){
        $p = PublicationDetails::query()->where('slug','=',$itemSlug)->first();
        if(!empty($p)){
            if($p->delete()){
                return 1;
            }
        }
        abort(503,'Error deleting item.');
    }
    public function printItem($slug){

        $item = PublicationDetails::query()->with([
            'publication',
            'applicants' => function($q){
                return $q->finalized();
            },
            'applicants.educationalBackground' => function($q){
                return $q->selected();
            },
            'applicants.eligibilities' => function($q){
                return $q->selected();
            },
            'applicants.workExperiences' => function($q){
                return $q->selected();
            },
            'applicants.trainings' => function($q){
                return $q->selected();
            },
        ])
        ->where('slug','=',$slug)
        ->first();
        return view('printables.hru.items.print')->with([
            'item' => $item,
        ]);
    }

    public function print($slug){
        $publication = $this->publicationService->findBySlug($slug);
        return view('printables.hru.publication.publication_summary')->with([
            'publication' => $publication,
        ]);
    }
}