<?php

namespace App\Http\Controllers;

use App\Swep\Services\FundSourceService;
use App\Http\Requests\FundSource\FundSourceFormRequest;
use App\Http\Requests\FundSource\FundSourceFilterRequest;


class FundSourceController extends Controller{

	protected $fund_source;



    public function __construct(FundSourceService $fund_source){

        $this->fund_source = $fund_source;

    }



    
    public function index(FundSourceFilterRequest $request){
        return view('dashboard.accounting.moved');
        return $this->fund_source->fetch($request);
    
    }

    


    public function create(){
        return view('dashboard.accounting.moved');
        return view('dashboard.fund_source.create');

    }

    


    public function store(FundSourceFormRequest $request){

         return $this->fund_source->store($request);
        
    }




    public function edit($slug){

        return $this->fund_source->edit($slug);
        
    }




    public function update(FundSourceFormRequest $request, $slug){

        return $this->fund_source->update($request, $slug);

    }

    


    public function destroy($slug){

       return $this->fund_source->destroy($slug); 

    }
    
}
