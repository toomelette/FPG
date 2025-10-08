<?php

namespace App\Http\Controllers\HRU;

use App\Events\HrRequest\NewRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\HRRequestsFromRequest;
use App\Models\HRU\HRRequests;
use App\Swep\Helpers\Get;
use App\Swep\Helpers\Helper;
use App\Swep\Services\HRU\HRRequestsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
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
        if(!empty($request->doc_file)){
            $storage = Storage::disk('hr_request_attachments');
            $fileName = $hrRequest->tracking_no.' - User.'.$request->file('doc_file')->getClientOriginalExtension();
            $store = $storage->putFileAs('UserAttachments',$request->file('doc_file'),$fileName);
            $hrRequest->user_file_path = $store;
        }
        $hrRequest->employee_slug = Auth::user()->employee->slug;
        $hrRequest->employee_full = Auth::user()->employee->full['LFEMi'];
        $hrRequest->document = $request->document;
        $hrRequest->purpose = $request->purpose;
        $hrRequest->details = $request->details;
        $hrRequest->request_file = $request->request_file ?? null;
        $hrRequest->status = 'REQUEST SUBMITTED';

        if ($hrRequest->save()){
            if(\App::environment() != 'local'){
                event(new NewRequest($hrRequest));
            }
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
                if(Request::capture()->has('pdf')){
                    return Pdf::view('printables.hru.hr-requests.coe-and-compensation-cos',[
                        'hrRequest' => $hrRequest,
                    ])

                        ->paperSize('330.2','215.9')
                        ->landscape()
                        ->margins(8,8, 15, 8)
                        ->headers(['title' => 'aaaaa'])
                        ->headerView('printables.letterhead.header')
                        ->footerView('printables.hru.payroll_preparation.footer-view')
                        ->name('Payroll Summary.pdf')
                        ->withBrowsershot(function (Browsershot $browsershot){
                            if(app()->environment('production')){
                                $browsershot->setNodeBinary(env('NODE_BINARY'))
                                    ->setNpmBinary(env('NODE_BINARY'));
                            }
                        });
                }

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

    public function edit(Request $request,$slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        if($request->has('contractOfService')){

            return $this->contractOfService($hrRequest);
        }
        return view('_hru.hr-requests.edit')->with([
            'hrRequest' => $hrRequest,
        ]);
    }
    public function contractOfService($hrRequest)
    {
        $hrRequest->load('employee.responsibilityCenter.description');
        return view('_hru.hr-requests.contract-of-service')->with([
            'hrRequest' => $hrRequest,
            'settings' => Get::setting('cos_template')->json_value,
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

    public function uploadFileForm($slug, Request $request)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        if($request->has('view')){
            if (Helper::isThisMyData($hrRequest) || Helper::checkRouteAccess('dashboard.hr_requests.file')){
                $storage = Storage::disk('hr_request_attachments');
                if ($storage->exists($hrRequest->file_path)){
                    return  $storage->response($hrRequest->file_path);
                }
                abort(404,'File does not exist.');
            }else{
                abort(403,'Unauthorized access.');
            }

        }
        return view('_hru.hr-requests.file-upload')->with([
            'hrRequest' => $hrRequest,
        ]);
    }

    public function uploadFile(Request $request,$slug)
    {
        $request->validate([
            'doc_file' => 'required|mimes:pdf',
        ]);
        $hrRequest = HRRequests::query()->findOrFail($slug);
        $fileName = $hrRequest->tracking_no.'.'.$request->file('doc_file')->getClientOriginalExtension();
        $storage = Storage::disk('hr_request_attachments');
        $store = $storage->putFileAs(null,$request->file('doc_file'),$fileName);

        if($store){
            $hrRequest->file_path = $fileName;
            $hrRequest->file_updated_at = Carbon::now();
            $hrRequest->file_user_updated = Auth::user()->user_id;
            if($hrRequest->save()){
                return $hrRequest->only('slug');
            }
        }
        abort(503,'Error uploading file.');
    }

    public function deleteFile(Request $request,$slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        $storage = Storage::disk('hr_request_attachments')->delete($hrRequest->file_path);
        if($storage){
            $hrRequest->file_path = null;
            $hrRequest->file_updated_at = Carbon::now();
            $hrRequest->file_user_updated = Auth::user()->user_id;
            $hrRequest->save();
            return [
                'success' => true,
            ];
        }
        abort(503,'Error deleting file.');
    }

    public function patch(Request $request,$slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        if($request->value == 0){
            $hrRequest->status = 'DISAPPROVED' ;
            if($hrRequest->update()){
                return $hrRequest->only('slug');
            }
        }else{
            $hrRequest->document_fields = collect($request->all())->forget(['value','_token'])->toArray();
            $hrRequest->status = 'APPROVED' ;
            if($hrRequest->update()){
                return $hrRequest->only('slug');
            }
        }

        abort(503,'Error performing action.');
    }

    public function download(Request $request,$slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);

        if($hrRequest->status == 'APPROVED'){
            return Pdf::view('printables.hru.hr-requests.contract-of-service',[
                'hrRequest' => $hrRequest,
                'pdfPrint' => true,
            ])
                ->paperSize(215.9,330.2)
                ->margins(20,20, 20, 20)
                ->headers(['title' => 'aaaaa'])
                ->footerView('printables.hru.hr-requests.contract-of-service-footer')
                ->name('Contract of Service.pdf')
                ->withBrowsershot(function (Browsershot $browsershot){
                    if(app()->environment('production')){
                        $browsershot->setNodeBinary(env('NODE_BINARY'))
                            ->setNpmBinary(env('NODE_BINARY'));
                    }
                });

            return view('printables.hru.hr-requests.contract-of-service')->with([
                'hrRequest' => $hrRequest,
            ]);
        }else{
            abort(503,'Cannot download contract of DISAPPROVED Status');
        }
    }

    public function destroy($slug)
    {
        $hrRequest = HRRequests::query()->findOrFail($slug);
        if($hrRequest->delete()){
            return 1;
        }
        abort(503,'Error deleting data.');
    }
}