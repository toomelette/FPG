@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Disseminating</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email address</th>
                <th>Subject</th>
                <th>Content</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
                @php
                    $ct = 0;
                @endphp
                @if(!empty($r['employees']) && count($r['employees']) > 0)
                    @forelse($r['employees'] as $employee)
                        @php
                            $emp = \App\Models\Employee::query()->select('employee_no','fullname','email')->where('employee_no','=',$employee)->first();
                        @endphp
                        <tr>
                            <td>{{$emp->fullname ?? ''}}</td>
                            <td>{{$emp->email ?? ''}}</td>
                            <td>{{$r['subject']}}</td>
                            <td>{!! $r['content']  !!}</td>
                            <td id="row_{{$ct}}" class="rows">

                                <form id="form_{{$ct}}" class="form" data="{{$ct}}">
                                    <i class="fa fa-spinner fa-spin icon"></i> <span class="status">Sending...</span>
                                    <input style="display: none" name="employee" value="{{$employee}}">
                                    <input style="display: none" name="document_slug" value="{{$slug}}">
                                    <input style="display: none" name="subject" value="{{$r['subject']}}">
                                    <input style="display: none" name="content" value="{{$r['content']}}">
                                    <input style="display: none" name="type" value="employee">
                                    <button style="display: none" type="submit" class="btn btn-xs btn-warning">Failed! Click to resend</button>
                                </form>
                            </td>
                        </tr>
                        @php
                            $ct++;
                        @endphp
                    @empty
                    @endforelse
                @endif
                @if(!empty($r['email_contacts']) && count($r['email_contacts']) > 0)
                    @forelse($r['email_contacts'] as $ec)
                        @php
                            $contact = \App\Models\EmailContact::query()->select('email_contact_id','name','email')->where('email_contact_id','=',$ec)->first();
                        @endphp
                        <tr>
                            <td>{{$contact->name ?? ''}}</td>
                            <td>{{$contact->email ?? ''}}</td>
                            <td>{{$r['subject']}}</td>
                            <td>{!! $r['content']  !!}</td>
                            <td id="row_{{$ct}}" class="rows">

                                <form id="form_{{$ct}}" class="form" data="{{$ct}}">
                                    <i class="fa fa-spinner fa-spin icon"></i> <span class="status">Sending...</span>
                                    <input style="display: none" name="employee" value="{{$ec}}">
                                    <input style="display: none" name="document_slug" value="{{$slug}}">
                                    <input style="display: none" name="subject" value="{{$r['subject']}}">
                                    <input style="display: none" name="content" value="{{$r['content']}}">
                                    <input style="display: none" name="type" value="contact">
                                    <button style="display: none" type="submit" class="btn btn-xs btn-warning">Failed! Click to resend</button>
                                </form>
                            </td>
                        </tr>
                        @php
                            $ct++;
                        @endphp
                    @empty
                    @endforelse
                @endif
            </tbody>
        </table>


    </section>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        var allEmails = {{$ct}};
        function submitForm(form){
            alert();
        }

        $(document).ready(function (){
            $(".form").each(function (e){
                let form = $(this);
                form.submit();
            })
        });

        $(".form").on('submit',function (e){
            e.preventDefault();
            let form = $(this);
            let row = form.attr('data');
            let rowObj = $("#row_"+row);
            form.find('.status').show();
            form.find('.icon').show();
            form.find('button[type="submit"]').hide();
            $.ajax({
                url : '{{route("dashboard.document.dissemination",$slug)}}{{($send_copy == 1 ? '?send_copy=1' : '')}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    $("#row_"+row).html('<span class="text-success"><i class="fa fa-check"></i> Sent</span>');
                    allEmails--;
                    let check = 0
                    $(".rows").each(function (){
                        if($(this).find('form').length > 0){
                            check = 1;
                        }
                    });
                    if(check == 0){
                        Swal.fire({
                            title: "Success.",
                            text: "All emails were sent.",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location = '{{route("dashboard.document.index")}}';
                            }
                        });
                    }

                },
                error: function (res) {
                    form.find('.status').hide();
                    form.find('.icon').hide();
                    form.find('button[type="submit"]').show();
                }
            })
        })

        window.onbeforeunload = function (e) {
            if(allEmails >0){
                e = e || window.event;

                // For IE and Firefox prior to version 4
                if (e) {
                    e.returnValue = 'There are pending emails not sent. Continue?';
                }

                // For Safari
                return 'There are pending emails not sent. Continue?';
            }
        };
    </script>
@endsection