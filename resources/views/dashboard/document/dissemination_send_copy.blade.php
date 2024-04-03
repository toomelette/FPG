<?php
  
$span_sent = '<span class="badge bg-green">Sent</span>'; 
$span_failed = '<span class="badge bg-red">Failed</span>'; 

?>


@extends('layouts.admin-master')

@section('content')
    
  <section class="content-header">
      <h1>Send a copy of a document</h1>
      <div class="pull-right" style="margin-top: -25px;">
        {!! __html::back_button(['dashboard.document.index']) !!}
      </div>
  </section>

  <section class="content">

    <div class="box box-danger">

      <form role="form" method="POST" autocomplete="off" action="{{ route('dashboard.document.dissemination_post', $document->slug) }}?send_copy=1">

        @csrf

        <div class="box-body">
          <div class="callout callout-warning">
                <h4>Warning!</h4>

                <p>Sending document as copy will not reflect in Document Dissemination Reports</p>
              </div>

          {{-- Navigation --}}
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#email_dissemination" data-toggle="tab">Email Dissemination</a></li>
              <li>
                <a href="#sent" data-toggle="tab">
                Logs  
                @if(count($document->documentDisseminationLogSendCopy)>0)
                  <span class="label label-success" style="font-size: 11px !important">{{count($document->documentDisseminationLogSendCopy)}} </span>
                  @endif
                </a>
              </li>
            </ul>

            <div class="tab-content" style="background-color: #e8f5e866">


              {{-- Personal Info --}}
              <div class="tab-pane active" id="email_dissemination">
                <div class="row">   
                  <div class="col-md-12">


                      <div class="form-group col-md-12 {{ $errors->has('email_contact') ? 'has-error' : '' }}">
                        <label for="email_contact">Contacts: </label> <br>
                        <select name="email_contact[]" id="email_contact" class="form-control select2" multiple="multiple" data-placeholder="Recipients">
                            @foreach($global_email_contacts_all as $data)
                                @if(old('email_contact'))
                                    <option value="{{ $data->email_contact_id }}" {!! in_array($data->email_contact_id, old('email_contact')) ? 'selected' : '' !!}>{{$data->name}} </option>
                                @else
                                    <option value="{{ $data->email_contact_id }}">{{$data->name}}</option>
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
                         '12', 'subject', 'text', 'Subject *', 'Subject', old('subject'), $errors->has('subject'), $errors->first('subject'), ''
                      ) !!}


                      {!! __form::textarea(
                         '12', 'content', 'Content', old('content'), $errors->has('content'), $errors->first('content'), ''
                      ) !!}


                      <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-default">Send a copy<i class="fa fa-fw fa-envelope-o"></i></button>
                      </div>
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
                            {{count($document->documentDisseminationLogSendCopy)}} log(s) found.
                          </b>
                          <i>
                            The list below only shows emails that are sent via "Send a copy" function.
                          </i>
           
                        </div>
                      </div>
                      <hr style="margin-top: 3px">
                      <table class="table table-hover table-striped">

                        <tr>
                          <th>Fullname</th>
                          <th>Email</th>
                          <th>Subject</th>
                          <th>Content</th>
                          <th>Timestamp</th>
                          <th>Status</th>
                        </tr>

                        <tbody>

                          @foreach ($document->documentDisseminationLogSendCopy as $data)
                            <tr>
                              @if (!empty($data->employee))
                                <td>{{ $data->employee->fullname }}</td>  
                              @else
                                <td>{{ $data->emailContact->name }}</td>
                              @endif
                              <td>{{ $data->email }}</td>
                              <td>{{ $data->subject }}</td>
                              <td>{{ Str::limit($data->content, 30) }}</td>
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
    });


    @if(Session::has('DISSEMINATION_SUCCESS'))
      $('#doc_dissemination').modal('show');
    @endif

  </script> 
    
@endsection