<?php

  $table_sessions = [ 
                      Session::get('DOC_FOLDER_UPDATE_SUCCESS_SLUG'),
                    ];

  $appended_requests = [
                        'q'=> Request::get('q'),
                        'sort' => Request::get('sort'),
                        'direction' => Request::get('direction'),
                        'e' => Request::get('e'),
                      ];
                      
?>





@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Document Folder List</h1>
  </section>

  <section class="content">
    
    {{-- Form Start --}}
    
    <form data-pjax class="form" id="filter_form" method="GET" autocomplete="off" action="{{ route('dashboard.document_folder.index') }}">

    <div class="box" id="pjax-container" style="overflow-x:auto;">

      {{-- Table Search --}}        
      <div class="box-header with-border">
        {!! __html::table_search(route('dashboard.document_folder.index')) !!}
      </div>

    {{-- Form End --}}  
    </form>

    <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
      </ol>

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table">
          <tr>
            <th>@sortablelink('folder_code', 'Folder Code')</th>
            <th>Documents</th>
            <th style="width: 150px">Action</th>
          </tr>


          @foreach($doc_folders as $data) 
            <tr {!! __html::table_highlighter( $data->slug, $table_sessions) !!} >
              <td id="mid-vert">
                <i class="fa fa-folder" style="font-size: 20px; color: #3c8dbc"></i>
                <a href="{{route('dashboard.document_folder.browse', $data->folder_code )}}" style="text-decoration: underline; font-size:15px;">

                  {{ $data->folder_code .' - '. $data->description }}
                </a>
              </td>
              <td style="width: 50px" class="text-center">
                @if(count($data->documents1) + count($data->documents2)==0)
                  Empty
                @else
                  {{count($data->documents1) + count($data->documents2) }}
                @endif
                
              </td>
              <td> 
                <select id="action" class="form-control input-md">
                  <option value="">Select</option>
                  <option data-type="1" data-url="{{ route('dashboard.document_folder.edit', $data->slug) }}">Edit</option>
                  <option data-type="0" data-action="delete" data-url="{{ route('dashboard.document_folder.destroy', $data->slug) }}">Delete</option>
                </select>
              </td>

            </tr>
            @endforeach
        </table>
      </div>

      @if($doc_folders->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($doc_folders) !!}
        {!! $doc_folders->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
      </div>

    </div>

  </section>


@endsection






@section('modals')

  {!! __html::modal_delete('doc_folder_delete') !!}

@endsection 





@section('scripts')

  <script type="text/javascript">

    {{-- CALL CONFIRM DELETE MODAL --}}
    {!! __js::modal_confirm_delete_caller('doc_folder_delete') !!}

    {{-- DOCUMENT FOLDER DELETE TOAST --}}
    @if(Session::has('DOC_FOLDER_DELETE_SUCCESS'))
      {!! __js::toast(Session::get('DOC_FOLDER_DELETE_SUCCESS')) !!}
    @endif

    {{-- DOCUMENT FOLDER UPDATE TOAST --}}
    @if(Session::has('DOC_FOLDER_UPDATE_SUCCESS'))
      {!! __js::toast(Session::get('DOC_FOLDER_UPDATE_SUCCESS')) !!}
    @endif

  </script>
    
@endsection