@extends('layouts.modal-content',['form_id'=>'edit_bm_uid_form','slug'=>$employee->slug])

@section('modal-header')
Biometric
@endsection

@section('modal-body')
    <div class="row">
        {!! __form::textbox(
           '12 biometric_user_id', 'biometric_user_id', 'text', 'Biometric User ID: *', 'Biometric User ID',$employee->biometric_user_id, '', '', ''
         ) !!}
    </div>
@endsection

@section('modal-footer')
<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script>
        $("#edit_bm_uid_form").submit(function (e) {
            e.preventDefault();
            form = $(this);
            loading_btn(form)

            $.ajax({
                url : '{{route('dashboard.employee.update_bm_uid')}}?slug='+form.attr('data'),
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form ,true, true);
                    location.reload();
                   console.log(res);
                },
                error: function (res) {
                    errored(form, res);
                }
            })
        })
    </script>
@endsection

