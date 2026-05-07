<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ChartOfAccountsFormRequest;
use App\Models\FG\ChartOfAccounts;
use App\Swep\Helpers\Arrays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ChartOfAccountsController extends Controller
{
    public function __construct(
        private $folder = 'fg-accounting.chart-of-accounts.',
    )
    {
    }

    public function index(Request $request)
    {
        if($request->ajax() &&  $request->has('draw')){
            $accounts = ChartOfAccounts::query()
                ->withCount('subsidiaries');
            return DataTables::of($accounts)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->editColumn('nature_id',fn($data) => Arrays::accountNatures()[$data->nature_id] ?? '')
                ->escapeColumns([])
                ->setRowId('id')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(ChartOfAccountsFormRequest $request)
    {
        $account = new ChartOfAccounts();
        $account->account_code = $request->account_code;
        $account->account_title = $request->account_title;
        $account->nature_id = $request->nature_id;
        try {
            DB::transaction(function () use ($account){
                $account->save();
            });
        }catch (\Exception $exception){
            abort(503, $exception->getMessage());
        }
        return $account->only('id');
    }

    public function edit($id)
    {
        $account = ChartOfAccounts::query()->findOrFail($id);
        return view($this->folder.'edit')->with([
            'account' => $account,
        ]);
    }

    public function update(ChartOfAccountsFormRequest $request,$id)
    {
        $account = ChartOfAccounts::query()->findOrFail($id);
        $account->account_title = $request->account_title;
        $account->nature_id = $request->nature_id;
        try {
            DB::transaction(function () use ($account){
                $account->save();
            });
        }catch (\Exception $exception){
            abort(503, $exception->getMessage());
        }
        return $account->only('id');
    }

    public function destroy($id)
    {
        $account = ChartOfAccounts::query()->findOrFail($id);

        try {
            DB::transaction(function () use ($account){
                $account->delete();
            });
        }catch (\Exception $exception){
            abort(503, $exception->getMessage());
        }
        return 1;
    }
}
