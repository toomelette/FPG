<?php


namespace App\Http\Controllers\Budget;


use App\Http\Controllers\Controller;
use App\Models\Budget\AnnualBudget;
use App\Models\Budget\ChartOfAccounts;
use App\Swep\Helpers\Helper;
use App\Swep\Services\Budget\AnnualBudgetService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AnnualBudgetController extends Controller
{
    protected $annualBudgetService;

    public function __construct(AnnualBudgetService $annualBudgetService)
    {
        $this->annualBudgetService = $annualBudgetService;
    }

    public function index(Request $request){
        abort(503);
        return view('dashboard.budget.moved');
        if($request->ajax() && $request->has('draw')){

            $abs = AnnualBudget::query()
                ->with(['chartOfAccount','dept']);
            if($request->has('year') && $request->year != ''){
                $abs = $abs->where('year','=',$request->year);
            }

            if($request->has('department') && $request->department != ''){
                $abs = $abs->where('department','=',$request->department);
            }
            if($request->has('account_code') && $request->account_code != ''){
                $abs = $abs->where('account_code','=',$request->account_code);
            }

            $dt = DataTables::of($abs)->addColumn('action',function($data){
                    return view('dashboard.budget.annual_budget.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('account_title',function($data){
                    return $data->chartOfAccount->account_title ?? null;
                })
                ->editColumn('department',function($data){
                    return $data->dept->descriptive_name ?? null;
                })
                ->editColumn('amount',function($data){
                    return Helper::toNumber($data->amount,2);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
            return $dt;
        }
        return view('dashboard.budget.annual_budget.index');
    }

    public function store(Request $request){
        $ab = new AnnualBudget();
        $ab->slug = Str::random();
        $ab->year = $request->year;
        $ab->department = $request->department;
        $ab->account_code = $request->account_code;
        $ab->amount = Helper::sanitizeAutonum($request->amount);
        if($ab->save()){
            return $ab->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function edit($slug){
        $ab = $this->annualBudgetService->findBySlug($slug);
        return view('dashboard.budget.annual_budget.edit')->with([
            'ab' => $ab,
        ]);
    }

    public function update(Request $request,$slug){
        $ab = $this->annualBudgetService->findBySlug($slug);
        $ab->year = $request->year;
        $ab->department = $request->department;
        $ab->account_code = $request->account_code;
        $ab->amount = Helper::sanitizeAutonum($request->amount);
        if($ab->save()){
            return $ab->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function destroy($slug){
        $ab =  $this->annualBudgetService->findBySlug($slug);
        if($ab->delete()){
            return 1;
        }
        abort(503,'Error deleting item');
    }
}