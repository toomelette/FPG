@extends('layouts.admin-master')

@section('content')

<section class="content-header">
    <h1>Leave Card Details</h1>
    <div class="pull-right" style="margin-top: -25px;">
      {!! __html::back_button(['dashboard.leave_card.index']) !!}
    </div>
</section>

<section class="content">

    <div class="box">
        
      <div class="box-header with-border">
        
        <h3 class="box-title">Details</h3>

        <div class="box-tools">
          <a href="{{ route('dashboard.leave_card.edit', $leave_card->slug) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i> Edit</a>
        </div>

      </div>
      
      <div class="box-body">


        {{-- DOC Info --}}
        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Document Info</h3>
            </div>
            <div class="box-body">
              <dl class="dl-horizontal">
                <dt>Employee:</dt>
                <dd>{{ $leave_card->employee->fullname }}</dd>
                <dt>Document Type:</dt>
                <dd>{{ $leave_card->doc_type }}</dd>

                @if($leave_card->doc_type == 'LEAVE')
                  <dt>Leave Type:</dt>
                  <dd>{{ $leave_card->leave_type }}</dd>
                  <dt>Date</dt>
                  <dd>{{ __dataType::date_parse($leave_card->date_from, 'M d, Y') .' - '. __dataType::date_parse($leave_card->date_to, 'M d, Y') }}</dd>
                  <dt>Days:</dt>
                  <dd>{{ $leave_card->days }}</dd>
                @else
                  <dt>Date</dt>
                  <dd>{{ __dataType::date_parse($leave_card->date, 'M d, Y') }}</dd>
                  <dt>Hrs:</dt>
                  <dd>{{ $leave_card->hrs }}</dd>
                  <dt>Mins:</dt>
                  <dd>{{ $leave_card->mins }}</dd>
                @endif

                <dt>Credits:</dt>
                <dd>{!! $leave_card->credits !!}</dd>
                
              </dl>
            </div>
          </div>
        </div>





        <div class="col-md-6">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">User Modifications</h3>
            </div>
            <div class="box-body">

              <dl class="dl-horizontal col-sm-12">
                <dt>Date Created:</dt>
                <dd>{{ __dataType::date_parse($leave_card->created_at, 'M d, Y h:i A') }}</dd>
                <dt>IP Created:</dt>
                <dd>{{ $leave_card->ip_created }}</dd>
                <dt>User Created:</dt>
                <dd>{{ $leave_card->user_created }}</dd>
                <dt>Date Updated:</dt>
                <dd>{{ __dataType::date_parse($leave_card->updated_at, 'M d, Y h:i A') }}</dd>
                <dt>IP Updated:</dt>
                <dd>{{ $leave_card->ip_updated }}</dd>
                <dt>User Updated:</dt>
                <dd>{{ $leave_card->user_updated }}</dd>
              </dl>

            </div>
          </div>
        </div> 




    </div>
  </div>

</section>

@endsection

