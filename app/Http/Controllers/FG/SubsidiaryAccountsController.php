<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\SubsidiaryAccountsFormRequest;
use App\Models\FG\ChartOfAccounts;
use App\Models\FG\SubsidiaryAccounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SubsidiaryAccountsController extends Controller
{
    public function __construct(
        private $folder = 'fg-accounting.subsidiary-accounts.',
    )
    {
    }

    public function index(Request $request,$id)
    {
        $account = ChartOfAccounts::query()
            ->findOrFail($id);
        if($request->ajax() && $request->has('draw')){
            $account->load(['subsidiaries']);
            $subsidiaries = $account->subsidiaries;
            return DataTables::of($subsidiaries)
                ->addColumn('action',fn($data) => view($this->folder.'dt-actions')->with(['data' => $data]))
                ->escapeColumns([])
                ->setRowId('id')
                ->toJson();
        }
        return view($this->folder.'index')->with([
            'account' => $account,
        ]);
    }

    public function store(SubsidiaryAccountsFormRequest $request,$parentAccountCode)
    {
        $account = new SubsidiaryAccounts();
        $account->parent_account_code = $parentAccountCode;
        $account->account_code = $request->account_code;
        $account->account_title = $request->account_title;
        $account->account_address = $request->account_address;
        $account->contact_person = $request->contact_person;
        $account->contact_no = $request->contact_no;
        try {
            DB::transaction(function () use ($account){
                $account->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $account->only('id');
    }

    public function edit($id)
    {
        $account = SubsidiaryAccounts::query()->findOrFail($id);
        return view($this->folder.'edit')->with([
            'account' => $account,
        ]);
    }

    public function update(SubsidiaryAccountsFormRequest $request,$id)
    {
        $account = SubsidiaryAccounts::query()->findOrFail($id);
        $account->account_title = $request->account_title;
        $account->account_address = $request->account_address;
        $account->contact_person = $request->contact_person;
        $account->contact_no = $request->contact_no;
        try {
            DB::transaction(function () use ($account){
                $account->save();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return $account->only('id');
    }

    public function destroy($id)
    {
        $account = SubsidiaryAccounts::query()->findOrFail($id);
        try {
            DB::transaction(function () use ($account){
                $account->delete();
            });
        }catch (\Exception $exception){
            abort(503,$exception->getMessage());
        }
        return 1;
    }
}
