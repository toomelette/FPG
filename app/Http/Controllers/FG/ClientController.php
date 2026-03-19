<?php

namespace App\Http\Controllers\FG;

use App\Http\Controllers\Controller;
use App\Http\Requests\FG\ClientFormRequest;
use App\Models\FG\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ClientController extends Controller
{
    private $folder;
    public function __construct()
    {
        $this->folder = 'fg.clients.';
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $clients = Clients::query();
            return DataTables::of($clients)
                ->addColumn('action',function ($data){
                    return view($this->folder.'dt-actions')->with(['data' => $data]);
                })
                ->escapeColumns([''])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'index');
    }

    public function store(ClientFormRequest $request)
    {
        $client = new Clients();
        $client->uuid = Str::uuid();
        $client->account_no = $request->account_no;
        $client->name = $request->name;
        $client->address = $request->address;
        $client->contact_person = $request->contact_person;
        $client->contact_no = $request->contact_no;
        if($client->save()){
            return $client->only('uuid');
        }
        abort(503);
    }

    public function edit($uuid)
    {
        $client = Clients::query()->findOrFail($uuid);
        return view($this->folder.'edit')->with(['client' => $client]);
    }

    public function update(ClientFormRequest $request,$uuid)
    {
        $client = Clients::query()->findOrFail($uuid);
        $client->account_no = $request->account_no;
        $client->name = $request->name;
        $client->address = $request->address;
        $client->contact_person = $request->contact_person;
        $client->contact_no = $request->contact_no;
        if($client->update()){
            return $client->only('uuid');
        }
        abort(503);
    }

    public function destroy($uuid)
    {
        $client = Clients::query()->findOrFail($uuid);
        if($client->delete()){
            return 1;
        }
        abort(503);
    }

    public function show($uuid, Request $request)
    {
        $client = Clients::query()
            ->findOrFail($uuid);

        if($request->ajax() && $request->has('draw')){
            $client = $client->load(['invoices']);
            return DataTables::of($client->invoices)
                ->addColumn('action',function ($data){
                    return view('fg.sales-invoice.dt-actions')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('uuid')
                ->toJson();
        }
        return view($this->folder.'show')->with([
            'client' => $client,
        ]);
    }
}