<?php

namespace App\Http\Controllers\RECORDS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Records\DocumentRequestFormRequest;
use App\Models\Document;
use App\Models\RECORDS\DocumentRequests;
use App\Swep\Services\Records\DocumentRequestService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class DocumentRequestsController extends Controller
{
    public function __construct(public DocumentRequestService $documentRequestsService)
    {
    }

    public function create()
    {

    }
    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $documentRequests = DocumentRequests::query();
            return  $this->datatable($request,$documentRequests);
        }
        return view('_records.document-requests.index');
    }

    public function my(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $documentRequests = DocumentRequests::query()
                ->my();
            return  $this->datatable($request,$documentRequests);
        }
        return view('_records.document-requests.my');
    }

    private function datatable(Request $request,$documentRequests)
    {
        return DataTables::of($documentRequests)
            ->addColumn('action',function($data){
                return view('_records.document-requests.dtActions')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('requested_records',function($data){
                return view('_records.document-requests.dtActions-requested-records')->with([
                    'data' => $data,
                ]);
            })
            ->editColumn('requested_at',function ($data){
                return $data->created_at->format('M. d, Y | h:i A');
            })
            ->editColumn('requested_by',function ($data){
                return view('_records.document-requests.dtActions-requested-by')->with([
                    'data' => $data,
                ]);
            })
            ->escapeColumns([])
            ->setRowId('slug')
            ->toJson();
    }

    public function store(DocumentRequestFormRequest $request)
    {
        
        $docRequest = new DocumentRequests();
        $docRequest->slug = Str::random();
        $docRequest->request_no = $this->documentRequestsService->newRequestNo();
        $docRequest->requesting_party = $request->requesting_party;
        $docRequest->requesting_party_specify = $request->requesting_party_specify ?? null;
        $docRequest->requested_records = $request->requested_records;
        $docRequest->contact_details = $request->contact_details;
        $docRequest->purpose = $request->purpose;
        $docRequest->purpose_specify = $request->purpose_specify ?? null;
        $docRequest->requested_by = $request->requested_by;
        $docRequest->requested_by_position = $request->requested_by_position;
        $docRequest->requested_at = Carbon::now();
        if($docRequest->save()){
            return $docRequest->only('slug');
        }
        abort(503,'Error creating request');
    }

    public function edit($slug)
    {
        $this->documentRequestsService->authorize($slug,'edit');
        $documentRequest = DocumentRequests::query()->findOrFail($slug);
        return view('_records.document-requests.edit')->with([
            'documentRequest' => $documentRequest,
        ]);
    }

    public function update(DocumentRequestFormRequest $request,$slug)
    {
        $this->documentRequestsService->authorize($slug,'update');
        $docRequest = DocumentRequests::query()->findOrFail($slug);
        $docRequest->requesting_party = $request->requesting_party;
        $docRequest->requesting_party_specify = ($request->requesting_party == 'Other Government Agencies') ? ($request->requesting_party_specify ?? null) : null;
        $docRequest->requested_records = $request->requested_records;
        $docRequest->contact_details = $request->contact_details;
        $docRequest->purpose = $request->purpose;
        $docRequest->purpose_specify = ($request->purpose == 'Others') ? ($request->purpose_specify ?? null) : null;
        $docRequest->requested_by = $request->requested_by;
        $docRequest->requested_by_position = $request->requested_by_position;
        if($docRequest->save()){
            return $docRequest->only('slug');
        }
        abort(503,'Error updating request');
    }

    public function print($slug)
    {
        $this->documentRequestsService->authorize($slug,'print');

        $documentRequest = DocumentRequests::query()->findOrFail($slug);
        return view('printables.records.document-requests.document-request')->with([
            'documentRequest' => $documentRequest,
        ]);
    }
    public function destroy($slug)
    {
        $this->documentRequestsService->authorize($slug,'destroy');
        $documentRequest = DocumentRequests::query()->findOrFail($slug);
        if($documentRequest->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }

}