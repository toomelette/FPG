<?php


namespace App\Http\Controllers\Budget;


use App\Http\Controllers\Controller;
use App\Http\Requests\Budget\PapFormRequest;
use App\Http\Requests\Budget\RealignmentFormRequest;
use App\Models\Budget\ORS;
use App\Models\Budget\ORSProjectsApplied;
use App\Models\Budget\PapAdjustments;
use App\Models\PPBTMS\Transactions;
use App\Models\PPU\Pap;
use App\Models\PPU\PPURespCodes;
use App\Models\Project;
use App\Swep\Helpers\Helper;
use App\Swep\Services\Budget\PapService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class ProjectsController extends Controller
{
    protected $papService;
    public function __construct(PapService $papService)
    {
        $this->papService = $papService;
    }

    public function index(Request $request, Builder $builder){

        $html = $builder->parameters([
            'buttons' => ['excel']
        ]);
        if(request()->ajax() && request()->has('draw')){
            return $this->dataTable($request);
        }
        return view('dashboard.budget.projects.index', compact('html'))->with([
            'papCodes' => \App\Swep\Helpers\Arrays::papCodes(),
        ]);
    }


    public function dataTable(Request $request){
        $paps = Pap::query()->with([
            'responsibilityCenter',
            'orsAppliedProjects',
        ])
        ->withSum([
            'procurementsPr' => function($q){
                return $q->receivedAndNotCancelled();
            }
        ],'abc')
        ->withSum([
            'procurementsJr' => function($q){
                return $q->receivedAndNotCancelled();
            }
        ],'abc');
        if($request->has('resp_center') && $request->resp_center != ''){
            $paps = $paps->where('resp_center','=',$request->resp_center);
        }
        $dt =  DataTables::of($paps);
        $dt = $dt->addColumn('action',function ($data){
                return view('dashboard.budget.projects.dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('procurements',function($data){
                return view('dashboard.budget.projects.dtProcurements')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('details',function ($data){
                return 'd';
            })
            ->editColumn('pap_title',function ($data){
                if($data->pap_desc != ''){
                    return $data->pap_title. '<div class="table-subdetail">'.$data->pap_desc.'</div>';
                }
                return $data->pap_title;
            })
            ->editColumn('resp_center', function ($data) {
                return $data->responsibilityCenter->desc ?? '';
            })
            ->editColumn('co',function($data){
                return view('dashboard.budget.projects.dtCo')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('mooe',function($data){
                return view('dashboard.budget.projects.dtMooe')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('totalBudget',function($data){
                return '<b>'.number_format($data->ps + $data->co + $data->mooe,2).'</b>';
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->make(true);
        return $dt;
    }

    public function store(PapFormRequest $request){
        $papExist = PAP::query()->where('pap_code', $request->pap_code)->first();
        if($papExist != null){
            abort(503, 'PAP Code already exists.');
        }
        $pap = new PAP;
        $pap->slug = Str::random();
        $pap->year = $request->year;
        $pap->resp_center = $request->resp_center;
        $pap->base_pap_code = 1;
        $pap->pap_code = $request->pap_code;
        //$pap->pap_code = $this->papService->newPapCode($request->year,$request->resp_center);
        $pap->pap_title = $request->pap_title;
        $pap->pap_desc = $request->pap_desc;
        $pap->ps = Helper::sanitizeAutonum($request->ps);
        $pap->co = Helper::sanitizeAutonum($request->co);
        $pap->mooe = Helper::sanitizeAutonum($request->mooe);
        $pap->pcent_share = $request->pcent_share;
        $pap->type = $request->type ?? 'final';
        $pap->status = $request->status ?? 'active';
        $pap->budget_type = $request->budget_type;
        if($pap->save()){
            return $pap->only('slug');
        }

        abort('500','Error saving data');
    }

    public function edit($slug){
        return view('dashboard.budget.projects.edit')->with([
            'pap' => $this->papService->findBySlug($slug),
        ]);
    }

    public function update(PAPFormRequest $request, $slug){
        $pap = $this->papService->findBySlug($slug);
        $pap->year = $request->year;
        $pap->resp_center = $request->resp_center;
        $pap->base_pap_code = 1;
        //$pap->pap_code = $request->pap_code;
        //$pap->pap_code = $this->papService->newPapCode($request->year,$request->resp_center);
        $pap->pap_title = $request->pap_title;
        $pap->pap_desc = $request->pap_desc;
        $pap->ps = Helper::sanitizeAutonum($request->ps);
        $pap->co = Helper::sanitizeAutonum($request->co);
        $pap->mooe = Helper::sanitizeAutonum($request->mooe);
        $pap->pcent_share = $request->pcent_share;
        $pap->type = $request->type ?? 'final';
        $pap->status = $request->status ?? 'active';
        $pap->budget_type = $request->budget_type;
        if($pap->save()){
            return $pap->only('slug');
        }

        abort('500','Error saving data');
    }
    public function destroy($slug){
        $pap = $this->papService->findBySlug($slug);
        if($pap->delete()){
            return 1;
        }
        abort(503,'Error deleting PAP');
    }

    public function show($slug, Request $request, Builder $builder){


        if($request->has('draw') && $request->table == 'ors'){
            return $this->orsDatatable($slug, $request);
        }

        if($request->has('draw') && $request->table == 'procurements'){
            return $this->procurementsDatatable($slug, $request, $builder);
        }

        $pap = $this->papService->findBySlug($slug);
        $pap_code = $pap->pap_code;


        return view('dashboard.budget.projects.show')->with([
            'pap' => $pap,
        ]);
    }

    private function orsDatatable($slug, Request $request){
        $pap = $this->papService->findBySlug($slug);
        $pap_code = $pap->pap_code;
        $ors = ORS::query()->with(['projectsApplied','accountEntries'])
            ->whereIn('slug',function ($q) use ($pap_code){
                $q->select('ors_slug')
                    ->from(with(new ORSProjectsApplied())->getTable())
                    ->where('pap_code','=',$pap_code);
            });

        $sumCo = ORSProjectsApplied::query()->where('pap_code','=',$pap_code)->sum('co');
        $sumMooe = ORSProjectsApplied::query()->where('pap_code','=',$pap_code)->sum('mooe');
        if($request->has('funds') && $request->funds != ''){
            $ors = $ors->where('funds','=',$request->funds);
        }
        if($request->has('ref_book') && $request->ref_book != ''){
            $ors = $ors->where('ref_book','=',$request->ref_book);
        }

        if($request->has('payee') && $request->payee != ''){
            $ors = $ors->where('payee','=',$request->payee);
        }

        if($request->has('account_entry') && ($request->account_entry != 'NULL' && $request->account_entry != '')){

            $ors = $ors->whereHas('accountEntries',function ($q) use($request){
                return $q->where('account_code','=',$request->account_entry);
            });
        }

        $request->applied_projects = $pap->pap_code;
        return DataTables::of($ors)
            ->addColumn('action',function($data) use ($pap_code){
                return '<a href="'.route('dashboard.ors.index').'?find='.$data->ors_no.'" target="_blank" class="btn btn-sm btn-default">View ORS</>';
            })
            ->addColumn('details',function($data) use($request){
                return view('dashboard.budget.ors.dtDetails')->with([
                    'data' => $data,
                ])->with([
                    'request' => $request,
                ]);
            })
            ->addColumn('account_entries',function($data) use($request){
                return view('dashboard.budget.ors.dtAccountEntries')->with([
                    'data' => $data,
                ])->with([
                    'request' => $request,
                ]);
            })
            ->editColumn('amount',function($data){
                return number_format($data->amount,2);
            })
            ->editColumn('ors_date',function($data){
                return $data->ors_date != null ? Carbon::parse($data->ors_date)->format('M. d, Y') : '';
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->with([
                'totalCo' => number_format($sumCo,2),
                'totalMooe' => number_format($sumMooe,2),
            ])->toJson();
    }

    private function procurementsDatatable($slug, Request $request){

        $pap = $this->papService->findBySlug($slug);
        $pap_code = $pap->pap_code;
        $transactions = Transactions::query()
            ->where('pap_code','=',$pap_code)
            ->where(function ($q){
                $q->where('ref_book','=','PR')
                    ->orWhere('ref_book','=','JR');
            })
            ->where('is_locked','=',1)
            ->where('cancelled_at','=',null);


        return DataTables::of($transactions)
            ->addColumn('action',function($data) use ($pap_code){
                return 1;
                return '<a href="'.route('dashboard.ors.index').'?find='.$data->ors_no.'" target="_blank" class="btn btn-sm btn-default">View ORS</>';
            })
            ->editColumn('abc',function($data){
                return number_format($data->abc,2);
            })
            ->editColumn('ors_date',function($data){
                return $data->ors_date != null ? Carbon::parse($data->ors_date)->format('M. d, Y') : '';
            })
            ->editColumn('ref_no',function($data){
                return '<a href="http://119.93.145.202:8006/dashboard/'.strtolower($data->ref_book).'?find='.$data->ref_no.'" target="_blank">'.$data->ref_no.'</a>';
            })
            ->editColumn('date',function($data){
                return Helper::dateFormat($data->date,'M. d, Y');
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }

    public function realigmentAndSupplemental($projectSlug){
        $project = Pap::query()->where('slug','=',$projectSlug)->first();
        $project ?? abort(503,'Project not found.');
        return view('dashboard.budget.projects.realignment_and_supplemental')->with([
            'project' => $project,
        ]);
    }

    public function adjustment($type,RealignmentFormRequest $request){

        if($type != 'realignment' && $type != 'supplemental'){
            abort(503,'Invalid budget adjustment type.');
        }

        $papAdj = new PapAdjustments();
        $papAdj->slug = Str::random();
        $papAdj->{strtolower($request->type)} = Helper::sanitizeAutonum($request->amount);
        $papAdj->type = strtoupper($type);
        $papAdj->source_slug = $request->source_pap;
        $papAdj->destination_slug = $request->destination_pap;
        if($papAdj->save()){
            return 1;
        }
        abort(503,'Error saving realignment');
    }
}