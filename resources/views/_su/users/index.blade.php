@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Users</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <x-slot:title>
            <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-user-modal"><i class="fa fa-plus"></i> New User</button>
        </x-slot:title>
        <div class="users-table-container table-responsive"  >
            <table class="table table-bordered table-sm" id="users-table" style="width: 100%;">
                <thead>
                <tr>
                    <th style="width: 15%;">Username</th>
                    <th>Employee</th>
                    <th>First</th>
                    <th>Middle</th>
                    <th style="width: 50px">Active</th>
                    <th style="width: 50px">Online</th>
                    <th style="width: 80px">Actions</th>
                </tr>
                </thead>
                <tbody>
        
                </tbody>
            </table>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-user-modal" size="sm" form-id="add-user-form">
        <x-slot:title>
            New user
        </x-slot:title>
        <div class="row mb-2">
            <x-forms.select label="Employee" name="employee" cols="12" id="select2-employees"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Username" name="project_id" cols="12"/>
        </div>

        <div class="row mb-2">
            <x-forms.select label="Project ID" name="username" cols="12" :options="[1 => '1 - VIS' , 2 => '2 - LM']"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
@endsection

@section('scripts')
    <script type="text/javascript">
        let active = '';
        usersTbl = $("#users-table").DataTable({
            dom : 'lBfrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.user.index')}}',
            columns: [
                { data : "username" },
                { data : "fullname", name: "employee.lastname" },
                { data : "employee.firstname" },
                { data : "employee.middlename" },
                { data : "is_activated" },
                { data : "last_activity" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[
                {
                    targets: [2,3],
                    visible: false,
                }
            ],
            order:[[5,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        usersTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(active != ''){
                    $("#"+settings.sTableId+" #"+active).addClass('table-success');
                }
            }
        })
        $("#select2-employees").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","new-user-from-employee")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $("#add-user-modal"),
        });
        
        $("#add-user-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.user.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    active = res.slug;
                    usersTbl.draw(false);
                    succeed(form,true,true);
                    toast('success','User successfully created.','Success!');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("body").on("click",".reset_password_btn", function(){
            slug = $(this).attr('data');
            fullname = $(this).attr('fullname');
            Swal.fire({
                title: 'Are you sure you want to reset the password?',
                html: "Account: "+fullname+"</br> The password will be changed to the user's birthday in <b>MMDDYY</b> format",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reset it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    url = "{{route('dashboard.user.reset_password','slug')}}"
                    url = url.replace("slug",slug);
                    $.ajax({
                        url : url,
                        type: 'GET',
                        headers: {
                            {!! __html::token_header() !!}
                        },
                        success: function (res) {
                            console.log(res);
                            active = res.slug;
                            usersTbl.draw(false);
                            Swal.fire(
                                'Reset Successful!',
                                'The password of '+fullname+" has been reset successfully.",
                                'success'
                            )
                        },
                        error: function (res) {
                            console.log(res);
                            notify(res.responseJSON.message,'danger');
                        }
                    })

                }
            })
        })
        $("body").on("click",".ac_dc", function () {
            var first_name = $(this).attr("user");
            var slug = $(this).attr('data');
            if($(this).attr("status") == "active"){
                Swal.fire({
                    title: "Deactivate account?",
                    showCancelButton: true,
                    confirmButtonText: 'Deactivate',
                    icon : 'question',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var uri = "{{route('dashboard.user.deactivate','slug')}}";
                        var uri = uri.replace('slug',slug);
                        $.ajax({
                            url : uri,
                            type : 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (response) {
                                Swal.fire('Account deactivation success!', '', 'success');
                                active = response.slug;
                                usersTbl.draw(false);
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });
                    }
                })
            }else{
                Swal.fire({
                    title: "Activate account?",
                    showCancelButton: true,
                    confirmButtonText: 'Activate',
                    icon : 'question',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var uri = "{{route('dashboard.user.activate','slug')}}";
                        var uri = uri.replace('slug',slug);
                        $.ajax({
                            url : uri,
                            type : 'POST',
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function (response) {
                                Swal.fire('Account activation success!', '', 'success');
                                active = response.slug;
                                usersTbl.draw(false);
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });
                    }
                })
            }
        })

    </script>
@endsection