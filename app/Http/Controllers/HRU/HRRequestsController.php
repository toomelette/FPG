<?php

namespace App\Http\Controllers\HRU;

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
        if ($hrRequest->save()){
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
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_hru.hr-requests.index');
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

        switch ($hrRequest->document){
            case 'Certificate of Employment':
                $request->validate([
                    'first_paragraph' => 'required',
                    'purpose_paragraph' => 'required',
                    'memo_code' => 'required',
                    'date' => 'required',
                    'signatory_name' => 'required',
                    'signatory_position' => 'required',
                ]);
                break;
            case 'Certificate of Employment and Compensation':
                $request->validate([
                    'memo_code' => 'required',
                    'date' => 'required',
                    'signatory_name' => 'required',
                    'signatory_position' => 'required',
                ]);
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
        }


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
                if(Helper::isPermanent($hrRequest->employee_slug)){
                    return view('printables.hru.hr-requests.coe-and-compensation')->with([
                        'hrRequest' => $hrRequest,
                    ]);
                }else{
                    return  view('printables.hru.hr-requests.coe-and-compensation-cos')->with([
                        'hrRequest' => $hrRequest,
                    ]);
                }
            default:
                abort(504,'Option not defined in switch case statement');
        }
    }
}