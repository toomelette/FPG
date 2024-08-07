<?php
 
namespace App\Swep\Services;


use App\Swep\Interfaces\EmployeeInterface;
use App\Swep\Interfaces\UserInterface;
use App\Swep\BaseClasses\BaseService;
use App\Swep\Repositories\EmployeeRepository;


class HomeService extends BaseService{



    protected $employee_repo;
    protected $user_repo;



    public function __construct(EmployeeRepository $employee_repo, UserInterface $user_repo){

        $this->employee_repo = $employee_repo;
        $this->user_repo = $user_repo;
        parent::__construct();

    }





    public function view(){

        $count_active_emp = $this->employee_repo->getAll()->count();
        $count_male_emp = $this->employee_repo->getBySex('M')->count();
        $count_female_emp = $this->employee_repo->getBySex('F')->count();
        $count_online_users = $this->user_repo->getByIsOnline(1)->count();
        $get_emp_by_dept = $this->getEmpByDept();

        return view('dashboard.home.index', compact(
                'count_active_emp',
                'count_male_emp',
                'count_female_emp',
                'count_online_users',
                'get_emp_by_dept'
        ));

    }






    private function getEmpByDept(){

        $afd = $this->employee_repo->getByDepartmentId('D1001')->count();
        $iad = $this->employee_repo->getByDepartmentId('D1002')->count();
        $ppd = $this->employee_repo->getByDepartmentId('D1003')->count();
        $rde = $this->employee_repo->getByDepartmentId('D1004')->count();
        $rd = $this->employee_repo->getByDepartmentId('D1005')->count();
        $legal = $this->employee_repo->getByDepartmentId('D1006')->count();

        return ['AFD' => $afd,'IAD' => $iad,'PPD' => $ppd,'RDE' => $rde,'RD' => $rd,'LEGAL' => $legal];

    }








}