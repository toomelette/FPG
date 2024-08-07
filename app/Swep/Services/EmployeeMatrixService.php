<?php
 
namespace App\Swep\Services;

use App\Swep\Interfaces\EmployeeMatrixInterface;
use App\Swep\Interfaces\EmployeeInterface;
use App\Swep\BaseClasses\BaseService;
use App\Swep\Repositories\EmployeeRepository;


class EmployeeMatrixService extends BaseService{



    protected $employee_matrix_repo;
    protected $employee_repo;



    public function __construct(EmployeeMatrixInterface $employee_matrix_repo, EmployeeRepository $employee_repo){

        $this->employee_matrix_repo = $employee_matrix_repo;
        $this->employee_repo = $employee_repo;
        parent::__construct();

    }





    public function index($slug){

        $employee = $this->employee_repo->findBySlug($slug);
        return view('dashboard.employee.matrix')->with('employee', $employee);

    }





    public function update($request, $slug){

        $employee = $this->employee_repo->findBySlug($slug);

        if (!empty($employee->employeeMatrix())) {
            $employee->employeeMatrix()->delete();

        }


        $employee_matrix = $this->employee_matrix_repo->store($request, $employee->employee_no);

        return $employee_matrix;

//        $this->event->fire('employee_matrix.update', $employee);
//        return redirect()->back();

    }





    public function show($slug){

        $employee = $this->employee_repo->findBySlug($slug);
        return view('dashboard.employee.matrix_show')->with('employee', $employee);

    }





    public function print($request, $slug){

        $employee = $this->employee_repo->findBySlug($slug);
        return view('printables.employee.matrix')->with('employee', $employee);

    }






}