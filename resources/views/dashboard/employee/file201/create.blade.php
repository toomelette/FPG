@php($rand = \Illuminate\Support\Str::random())
@extends('layouts.modal-content', ['form_id' => 'add_file201_form_'.$rand])

@section('modal-header')
    {{$employee->lastname}}, {{$employee->firstname}} - Add 201 File
@endsection

@section('modal-body')
    <input value="{{$employee->slug}}" name="employee" hidden>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::textbox('title',[
            'cols' => 12,
            'label' => 'Title:'
        ]) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('description',[
            'cols' => 12,
            'label' => 'Description:'
        ]) !!}

        {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
            'cols' => 6,
            'label' => 'Date:',
            'type' => 'date',
        ]) !!}
    </div>
    <div class="row">
        {!! \App\Swep\ViewHelpers\__form2::file('doc_file[]',[
            'label' => 'Upload File:',
            'cols' => 12,
            'id' => 'doc_file_'.$rand,
        ]) !!}

    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">

    $("#add_file201_form_{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        loading_btn(form);
        $.ajax({
            url : '{{route("dashboard.file201.store")}}',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,false);
                notify('Data successfully saved.');
                file201_active = res.slug;
                file_201_tbl.draw(false);
            },
            error: function (res) {
                console.log(res);
                errored(form,res)
            }
        })
    })
    $(document).ready(function () {
        uploader = $("#doc_file_{{$rand}}").fileinput({
            // uploadUrl: "",
            enableResumableUpload: false,
            resumableUploadOptions: {
                // uncomment below if you wish to test the file for previous partial uploaded chunks
                // to the server and resume uploads from that point afterwards
                // testUrl: "http://localhost/test-upload.php"
            },
            uploadExtraData: {

            },
            maxFileCount: 1,
            minFileCount: 0,
            showCancel: true,
            initialPreviewAsData: true,
            overwriteInitial: false,
            theme: 'fa',
            deleteUrl: "http://localhost/file-delete.php",
            browseOnZoneClick: true,
            showBrowse: true,
            showCaption: false,
            showRemove: true,
            showUpload: false,
            showCancel: false,
            uploadAsync: false
        }).on('fileloaded', function(event, previewId, index, fileId) {
            $(".kv-file-upload").each(function () {
                $(this).remove();
            })
        }).on('fileuploaderror', function(event, data, msg) {
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
            console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
        }).on('filebatchuploaderror', function(event, data, msg) {
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
            console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
        }).on('filebatchuploadsuccess', function(event, data) {
            console.log(data.response);
            var id = data.response.transaction_id;
            if(data.response.transaction_code == "PRE" || data.response.transaction_types_group == "LAB"){
                form = $("#premixProductForm");
                formData = form.serialize();
                $.ajax({
                    url : "",
                    data: formData,
                    type: 'POST',
                    success: function (res) {
                        alert(11123);
                    },
                    error: function (res) {
                        console.log(res);
                    }
                });
            }
            else {
                alert('esle');
            }
            $("#transaction_id").html(data.response.transaction_id);
            $("#amountToPay").html("Amount to Pay: Php "+ data.response.amount);
            $("#timestamp").html(data.response.timestamp);
            var printRoute = "";
            var newPrintRoute = printRoute + "?transactionId=" + data.response.transaction_id;

            $("#printIframe").attr('src', newPrintRoute)

            setTimeout(function(){
                $("#done").slideDown();
                $("#content").slideUp();
            },500);
            //window.open("http://localhost:8001/dashboard/landBank/"+id, '_blank').focus();
            //data.response is the object containing the values
        }).on('fileerror',function(event,data,msg){
            icon = $("#confirm_payment_btn i");
            icon.removeClass('fa-spinner');
            icon.removeClass('fa-spin');
            icon.addClass(' fa-check');
            $("#confirm_payment_btn").removeAttr('disabled');
        });
    })
</script>
@endsection

