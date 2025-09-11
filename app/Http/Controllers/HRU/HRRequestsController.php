<?php

namespace App\Http\Controllers\HRU;

use App\Events\HrRequest\NewRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\HRRequestsFromRequest;
use App\Models\HRU\HRRequests;
use App\Swep\Helpers\Helper;
use App\Swep\Services\HRU\HRRequestsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class HRRequestsController extends Controller
{
    public function __construct(
        protected HRRequestsService $HRRequestsService,
    )
    {
    }

    public function create()
    {
        return view('_hru.hr-requests.create');
    }

    public function store(HRRequestsFromRequest $request)
    {
        $hrRequest = new HRRequests();
        $hrRequest->slug = Str::uuid();
        $hrRequest->tracking_no = $this->HRRequestsService->newTrackingNo();
        $hrRequest->employee_slug = Auth::user()->employee->slug;
        $hrRequest->employee_full = Auth::user()->employee->full['LFEMi'];
        $hrRequest->document = $request->document;
        $hrRequest->purpose = $request->purpose;
        $hrRequest->details = $request->details;
        $hrRequest->status = 'REQUEST SUBMITTED';
        if ($hrRequest->save()){
            event(new NewRequest($hrRequest));
            return $hrRequest->only('slug','tracking_no');
        }
        abort(503,'Error making a request.');
    }

    public function index(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $hrRequests = HRRequests::query()
                ->with([
                    'employee',
                ]);
            return DataTables::of($hrRequests)
                ->editColumn('created_at',function($data){
                    return Carbon::parse($data->created_at)->format('M d, Y | h:i A');
                })
                ->addColumn('action',function($data){
                    return view('_hru.hr-requests.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('tracking_no',function ($data){
                    return '<code style="font-size:15px">'.$data->tracking_no.'</code>';
                })
                ->editColumn('document',function ($data){
                    return view('_hru.hr-requests.dtDocument')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('status',function ($data){
                    return view('_hru.hr-requests.dtStatus')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.hr-requests.index');
    }

    public function myIndex(Request $request)
    {
        if($request->ajax() && $request->has('draw')){
            $hrRequests = HRRequests::query()
                ->with([
                    'employee',
                ])
                ->my();
            return DataTables::of($hrRequests)
                ->editColumn('created_at',function($data){
                    return Carbon::parse($data->created_at)->format('M d, Y | h:i A');
                })
                ->addColumn('action',function($data){
                    return view('_hru.hr-requests.my-dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('tracking_no',function ($data){
                    return '<code style="font-size:15px">'.$data->tracking_no.'</code>';
                })
                ->editColumn('document',function ($data){
                    return view('_hru.hr-requests.dtDocument')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('status',function ($data){
                    return view('_hru.hr-requests.dtStatus')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.hr-requests.my-index');
    }

    public function show()
    {

    }
    public function createDocument($slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        return view('_hru.hr-requests.create-document')->with([
            'hrRequest' => $hrRequest,
            'document_fields' => $hrRequest->document_fields,
        ]);

    }
    public function saveCreatedDocument($slug,Request $request)
    {

        $hrRequest = HRRequests::query()->findOrFail($slug);
        $request->validate([
            'memo_code' => 'required',
            'date' => 'required',
        ]);
        switch ($hrRequest->document){

            case 'Certificate of Employment and Compensation':
                //Sanitize Values
                $request->merge([
                    "monthly_basic" => Helper::sanitizeAutonum($request->monthly_basic, true),
                    "pera" => Helper::sanitizeAutonum($request->pera, true),
                    "ra" => Helper::sanitizeAutonum($request->ra, true),
                    "ta" => Helper::sanitizeAutonum($request->ta, true)
                ]);
                if(!empty($request->other_incentives)){
                    $toMerge = [];
                    foreach ($request->other_incentives as $code => $other_incentive){
                        $toMerge[$code] = Helper::sanitizeAutonum($other_incentive,true);
                    }
                    $request->merge(['other_incentives'=> $toMerge]);
                }
                break;
            case 'Certificate of Engagement as COS':
            case 'Certificate of Engagement as COS with Compensation':
            case 'Certificate of Employment':
                $request->validate([
                    'first_paragraph' => 'required',
                    'purpose_paragraph' => 'required',
                    'signatory_name' => 'required',
                    'signatory_position' => 'required',
                ]);
                break;
            case 'Letter of Introduction':
                break;
        }

        $hrRequest->status = 'ON PROCESS';
        $hrRequest->document_fields = $request->all();

        if($hrRequest->save()){
            return [
                'link' => route('dashboard.hr_requests.print',$hrRequest->slug),
            ];
        }
    }

    public function printDocument($slug,Request $request)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        switch ($hrRequest->document){
            case 'Certificate of Employment':
                return view('printables.hru.hr-requests.coe')->with([
                    'hrRequest' => $hrRequest,
                ]);
            case 'Certificate of Employment and Compensation':
                return view('printables.hru.hr-requests.coe-and-compensation')->with([
                    'hrRequest' => $hrRequest,
                ]);
            case 'Certificate of Engagement as COS':
                return view('printables.hru.hr-requests.coe-cos')->with([
                    'hrRequest' => $hrRequest,
                ]);
            case 'Certificate of Engagement as COS with Compensation':
                return view('printables.hru.hr-requests.coe-and-compensation-cos')->with([
                    'hrRequest' => $hrRequest,
                ]);
            case 'Letter of Introduction':
                return view('printables.hru.hr-requests.letter-of-introduction')->with([
                    'hrRequest' => $hrRequest,
                ]);
            case 'Certificate of Assumption (COS)':
                return view('printables.hru.hr-requests.certificate-of-assumption-cos')->with([
                    'hrRequest' => $hrRequest,
                ]);
            default:
                abort(504,'Option not defined in switch case statement');
        }
    }

    public function printRequest($slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        return view('printables.hru.hr-requests.request-form')->with([
            'hrRequest' => $hrRequest,
        ]);
    }

    public function edit($slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        return view('_hru.hr-requests.edit')->with([
            'hrRequest' => $hrRequest,
        ]);
    }
    public function update(Request $request, $slug)
    {
        $request->validate([
            'status' => 'required',
        ]);
        $hrRequest = HRRequests::query()->findOrFail($slug);
        $hrRequest->status = $request->status;
        if($hrRequest->update()){
            return $hrRequest->only('slug');
        }
        abort(503,'Error updating status.');
    }

    public function showTimeline($slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        return view('_hru.hr-requests.show-timeline')->with([
            'hrRequest' => $hrRequest,
        ]);
    }
}