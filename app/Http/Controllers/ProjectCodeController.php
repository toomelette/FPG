<?php

namespace App\Http\Controllers;

use App\Swep\Services\ProjectCodeService;
use App\Http\Requests\ProjectCode\ProjectCodeFormRequest;
use App\Http\Requests\ProjectCode\ProjectCodeFilterRequest;


class ProjectCodeController extends Controller{



	protected $project_code;



    public function __construct(ProjectCodeService $project_code){

        $this->project_code = $project_code;

    }



    
    public function index(ProjectCodeFilterRequest $request){
        return view('dashboard.accounting.moved');
    	return $this->project_code->fetch($request);
    
    }

    


    public function create(){
        return view('dashboard.accounting.moved');
        return view('dashboard.project_code.create');

    }

    


    public function store(ProjectCodeFormRequest $request){

    	return $this->project_code->store($request);
        
    }




    public function edit($slug){
        return view('dashboard.accounting.moved');
    	return $this->project_code->edit($slug);
        
    }




    public function update(ProjectCodeFormRequest $request, $slug){

    	return $this->project_code->update($request, $slug);

    }

    


    public function destroy($slug){

    	return $this->project_code->destroy($slug);

    }




}
