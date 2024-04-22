<?php

  $appended_requests = [ 'q'=> Request::get('q')];
  
?>



@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Browse Files</h1>
      <div class="pull-right" style="margin-top: -25px;">
      {!! __html::back_button([
        'dashboard.document_folder.index',
      ]) !!}
  </section>

  <section class="content">
    
    <div class="box" id="pjax-container" style="overflow-x:auto;">

      <form id="filter_form" method="GET" autocomplete="off" >
        <div class="box-header with-border">
          <div class="box-title">  
                <div class="input-group input-group-sm" style="width: 300px;">
                  <input name="q" class="form-control pull-right" placeholder="Search" type="text" value="">
                  <div class="input-group-btn">
                    <button id="table_search_button" type="submit" class="btn btn-default btn-md"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>

              <div></div>

        </div>
      </form>

   
      <ol class="breadcrumb">
        <li><a href="{{$prev}}">Home</a></li>
        <li><a href="#">{{$folder_code}}</a></li>
      </ol>
   

      {{-- Table Grid --}}        
      <div class="box-body no-padding">
        <table class="table">
          <tr>
            <th style="width: 15px">View</th>
            <th  style="width: 150px">@sortablelink('reference_no', 'Ref No')</th>
            <th>@sortablelink('person_to', 'To')</th>
            <th>@sortablelink('subject', 'Subject')</th>
            <th style="width:200px;">@sortablelink('updated-at', 'Last Modified')</th>
          </tr>
          @foreach($documents as $data) 
            <tr>
              <td style="width: 15px"><a href="{{ route('dashboard.document.view_file', $data->slug) }}" class="btn btn-sm btn-success" target="_blank">
                    <i class="fa fa-file-o"></i>
                  </a></td>
              <td >{{$data->reference_no}}</td>
              <td>{{$data->person_to}}</td>
              <td>
                {{-- <a href="{{ route('dashboard.document.view_file', $data->slug) }}" style="text-decoration: underline; font-size:15px;" target="_blank"> --}}
                  {{ $data->subject }}
                {{-- </a> --}}
              </td>
              <td>{{ $data->updated_at->diffForHumans() }}</td>

            </tr>
            @endforeach
        </table>
      </div>

      @if($documents->isEmpty())
        <div style="padding :5px;">
          <center><h4>No Records found!</h4></center>
        </div>
      @endif

      <div class="box-footer">
        {!! __html::table_counter($documents) !!}
        {!! $documents->appends($appended_requests)->render('vendor.pagination.bootstrap-4') !!}
      </div>

    </div>

  </section>


@endsection