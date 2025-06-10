@php
    /** @var \App\Models\Document $document  **/
    if(Request::get('send_copy')){
        $document->load('documentDisseminationLogSendCopy.employee');
        $logs = $document->documentDisseminationLogSendCopy;
    }else{
        $document->load('documentDisseminationLog.employee');
        $logs = $document->documentDisseminationLog;
    }
@endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Dissemination</x-slot:title>
        <x-slot:float-end>{{$document->reference_no}} - {{Str::limit($document->subject,50)}}</x-slot:float-end>
    </x-adminkit.html.page-title>
    @if(Request::get('send_copy') == 1)
        <x-adminkit.html.alert type="danger" :dismissible="false">
            <strong>This is a send copy mode</strong> <br>
            Sending document as copy will not reflect in Document Dissemination Reports
        </x-adminkit.html.alert>
    @endif
    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation"><a class="nav-link active" href="#tab-1" data-bs-toggle="tab" role="tab" aria-selected="true">Disseminate</a></li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="#tab-2" data-bs-toggle="tab" role="tab" aria-selected="false" tabindex="-1">
                    Logs @if(($count = $logs->count()) > 0)<span class="badge bg-success">{{$count}}</span> @endif
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-1" role="tabpanel">
                <form id="disseminate-form">
                    <div class="row mb-2">
                        <x-forms.select label="Contacts" name="email_contact[]" cols="12" container-class="email_contact" id="email-contact" :options="$emailContacts" :multiple="true" :include-empty="false"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.select label="Employees" name="employee[]" cols="12" container-class="employee" id="employee" :options="$employeesWithEmail" :multiple="true" :include-empty="false"/>
                    </div>
                    <div class="row mb-2">
                        <x-forms.input label="Subject" name="subject" cols="12" :value="$document->subject"/>
                    </div>

                    <div class="row mb-2">
                        <x-forms.textarea label="Body" name="body" cols="12" id="editor" value="Good day. Please see the attached file. Thank you."/>
                    </div>
                    <div class="clearfix">
                        @if(Request::get('send_copy') == 1)
                            <button type="submit" class="btn btn-secondary btn-sm float-end"><i class="fa fa-envelope"></i> Send Copy</button>
                        @else
                            <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-envelope"></i> Disseminate</button>
                        @endif


                    </div>
                </form>

                <hr>
                <x-adminkit.html.alert :dismissible="false" :with-icon="false" type="success" body-class="p-1 text-center text-strong">
                    Summary of Recipients
                </x-adminkit.html.alert>
                <table class="table table-bordered table-striped table-sm" id="summary-tbl">

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
            <div class="tab-pane" id="tab-2" role="tabpanel">
                <a href="{{route('dashboard.document.dissemination.print',$document->slug)}}{{\Illuminate\Support\Facades\Request::has('send_copy') ? '?send_copy=1' : ''}}" target="_blank">
                    <button type="button" class="btn btn-outline-secondary btn-sm float-end"><i class="fa fa-print"></i> Print</button>
                </a>
                <h4 class="tab-title">{{$count}} {{Str::plural('log',$count)}} found.</h4>
                This list does not include emails that are sent via "Send a copy" function.

                <table class="table table-sm">

                    <tr>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Content</th>
                        <th>Timestamp</th>
                        <th>Status</th>
                    </tr>

                    <tbody>

                    @foreach ($logs as $log)
                        <tr>
                            <td>
                                @if (!empty($log->employee))
                                    {{ $log->employee->fullname }}
                                @elseif(!empty($log->emailContact->name))
                                    {{ $log->emailContact->name }}
                                @else
                                    <p class="text-danger"><i class="fa fa-exclamation"></i> Contact not found</p>
                                @endif
                            </td>
                            <td>{{ $log->email }}</td>
                            <td>{{ $log->subject }}</td>
                            <td>{!!  Str::limit($log->content, 30)  !!}</td>
                            <td>{{date("M. d, Y | h:i A",strtotime($log->sent_at))}}</td>
                            <td>
                                @if($log->status == 'SENT')
                                    <span class="badge bg-success">Sent</span>
                                @else
                                    <span class="badge bg-green">{{$log->status}}</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>
    </div>



@endsection


@section('modals')

@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        CKEDITOR.replace('editor');
    });
    @if(\Illuminate\Support\Facades\Request::get("page") != null)
        const page = '{{\Illuminate\Support\Facades\Request::get("page")}}';
    @else
        const page = 0;
    @endif
    $("#disseminate-form").submit(function (e) {
        e.preventDefault();
        CKEDITOR.instances['editor'].updateElement();
        let form = $(this);
        loading_btn(form);
        $.ajax({
            @if(Request::has('send_copy') && Request::get('send_copy') == 1)
                url : '{{ route('dashboard.document.dissemination_post', $document->slug) }}?send_copy=1',
            @else
                url :  '{{ route('dashboard.document.dissemination_post', $document->slug) }}',
            @endif
            data : form.serialize(),
            type: 'POST',
            headers: {
                {!! __html::token_header() !!}
            },
            success: function (res) {
                succeed(form,true,true);
                Swal.fire({
                    title: "Dissemination Complete!",
                    text: "Redirecting...",
                    icon: "success",
                    allowOutsideClick:false,
                    showConfirmButton: false,
                });
                setTimeout(function (){
                    window.location.replace('{{route("dashboard.document.index")}}?toPage='+page+'&mark='+res.slug);
                },2000);
            },
            error: function (res) {
                errored(form,res);
            }
        })
    })

    $("select").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);

        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
        $('.select2-search__field').val('');
    });



    summary_tbl = $("#summary-tbl").DataTable();
    type_contact = '<span class="badge bg-success col-12">Contact</span>';
    type_employee = '<span class="badge bg-primary col-12">Employee</span>';
    $("select[multiple]").on("change", function(){
        array =  [];
        value_employee = $("#employee").val();
        value_contacts = $("#email-contact").val();
        summary_tbl.clear();
        //Employee
        $.each(value_employee,function(i,item){
            concatenated = $("option[value='"+item+"']").html();
            email = concatenated.split('|')[1];
            fullname = concatenated.split('|')[0];
            array[item] = {'email':email,'fullname':fullname};

            summary_tbl.row.add( [
                fullname,
                email,
                type_employee,
            ] );
        })
        //Contact
        $.each(value_contacts,function(i,item){
            concatenated = $("option[value='"+item+"']").html();
            email = concatenated.split('|')[1];
            fullname = concatenated.split('|')[0];
            array[item] = {'email':email,'fullname':fullname};

            summary_tbl.row.add( [
                fullname,
                email,
                type_contact,
            ] );
        })
        summary_tbl.draw(false);
    })
</script>
@endsection