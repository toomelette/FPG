<?php

namespace App\Http\Controllers;

use App\Swep\Services\DocumentFolderService;
use App\Http\Requests\DocumentFolder\DocumentFolderFormRequest;
use App\Http\Requests\DocumentFolder\DocumentFolderFilterRequest;



class DocumentFolderController extends Controller{


   protected $doc_folder;



    public function __construct(DocumentFolderService $doc_folder){

        $this->doc_folder = $doc_folder;

    }





    public function index(DocumentFolderFilterRequest $request){

        return $this->doc_folder->fetch($request);
        
    }

    


    public function create(){
        
        return view('dashboard.document_folder.create');

    }

    



    public function store(DocumentFolderFormRequest $request){

        return $this->doc_folder->store($request);
        
    }

    



    public function edit($slug){
        
        return $this->doc_folder->edit($slug);

    }

    



    public function update(DocumentFolderFormRequest $request, $slug){
            
        return $this->doc_folder->update($request, $slug);

    }

    



    public function destroy($slug){
        
        return $this->doc_folder->destroy($slug);

    }

    



    public function browse($folder_code, DocumentFolderFilterRequest $request){

        return $this->doc_folder->browse($folder_code, $request);

    }







}
