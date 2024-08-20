<?php
 
namespace App\Swep\Services;

use App\Swep\Repositories\EmployeeRepository;
use Hash;
use App\Swep\BaseClasses\BaseService;
use App\Swep\Interfaces\ProfileInterface;
use App\Swep\Interfaces\EmployeeInterface;


class ProfileService extends BaseService{



    protected $profile_repo;
    protected $employee_repo;



    public function __construct(ProfileInterface $profile_repo, EmployeeRepository $employee_repo){

        $this->profile_repo = $profile_repo;
        $this->employee_repo = $employee_repo;
        parent::__construct();

    }





    public function updateAccountUsername($request, $slug){

        $user = $this->profile_repo->updateUsername($request, $slug);

        $this->session->flush();
        $this->auth->logout();

//        $this->event->dispatch('profile.update_account_username', $user);
        return redirect('/');

    }






    public function updateAccountPassword($request, $slug){

        if(Hash::check($request->old_password, $this->auth->user()->password)){

            $user = $this->profile_repo->updatePassword($request, $slug);

            $this->session->flush();
            $this->auth->logout();

//            $this->event->dispatch('profile.update_account_password', $user);
            return redirect('/');

        }

        $this->session->flash('PROFILE_OLD_PASSWORD_FAIL', 'The old password you provided does not match.');
        return redirect()->back();

    }






    public function updateAccountColor($request, $slug){

        $user = $this->profile_repo->updateColor($request, $slug);

//        $this->event->dispatch('profile.update_account_color', $user);
        return redirect()->back();

    }






    public function printPDS($slug, $page){

        $employee = $this->employee_repo->findBySlug($slug);

        if($page == 'p1'){
            return view('printables.employee_pds_p1')->with('employee', $employee);
        }elseif($page == 'p2'){
            return view('printables.employee_pds_p2')->with('employee', $employee);
        }elseif($page == 'p3'){
            return view('printables.employee_pds_p3')->with('employee', $employee);
        }elseif($page == 'p4'){
            return view('printables.employee_pds_p4')->with('employee', $employee);
        }elseif($page == 'p5'){
            return view('printables.employee_pds_p5')->with('employee', $employee);
        }

        return abort(404);

    }





}