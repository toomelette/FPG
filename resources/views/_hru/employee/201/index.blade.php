@extends('adminkit.master')

@section('content2')
    <style>
        .fileinput-upload{
            display: none;
        }
    </style>
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi']}}</x-slot:title>
        <x-slot:subtitle>{{$employee->plantilla->position ?? $employee->position}}</x-slot:subtitle>
        <x-slot:float-end>201 Files</x-slot:float-end>
    </x-adminkit.html.page-title>

    <x-adminkit.html.card>
        <x-slot:title>
            <div class="btn-group float-end">
                <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-201-file-modal"><i class="fas fa-plus"></i> Add File</button>
            </div>
        </x-slot:title>

        <div id="201-file-table-container">
            <table class="table table-bordered table-striped table-hover file_201 table-sm" id="201-file-table" style="width: 100% !important">
                <thead>
                <tr class="">
                    <th>Type</th>
                    <th >Title</th>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Attachment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-201-file-modal" form-id="add-file-form">
        <x-slot:title>Add File</x-slot:title>
        
        <div class="row mb-2">
            <x-forms.select label="Type" name="type" cols="6" :options="\App\Swep\Helpers\Arrays::file201Types()"/>
            <x-forms.input label="Date" name="date" cols="6" type="date"/>
            <x-forms.input label="Title" name="title" cols="12"/>
            <x-forms.input label="Description" name="description" cols="12"/>
        </div>
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::file('doc_file[]',[
                'label' => 'Upload File:',
                'cols' => 12,
                'id' => 'doc_file',
            ]) !!}
        </div>
        <x-slot:footer>
            <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>

        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-201-modal"/>
@endsection

@section('scripts')
<script type="text/javascript">
    file201Active = '';
    file201Tbl = $("#201-file-table").DataTable({
        'dom' : 'lBfrtip',
        "processing": true,
        "serverSide": true,
        "ajax" : '{{route('dashboard.employee.201',$employee->slug)}}',
        "columns": [
            { "data": "type" },
            { "data": "title" },
            { "data": "date" },
            { "data": "description" },
            { "data": "filename" },
            { "data": "action" },
        ],
        "buttons": [
            {!! __js::dt_buttons() !!}
        ],
        "columnDefs":[
            {
                "targets" : 5,
                "orderable" : false,
                "class" : 'action-2'
            },
        ],
        "responsive": true,
        "initComplete": function( settings, json ) {
            // style_datatable("#"+settings.sTableId);
            //Need to press enter to search
            $('#'+settings.sTableId+'_filter input').unbind();
            $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                if (e.keyCode == 13) {
                    file201Tbl.search(this.value).draw();
                }
            });
        },
        "drawCallback": function(settings){
            if(file201Active != ''){
                $("#"+settings.sTableId+" #"+file201Active).addClass('table-success');
            }
        }
    })

    $("body").on("click",".edit-201-btn",function () {
        let btn = $(this);
        load_modal2(btn);
        let uri = '{{route("dashboard.employee.201",'slug')}}?edit';
        uri = uri.replace('slug',btn.attr('data'));
        $.ajax({
            url : uri,
            type: 'GET',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                populate_modal2(btn,res);
            },
            error: function (res) {
                populate_modal2_error(res);
            }
        })
    })
    $("#add-file-form").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = new FormData(this);
        loading_btn(form);
        $.ajax({
            url : '{{route("dashboard.employee.201",$employee->slug)}}',
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,false);
                toast('success','Data successfully saved.','Success!');
                file201Active = res.slug;
                file201Tbl.draw(false);
            },
            error: function (res) {
                console.log(res);
                errored(form,res)
            }
        })
    })
    uploader = $("#input-24").fileinput({
        maxFileCount: 1,
        // minFileCount: 0,
        // initialPreviewAsData: true,
        // overwriteInitial: false,
        // theme: 'fa',
        // // deleteUrl: "http://localhost/file-delete.php",
        // browseOnZoneClick: true,
        // showBrowse: false,
        // showCaption: false,
        // showRemove: true,
        showUpload: false,
        removeIcon: '<i class="fas fa-times"></i>',
        // showRemove: false,
        // uploadAsync: false
    })
    //     .on('fileloaded', function(event, previewId, index, fileId) {
    //     $(".kv-file-upload").each(function () {
    //         $(this).remove();
    //     })
    // }).on('fileuploaderror', function(event, data, msg) {
    //     icon = $("#confirm_payment_btn i");
    //     icon.removeClass('fa-spinner');
    //     icon.removeClass('fa-spin');
    //     icon.addClass(' fa-check');
    //     $("#confirm_payment_btn").removeAttr('disabled');
    //     console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    // }).on('filebatchuploaderror', function(event, data, msg) {
    //     icon = $("#confirm_payment_btn i");
    //     icon.removeClass('fa-spinner');
    //     icon.removeClass('fa-spin');
    //     icon.addClass(' fa-check');
    //     $("#confirm_payment_btn").removeAttr('disabled');
    //     console.log('File Upload Error', 'ID: ' + data.fileId + ', Thumb ID: ' + data.previewId);
    // }).on('filebatchuploadsuccess', function(event, data) {
    //     console.log(data.response);
    //     var id = data.response.transaction_id;
    //     if(data.response.transaction_code == "PRE" || data.response.transaction_types_group == "LAB"){
    //         form = $("#premixProductForm");
    //         formData = form.serialize();
    //         $.ajax({
    //             url : "",
    //             data: formData,
    //             type: 'POST',
    //             success: function (res) {
    //                 alert(11123);
    //             },
    //             error: function (res) {
    //                 console.log(res);
    //             }
    //         });
    //     }
    //     else {
    //         alert('esle');
    //     }
    //     $("#transaction_id").html(data.response.transaction_id);
    //     $("#amountToPay").html("Amount to Pay: Php "+ data.response.amount);
    //     $("#timestamp").html(data.response.timestamp);
    //     var printRoute = "";
    //     var newPrintRoute = printRoute + "?transactionId=" + data.response.transaction_id;
    //
    //     $("#printIframe").attr('src', newPrintRoute)
    //
    //     setTimeout(function(){
    //         $("#done").slideDown();
    //         $("#content").slideUp();
    //     },500);
    //     //window.open("http://localhost:8001/dashboard/landBank/"+id, '_blank').focus();
    //     //data.response is the object containing the values
    // }).on('fileerror',function(event,data,msg){
    //     icon = $("#confirm_payment_btn i");
    //     icon.removeClass('fa-spinner');
    //     icon.removeClass('fa-spin');
    //     icon.addClass(' fa-check');
    //     $("#confirm_payment_btn").removeAttr('disabled');
    // });

</script>
@endsection