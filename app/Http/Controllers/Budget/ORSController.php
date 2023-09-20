<?php


namespace App\Http\Controllers\Budget;


use App\Exports\BudgetProposalMonitoringExporter;
use App\Exports\StatementOfBudgeAndActualExpendituresExporter;
use App\Exports\SubsidiaryLedgerExporter;
use App\Exports\SummaryOfOrsExporter;
use App\Exports\SummaryOfOrsWithProjectsExporter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Budget\ORSFormRequest;
use App\Models\Budget\ChartOfAccounts;
use App\Models\Budget\ORS;
use App\Models\Budget\ORSAccountEntries;
use App\Models\Budget\ORSProjectsApplied;
use App\Models\PPU\Pap;
use App\Models\PPU\RCDesc;
use App\Swep\Helpers\Arrays;
use App\Swep\Helpers\Get;
use App\Swep\Helpers\Helper;
use App\Swep\Services\Budget\ORSReportsService;
use App\Swep\Services\Budget\ORSService;
use App\Swep\Traits\Budget\PapCodeMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ORSController extends Controller
{
    use PapCodeMonitoring;
    public function __construct(
        protected ORSService $orsService,
        protected ORSReportsService $orsReportsService,
    )
    {


    }

    public function export_from_view(){
        return Excel::download(
            new StatementOfBudgeAndActualExpendituresExporter(),
            'test.xlsx',
        );
    }

    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            return $this->dataTable($request);
        }
        return view('dashboard.budget.ors.index');
    }


    public function dataTable(Request $request){
        $ors = ORS::query()
            ->with(['accountEntries.chartOfAccount','projectsApplied.pap']);
        if($request->has('funds') && $request->funds != ''){
            $ors = $ors->where('funds','=',$request->funds);
        }
        if($request->has('ref_book') && $request->ref_book != ''){
            $ors = $ors->where('ref_book','=',$request->ref_book);
        }

        if($request->has('payee') && $request->payee != ''){
            $ors = $ors->where('payee','=',$request->payee);
        }

        if($request->has('applied_projects') && ($request->applied_projects != 'NULL' && $request->applied_projects != '')){
            $ors = $ors->whereHas('projectsApplied',function ($q) use($request){
                return $q->where('pap_code','=',$request->applied_projects);
            });
        }

        if($request->has('account_entry') && ($request->account_entry != 'NULL' && $request->account_entry != '')){
            $ors = $ors->whereHas('accountEntries',function ($q) use($request){
                return $q->where('account_code','=',$request->account_entry);
            });
        }

        return DataTables::of($ors)
            ->addColumn('action',function($data){
                return view('dashboard.budget.ors.dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('details',function($data) use($request){
                return view('dashboard.budget.ors.dtDetails')->with([
                    'data' => $data,
                    'request' => $request,
                ]);
            })
            ->editColumn('amount',function($data){
                return number_format($data->amount,2);
            })
            ->editColumn('ors_date',function($data){
                return $data->ors_date != null ? Carbon::parse($data->ors_date)->format('M. d, Y') : '';
            })
            ->editColumn('payee',function($data){
                return view('dashboard.budget.ors.dtPayee')->with([
                    'data' => $data,
                ]);
            })
            ->addColumn('account_entries',function($data) use ($request){
                return view('dashboard.budget.ors.dtAccountEntries')->with([
                    'data' => $data,
                    'request' => $request,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }

    public function create(){
        return view('dashboard.budget.ors.create');
    }

    public function store(ORSFormRequest $request){
        $project_id = Auth::user()->project_id;
        $ors = new ORS;
        $ors->slug = Str::random();
//        $ors->ors_no = $this->orsService->newOrsNumber($request->funds)['newOrsNumber'];
//        $ors->base_ors_no = $this->orsService->newOrsNumber($request->funds)['baseOrsNumber'];
        $ors->ors_no = $request->ors_no;
        $ors->base_ors_no = substr($request->ors_no, strrpos($request->ors_no, '-' )+1);
        $ors->ors_date = $request->ors_date;
        $ors->funds = $request->funds;
        $ors->payee = $request->payee;
        $ors->office = $request->office;
        $ors->address = $request->address;
        $ors->ref_book = $request->ref_book;
        $ors->ref_doc = $request->ref_doc;
        $ors->amount = Helper::sanitizeAutonum($request->amount);
        $ors->particulars = $request->particulars;
        $ors->certified_by = $request->certified_by;
        $ors->certified_by_position = $request->certified_by_position;
        $ors->certified_budget_by = $request->certified_budget_by;
        $ors->certified_budget_by_position = $request->certified_budget_by_position;

        $rcs = Arrays::respCodeList();
        if(!empty($request->account_entries)){
            $arr = [];
            $ct = 0;
            foreach ($request->account_entries as $account_entry){
                array_push($arr,[
                    'project_id' => $project_id,
                    'slug' => Str::random(),
                    'ors_slug' => $ors->slug,
                    'type' => $account_entry['type'],
                    'seq_no' => $ct++,
                    'resp_center' => $account_entry['resp_center'],
                    'dept' => $rcs[$account_entry['resp_center']]['dept_alias'],
                    'unit' => $rcs[$account_entry['resp_center']]['sec'] == '' ? $rcs[$account_entry['resp_center']]['div'] : $rcs[$account_entry['resp_center']]['sec'],
                    'account_code' => $account_entry['account_code'],
                    'debit' => Helper::sanitizeAutonum($account_entry['debit']),
                    'credit' => Helper::sanitizeAutonum($account_entry['credit']),
                ]);
            }
            ORSAccountEntries::insert($arr);
        }

        if(!empty($request->applied_projects)){
            $arr = [];
            foreach ($request->applied_projects as $applied_project){
                array_push($arr,[
                    'project_id' => $project_id,
                    'slug' => Str::random(),
                    'ors_slug' => $ors->slug,
                    'pap_code' => $applied_project['pap_code'],
                    'co' => Helper::sanitizeAutonum($applied_project['co']),
                    'mooe' => Helper::sanitizeAutonum($applied_project['mooe']),
                    'total' => Helper::sanitizeAutonum($applied_project['co'] ?? 0) + Helper::sanitizeAutonum($applied_project['mooe'] ?? 0),
                ]);
            }
            ORSProjectsApplied::insert($arr);
        }
        if($ors->save()){
            return $ors->only('slug');
        }
        abort(503,'Error saving ORS');
    }

    public function print($slug, Request $request){

        if($request->has('attachment') && $request->attachment != null){
            return view('printables.ors.ors_attachment')->with([
                'ors' => $this->orsService->findBySlug($slug),
            ]);
        }
        return view('printables.ors.ors')->with([
            'ors' => $this->orsService->findBySlug($slug),
        ]);
    }

    public function edit($slug){
        return view('dashboard.budget.ors.edit')->with([
            'ors' => $this->orsService->findBySlug($slug),
        ]);
    }

    public function update(ORSFormRequest $request,$slug){
        $project_id = Auth::user()->project_id;
        $ors = $this->orsService->findBySlug($slug);
        $ors->ors_date = $request->ors_date;
        $ors->ors_no = $request->ors_no;
        $ors->funds = $request->funds;
        $ors->payee = $request->payee;
        $ors->office = $request->office;
        $ors->address = $request->address;
        $ors->ref_book = $request->ref_book;
        $ors->ref_doc = $request->ref_doc;
        $ors->amount = Helper::sanitizeAutonum($request->amount);
        $ors->particulars = $request->particulars;
        $ors->certified_by = $request->certified_by;
        $ors->certified_by_position = $request->certified_by_position;
        $ors->certified_budget_by = $request->certified_budget_by;
        $ors->certified_budget_by_position = $request->certified_budget_by_position;
        if($ors->update()){
            $rcs = Arrays::respCodeList();
            if(!empty($request->account_entries)){
                $arr = [];
                $ct = 0;
                foreach ($request->account_entries as $account_entry){
                    array_push($arr,[
                        'project_id' => $project_id,
                        'slug' => Str::random(),
                        'ors_slug' => $ors->slug,
                        'type' => $account_entry['type'],
                        'seq_no' => $ct++,
                        'resp_center' => $account_entry['resp_center'],
                        'dept' => $rcs[$account_entry['resp_center']]['dept_alias'],
                        'unit' => $rcs[$account_entry['resp_center']]['sec'] == '' ? $rcs[$account_entry['resp_center']]['div'] : $rcs[$account_entry['resp_center']]['sec'],
                        'account_code' => $account_entry['account_code'],
                        'debit' => Helper::sanitizeAutonum($account_entry['debit']),
                        'credit' => Helper::sanitizeAutonum($account_entry['credit']),
                    ]);
                }

                $ors->accountEntries()->delete();
                ORSAccountEntries::insert($arr);
            }

            if(!empty($request->applied_projects)){
                $arr = [];
                foreach ($request->applied_projects as $applied_project){
                    array_push($arr,[
                        'project_id' => $project_id,
                        'slug' => Str::random(),
                        'ors_slug' => $ors->slug,
                        'pap_code' => $applied_project['pap_code'],
                        'co' => Helper::sanitizeAutonum($applied_project['co']),
                        'mooe' => Helper::sanitizeAutonum($applied_project['mooe']),
                        'total' => Helper::sanitizeAutonum($applied_project['co'] ?? 0) + Helper::sanitizeAutonum($applied_project['mooe'] ?? 0),
                    ]);
                }
                $ors->projectsApplied()->delete();
                ORSProjectsApplied::insert($arr);
            }
            return $ors->only('slug');
        }
    }

    public function show($slug){
        $ors = $this->orsService->findBySlug($slug);
        return view('dashboard.budget.ors.show')->with([
            'ors' => $ors,
        ]);
    }

    public function reports(){
        return view('dashboard.budget.ors.reports');
    }

    public function reportGenerate($type){
        $request = Request::capture();

        switch ($type){
            case 'summary_of_ors':
                return $this->orsReportsService->summaryOfORS($request);
            case 'summary_of_ors_with_projects':
                return  $this->orsReportsService->summaryOfORSWithProjects($request);
            case 'quarterly_budget_monitoring':
                return  $this->orsReportsService->quarterlyBudgetMonitoring($request);
            case 'statement_of_budget_and_actual_expenditures':
                return  $this->orsReportsService->statementOfBudgetAndActualExpenditures($request);
            case 'subsidiary_ledger':
                return  $this->orsReportsService->subsidiaryLedger($request);
            case 'budget_proposal_monitoring':
                return  $this->orsReportsService->budgetProposalMonitoring($request);
            case 'subsidiary_ledger_2':
                return  $this->orsReportsService->subsidiaryLedger2($request);
            case 'pap_code_monitoring':
                return  $this->papCodeMonitoring($request);

            default:
                return 'default';
                break;
        }
    }



    public function destroy($slug){
        $ors = $this->orsService->findBySlug($slug);
        if($ors->delete()){
            $ors->accountEntries()->delete();
            $ors->projectsApplied()->delete();
            return 1;
        }
        abort(503,'Error deleting ORS.');
    }
}