<?php

namespace App\Http\Controllers;


use App\Models\Applicant;
use App\Models\Budget\ORS;
use App\Models\Budget\ORSProjectsApplied;
use App\Models\Course;
use App\Models\Document;
use App\Models\DocumentDisseminationLog;
use App\Models\EmailContact;
use App\Models\Employee;
use App\Models\HRPayPlanitilla;
use App\Models\JoEmployees;
use App\Models\LeaveApplication;
use App\Models\News;
use App\Models\PermissionSlip;
use App\Swep\Services\HomeService;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;


class HomeController extends Controller{
    



	protected $home;




    public function __construct(HomeService $home){

        $this->home = $home;

    }


    public function index(Request $request){
        return  view('fg.home.index');
    }

}
