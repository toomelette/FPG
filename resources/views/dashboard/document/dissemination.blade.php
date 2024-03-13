<?php
  
$span_sent = '<span class="badge bg-green">Sent</span>'; 
$span_failed = '<span class="badge bg-red">Failed</span>'; 

?>


@if($request->send_copy == 1)
  @include("dashboard.document.dissemination_send_copy")
  @php
  exit();
  @endphp
@endif



@extends('layouts.admin-master')

@section('content')
  <section class="content-header">
      <h1>Document Dissemination</h1>
      <div class="pull-right" style="margin-top: -25px;">
        {!! __html::back_button(['dashboard.document.index']) !!}
      </div>
  </section>

  <section class="content">

    <div class="box">

      <form role="form" method="POST" autocomplete="off" action="{{ route('dashboard.document.dissemination_post', $document->slug) }}">

        @csrf

        <div class="box-body">

          {{-- Navigation --}}
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#email_dissemination" data-toggle="tab">Email Dissemination</a></li>
              <li>
                <a href="#sent" data-toggle="tab">Logs
                  @if(count($document->documentDisseminationLog)>0)
                  <span class="label label-success" style="font-size: 11px !important">{{count($document->documentDisseminationLog)}} </span>
                  @endif
                </a>
              </li>
            </ul>

            <div class="tab-content">


              {{-- Personal Info --}}
              <div class="tab-pane active" id="email_dissemination">
                <div class="row">   
                  <div class="col-md-12">


                      <div class="form-group col-md-12 {{ $errors->has('email_contact') ? 'has-error' : '' }}">
                        <label for="email_contact">Contacts: </label> <br>

                        <select name="email_contact[]" id="email_contact" class="form-control select2" multiple="multiple" data-placeholder="Recipients">
                            @foreach($global_email_contacts_all as $data)
                                @if(old('email_contact'))
                                    <option value="{{ $data->email_contact_id }}" {!! in_array($data->email_contact_id, old('email_contact')) ? 'selected' : '' !!} data-fullname="{{$data->name}}" data-email="{{$data->email}}">{{$data->name}} </option>
                                @else
                                    <option value="{{ $data->email_contact_id }}" data-fullname="{{$data->name}}" data-email="{{$data->email}}" >{{$data->name}} | {{$data->email}}</option>
                                @endif
                            @endforeach
                        </select>

                        @if ($errors->has('email_contact'))
                          <p class="help-block"> {{ $errors->first('email_contact') }} </p>
                        @endif
                      </div>


                      @php
                        $employeesWithEmail = \App\Models\Employee::query()
                            ->select(['email','slug','lastname','firstname','middlename'])
                            ->where('email','!=',null)
                            ->orWhere('email','!=','')
                            ->active()
                            ->get();
                      @endphp
                      <div class="form-group col-md-12 {{ $errors->has('employee') ? 'has-error' : '' }}" id="employee_div">
                        <label for="employee">Employees: </label> <br>
                        <select name="employee[]" id="employee" class="form-control select2" multiple="multiple" data-placeholder="Recipients">
                            @forelse($employeesWithEmail as $employee)
                              <option value="{{ $employee->slug }}" data-fullname="{{$employee->full_name}}" data-email="{{$employee->email}}">{{$employee->full_name}} | {{$employee->email}}</option>
                            @empty
                            @endforelse
                        </select>

                        @if ($errors->has('employee'))
                          <p class="help-block"> {{ $errors->first('subject') }} </p>
                        @endif
                      </div>


                      {!! __form::textbox(
                         '12', 'subject', 'text', 'Subject *', 'Subject',$document->subject, $errors->has('subject'), $errors->first('subject'), ''
                      ) !!}


                      {!! __form::textarea(
                         '12', 'content', 'Content', old('content'), $errors->has('content'), $errors->first('content'), '',''
                      ) !!}


                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Send <i class="fa fa-fw fa-envelope-o"></i></button>
                      </div>
                  </div>
                </div>
                <hr>
                <div class="panel panel-default">
                  <div class="panel-heading">
                   <i class="fa fa-list"></i> Summary of email addresses
                  </div>
                  <div class="panel-body">
                    <table class="table table-bordered table-striped" id="summary_tbl">
                      
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th style="width: 5%">Type</th>
                        </tr>
                      </thead>
                      <tbody>
                         
                          
                      </tbody>
                    </table>
                  </div>
                  </div>
                </div>


              {{-- Family Info --}}
              <div class="tab-pane" id="sent">
                <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                          <b>
                            {{count($document->documentDisseminationLog)}} log(s) found.
                          </b>
                          <i>
                            This list does not include emails that are sent via "Send a copy" function.
                          </i>
                        <a href="{{route('dashboard.document.dissemination.print',$document->slug)}}" target="_blank">
                            <button type="button" class="btn btn-default btn-sm pull-right"><i class="fa fa-print"></i> Print</button>
                        </a>
                          
           
                        </div>
                      </div>
                      <hr style="margin-top: 3px">
                      <table class="table table-hover">

                        <tr>
                          <th>Fullname</th>
                          <th>Email</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>Timestamp</th>
                          <th>Status</th>
                        </tr>

                        <tbody>

                          @foreach ($document->documentDisseminationLog as $data)
                          
                            <tr>
                              <td>
                                @if (!empty($data->employee))
                                  {{ $data->employee->fullname }} 
                                @elseif(!empty($data->emailContact->name))
                                  {{ $data->emailContact->name }}
                                @else
                                  <p class="text-danger"><i class="fa fa-exclamation"></i> Contact not found</p>
                                @endif
                              </td>
                              <td>{{ $data->email }}</td>
                              <td>{{ $data->subject }}</td>
                              <td>{!!  Str::limit($data->content, 30)  !!}</td>
                              <td style="width: 10%">{{date("M. d, 'y | h:i A",strtotime($data->sent_at))}}</td>
                              <td style="width: 5%">{!! $data->status == 'SENT' ? $span_sent : $span_failed !!}</td>
                            </tr>
                            
                          @endforeach

                        </tbody>

                      </table>

                  </div>
                </div>
              </div>





            </div>
          </div>
        </div>

      </form>

    </div>

  </section>

@endsection





@section('modals')

  @if(Session::has('DISSEMINATION_SUCCESS'))
    {!! __html::modal('doc_dissemination', '<i class="fa fa-fw fa-check"></i> Saved!', Session::get('DISSEMINATION_SUCCESS')) !!}
  @endif

@endsection 





@section('scripts')

  <script type="text/javascript">
    $(function () {
      CKEDITOR.replace('editor');
    });
    
    $('select[multiple]').select2({
        closeOnSelect: true,
    });

    $("select[multiple]").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
      //alert('1');
    });

    summary_tbl = $("#summary_tbl").DataTable();

    type_contact = '<span class="label bg-green col-md-12">Contact</span>';
    type_employee = '<span class="label bg-blue col-md-12">Employee</span>';

    $("select[multiple]").on("select2:select", function(){
      array =  [];
      value_employee = $("#employee").val();
      value_contacts = $("#email_contact").val();

      $("#summary_tbl tbody").html('');
      summary_tbl.clear();

      //Employee
      $.each(value_employee,function(i,item){
        email = $("option[value='"+item+"']").attr('data-email');
        fullname = $("option[value='"+item+"']").attr('data-fullname');
        array[item] = {'email':email,'fullname':fullname};

        summary_tbl.row.add( [
            fullname,
            email,
            type_employee,
        ] ).draw( false );
      })

      //Contact
      $.each(value_contacts,function(i,item){
        email = $("option[value='"+item+"']").attr('data-email');
        fullname = $("option[value='"+item+"']").attr('data-fullname');
        array[item] = {'email':email,'fullname':fullname};

        summary_tbl.row.add( [
            fullname,
            email,
            type_contact,
        ] ).draw( false );
      })
    })


    $("select[multiple]").on("select2:unselect", function(){
      array =  [];
      value_employee = $("#employee").val();
      value_contacts = $("#email_contact").val();

      $("#summary_tbl tbody").html('');
      summary_tbl.clear();

      //Employee
      $.each(value_employee,function(i,item){
        email = $("option[value='"+item+"']").attr('data-email');
        fullname = $("option[value='"+item+"']").attr('data-fullname');
        array[item] = {'email':email,'fullname':fullname};

        summary_tbl.row.add( [
            fullname,
            email,
            type_employee,
        ] ).draw( false );
      })

      //Contact
      $.each(value_contacts,function(i,item){
        email = $("option[value='"+item+"']").attr('data-email');
        fullname = $("option[value='"+item+"']").attr('data-fullname');
        array[item] = {'email':email,'fullname':fullname};

        summary_tbl.row.add( [
            fullname,
            email,
            type_contact,
        ] ).draw( false );
      })
    })


    


    @if(Session::has('DISSEMINATION_SUCCESS'))
      $('#doc_dissemination').modal('show');
    @endif

  </script> 
    
@endsection