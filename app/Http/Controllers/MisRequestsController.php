<?php


namespace App\Http\Controllers;


use App\Events\MisRequest\NewRequest;
use App\Http\Requests\MisRequests\MisRequestsFormRequest;
use App\Models\MisRequests;
use App\Models\MisRequestsEmailRecipients;
use App\Models\MisRequestsNature;
use App\Models\MisRequestsStatus;
use App\Models\PPMP;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class MisRequestsController extends Controller
{
    public function myRequests(){
        if(\request()->ajax() && \request()->has('draw')){
            $mis_requests = MisRequests::with('status')
                ->where('user_created','=',Auth::user()->user_id);

            return \DataTables::of($mis_requests)
                ->addColumn('action',function ($data){
                    return view('_mis.ict-requests.my-dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('status', function ($data){
                   $status = $data->status->sortByDesc('created_at')->first();
                   if(!empty($status)){
                       return $status->status;
                   }
                })
                ->editColumn('created_at',function ($data){
                    return Carbon::parse($data->created_at)->format('M. d, Y | h:i A');
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_mis.ict-requests.my-index');
    }

    public  function store(MisRequestsFormRequest $request){

        $r = new MisRequests;
        $r->slug = Str::random(16);
        $r->request_no = $this->createNewRequstNo();;
        $r->nature_of_request = MisRequestsNature::query()->where('slug','=',$request->nature_of_request)->first()->nature_of_request;
        $r->requisitioner = strtoupper(Auth::user()->employee->full_name);
        $r->request_details = $request->details;
        $r->email = $request->email;
        $r->phone = $request->phone;
        $r->department = $request->department;
        if($r->save()){
            $user = User::query()->where('user_id','=',$r->user_created)->first();
            $data = [
                'r' => $r,
                'user' => $user,
            ];

            try{
                \Illuminate\Support\Facades\Mail::mailer('system')->send(new \App\Mail\MisRequestCreate($data,$r,$user));
            }catch (\Exception $e){
                $r->delete();
                //abort(503,'Error sending email verification: '.$e->getMessage());
            }

            try{
                event(new NewRequest($r));
            }catch (\Exception $exception){

            }
            return $r->only(['slug','request_no']);

        }
        abort(503,'Error creating request.');
    }


    private function createNewRequstNo(){

        $r = MisRequests::query()->orderBy('id','desc')->first();
        if(empty($r)){
            $new_no = Carbon::now()->format('Y').'-0001'.env('MIS_REQUEST_SUFFIX','');
        }else{
            if(explode('-',$r->request_no)[0] == Carbon::now()->format('Y')){
                $new_no =  Carbon::now()->format('Y').'-'.str_pad(explode('-',$r->request_no)[1]+1,4,'0',STR_PAD_LEFT).env('MIS_REQUEST_SUFFIX','');
            }else{
                $new_no = Carbon::now()->format('Y').'-0001'.config('custom.MIS_REQUEST_SUFFIX','');
            }
        }
        return $new_no;
    }

    private  function findBySlug($slug){
        $r = MisRequests::with('status')->where('slug','=',$slug)->first();
        if(empty($r)){
            abort(503,'Service request not found.');
        }
        return $r;
    }

    public function cancelRequest(Request $request){
        $r = $this->findBySlug($request->id);
        $r->cancelled_at = Carbon::now();
        if($r->update()){
            return 'Request has been cancelled successfully.';
        }
        abort(503,'Service request not found.');
    }

    public function printRequestForm($slug){

        $r = $this->findBySlug($slug);
        $user = User::query()->where('user_id','=',$r->user_created)->first();

        return view('printables.mis_requests.print-fm-ppd-0615-02')->with([
            'r' => $r,
            'user' => $user,
        ]);
    }

    public function index(){
        if(\request()->ajax() && \request()->has('draw')){
            $mis_requests = MisRequests::query();
            $request = \request();

            $table = MisRequests::query()->with(['user','user.employee']);
            return \DataTables::of($table)
                ->addColumn('action',function ($data){
                    return view('_mis.ict-requests.dtActions')->with([
                        'data' => $data,
                    ]);
                })
                ->addColumn('status', function ($data){
                    $status = MisRequestsStatus::query()->where('request_slug','=',$data->slug)->orderBy('created_at','desc')->first();
                    if(!empty($status)){
                        return $status->status;
                    }
                })
                ->editColumn('created_at',function ($data){
                    return Carbon::parse($data->created_at)->format("M. d, Y | h:i A");
                })
                ->addColumn('fullname',function ($data){
                    return view('_mis.ict-requests.dtRequisitioner')->with([
                        'data' => $data,
                    ]);
                })
                ->editColumn('nature_of_request',function ($data){
                    return view('_mis.ict-requests.dtNatureOfRequest')->with([
                        'data' => $data,
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }

        return view('_mis.ict-requests.index');
    }

    private function findCreator($slug){
        $r =  $this->findBySlug($slug);
        if(!empty($r)){
            $requisitioner = $r->requisitioner;
            $user = User::query()->where('user_id','=',$requisitioner)->first();
            if(!empty($user)){
                if(!empty($user->employee)){
                    return $user->lastname.', '.$user->firstname;
                }
                if(!empty($user->joEmployee)){
                    return $user->lastname.', '.$user->firstname;
                }
            }
            return $requisitioner;
        }
    }

    public function update(Request $request,$slug){
        if($request->has('update_status') && $request->update_status == true){
            if($request->status == ''){
                abort(503,'This field is required');
            }
            $ts = $this->touchStatus($request->status,$slug);
            if($ts){
                return [
                    'slug' => $slug,
                ];
            }
        }

        if($request->has('mark_as_done') && $request->mark_as_done == true){
            $r = $this->findBySlug($slug);
            $r->completed_at = Carbon::now();
            $r->user_completed = Auth::user()->user_id;
            if($r->update()){
                $this->touchStatus('Service request ticket was closed.',$slug);
                return $r->only('slug');
            }
            abort(503,'Error marking as done.');
        }

        $r = $this->findBySlug($slug);
        $r->recommendations = $request->recommendations;
        $r->summary_of_diagnostics = $request->summary_of_diagnostics;
        $r->returned = $request->returned;
        $r->date_returned = $request->date_returned;

        if($r->update()){
            if(count($r->getChanges()) > 1){
                $changes = $r->getChanges();
                foreach ($changes as $field => $value){
                    $new_key = str_replace('_',' ',$field);
                    $new_key = ucwords($new_key);
                    if($field != 'updated_at' && $field != 'user_updated' && $field != 'ip_updated'){
                        $this->touchStatus($new_key.': '.$value,$slug);
                    }
                }
            }

            $return = [
                'slug' => $slug,
                'summary_of_diagnostics' => $r->summary_of_diagnostics,
                'returned'=> $r->returned,
                'date_returned' => $r->date_returned,
                'recommendations' => $r->recommendations,
                'status' => $r?->status?->first()?->status ?? null,
            ];
            return $return;

        }
        abort(503, 'Error updating data.');

    }

    private function touchStatus($status_text,$request_slug){
        $mis_r_s = new MisRequestsStatus;
        $mis_r_s->status = $status_text;
        $mis_r_s->slug = Str::random(16);
        $mis_r_s->request_slug = $request_slug;
        $mis_r_s->user_created = Auth::user()->user_id;
        $mis_r_s->ip_created = request()->ip();
        if($mis_r_s->save()){
            return $mis_r_s->only('slug');
        }
    }

    public function edit($slug){
        $r = $this->findBySlug($slug);
        $requisitioner = $this->findCreator($slug);
        return view('_mis.ict-requests.edit')->with([
            'ict' => $r,
            'requisitioner' => $requisitioner,
        ]);
    }

    public function show($slug)
    {

    }

}