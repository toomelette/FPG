@extends('layouts.admin-master')




@section('content')

  <section class="content-header">
      <h1>Document Download</h1>
  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
        <h3 class="box-title">Document Download</h3>
        <div class="pull-right">
            <code>Fields with asterisks(*) are required</code>
        </div>
      </div>

      <form role="form">

        <div class="box-body">

          @if(Session::has('USER_CONFIRMATION_FAIL'))
            {!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Alert!', Session::get('USER_CONFIRMATION_FAIL')) !!}
          @endif

          {{-- {!! __form::textbox(
             '3', 'y', 'text', 'Year *', 'Year', old('y'), $errors->has('y'), $errors->first('y'), ''
          ) !!} --}}

          {!! __form::select_static(
            '3', 'y', 'Year *',  old('y'), $years, $errors->has('y'), $errors->first('y'), '', ''
          ) !!}



          {!! __form::select_dynamic(
            '3', 'fc', 'Folder Code', old('fc'), $global_document_folders_all, 'folder_code', 'folder_code', $errors->has('fc'), $errors->first('fc'), 'select2', ''
          ) !!}


        </div>

      </form>

      <div class="box-footer">
        <button class="btn btn-success" id="download_button">Download <i class="fa fa-fw fa-download"></i></button>
      </div>


    </div>

  </section>

@endsection





@section('modals')

  {{-- USER CONFIRMATION MODAL --}}
  <div class="modal fade" id="document_download" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title"><i class="fa fa-key"></i> &nbsp;User Confirmation</h4>
        </div>
        <div class="modal-body">
          <form id="download_form" class="form-horizontal" method="POST" autocomplete="off" action="{{ route('dashboard.document.download_direct', Auth::user()->slug) }}" target="_blank">

            @csrf
            <p style="font-size: 17px;">Confirm first your identity before downloading!</p><br>
            <input id="y_in_modal" type="hidden" name="y" value="">
            <input id="fc_in_modal" type="hidden" name="fc" value="">

            {!! __form::textbox_inline(
                'username', 'text', 'Username', 'Username', old('username'), $errors->has('username'), $errors->first('username'), ''
            ) !!}

            {!! __form::password_inline(
                'user_password', 'Password', 'Password', $errors->has('user_password'), $errors->first('user_password'), ''
            ) !!}

        </div>

        <div class="modal-footer">
          <button class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Sign-in</button>
        </div>

        </form>

      </div>
    </div>
  </div>

@endsection





@section('scripts')

  <script type="text/javascript">

    {{-- CALL DOWNLOAD CONFIRMATION MODAL --}}
    $(document).on("click", "#download_button", function () {
      var y = $("#y").val();
      var fc = $("#fc").val();
      $("#document_download").modal("show");
      $("#download_form #y_in_modal").attr("value", y);
      $("#download_form #fc_in_modal").attr("value", fc);
    });

  </script>

@endsection