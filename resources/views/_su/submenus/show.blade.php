@php
    $rand = Str::random();
    /** @var \App\Models\Submenu $submenu **/
@endphp
@extends('adminkit.modal')

@section('modal-header')
    {{$submenu->name}} | <small>{{$submenu->route}}</small>
@endsection

@section('modal-body')
    <table class="table table-bordered table-sm">
        <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Position</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @forelse($submenu->usersWithAccess as $userWithAccess)
                <tr id="p-{{$userWithAccess?->id}}">
                    <td>{{$userWithAccess?->user?->username}}</td>
                    <td>{{$userWithAccess?->user?->employee?->full['LFEMi']}}</td>
                    <td>{{$userWithAccess?->user?->employee?->plantilla->position ?? $userWithAccess?->user?->employee?->position}}</td>
                    <td><button type="button" data="{{$userWithAccess?->id}}" class="btn btn-sm btn-outline-danger revoke-btn-{{$rand}}">Revoke</button></td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(".revoke-btn-{{$rand}}").click(function (){
            let btn = $(this);
            let url = '{{route('dashboard.submenu.revoke_permission','slug')}}';
            url = url.replace('slug',btn.attr('data'));
            Swal.fire({
                title: 'Please confirm to revoke this permission from user.',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash"></i> Revoke',
                confirmButtonColor: '#d73925',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (res) {
                            $("#p-"+btn.attr('data')).remove();
                            toast('info','Permission revoked from user','Success!');
                            submenusTbl.draw(false);
                        },
                        error: function (res) {
                            toast('error','Error revoking permission.','Error!');
                        }
                    });
                    // Swal.fire('Saved!', '', 'success')
                }else{
                    btn.parents('#'+slug).removeClass('warning');
                }
            })
        })
    </script>
@endsection