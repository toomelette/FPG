<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\SubsidiaryAccountsFormRequest;
use App\Models\FG\ChartOfAccounts;
use App\Models\FG\Clients;
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
            DB::transaction(function () use ($account, $request){
                $account->save();
                if($request->has('create_account')){
                    $clientAccountCode = $request->account_code;
                    $clientName = $request->account_title;
                    $client = Clients::query()->where('account_no','=',$clientAccountCode)->first();
                    if(!empty($client)){
                        abort(503,'Client '.$request->account_code.' already exists.');
                    }else{
                        $newClient = new Clients();
                        $newClient->uuid = \Str::uuid();
                        $newClient->account_no = $clientAccountCode;
                        $newClient->name = $clientName;
                        $newClient->address = $request->account_address;
                        $newClient->contact_no = $request->contact_no;
                        $newClient->contact_person = $request->contact_person;
                        $newClient->save();
                    }
                }
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
            DB::transaction(function () use ($account,$request){
                $account->save();

                if($request->has('create_account')){
                    $clientAccountCode = $account->account_code;
                    $clientName = $account->account_title;
                    $client = Clients::query()->where('account_no','=',$clientAccountCode)->first();
                    if(!empty($client)){
                        abort(503,'Client '.$request->account_code.' already exists.');
                    }else{
                        $newClient = new Clients();
                        $newClient->uuid = \Str::uuid();
                        $newClient->account_no = $clientAccountCode;
                        $newClient->name = $clientName;
                        $newClient->address = $request->account_address;
                        $newClient->contact_no = $request->contact_no;
                        $newClient->contact_person = $request->contact_person;
                        $newClient->save();
                    }
                }
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
