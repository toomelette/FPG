<?php


namespace App\Http\Controllers;


use App\Http\Requests\MisRequests\MisRequestsStatusFormRequest;
use App\Models\MisRequests;
use App\Models\MisRequestsStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MisRequestsStatusController extends Controller
{
    private  function findBySlug($slug){
        $r = MisRequests::query()->where('slug','=',$slug)->first();
        if(empty($r)){
            abort(503,'Service request not found.');
        }
        return $r;
    }

    public function index(Request $request){
        if(!$request->has('slug') || $request->slug == ''){
            abort(503,'Missing parameters');
        }
        $r = $this->findBySlug($request->slug);
        return view('_mis.ict-requests.status')->with([
            'r' => $r,
        ]);
    }

    public function indexOpen(Request $request){

        if(!$request->has('slug') || $request->slug == ''){
            abort(503,'Missing parameters');
        }
        $r = $this->findBySlug($request->slug);
        if(Auth::user()->user_id != $r->user_created){
            abort(503,'This request is not of your ownership');
        }
        return view('_mis.ict-requests.status')->with([
            'r' => $r,
        ]);
    }

    public function store(MisRequestsStatusFormRequest $request){
        if(!$request->has('request_slug') || $request->request_slug == ''){
            abort(503,'Missing parameters');
        }
        $mis_r_s = new MisRequestsStatus;
        $mis_r_s->status = $request->status;
        $mis_r_s->slug = Str::random(16);
        $mis_r_s->request_slug = $request->request_slug;
        $mis_r_s->user_created = Auth::user()->user_id;
        $mis_r_s->ip_created = $request->ip();
        if($mis_r_s->save()){
            return $mis_r_s->only('slug');
        }
        abort(503,'Error updating status.');
    }
}