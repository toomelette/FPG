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
        </tr>
        </thead>
        <tbody>
            @forelse($submenu->usersWithAccess as $userWithAccess)
                <tr>
                    <td>{{$userWithAccess?->user?->username}}</td>
                    <td>{{$userWithAccess?->user?->employee?->full['LFEMi']}}</td>
                    <td>{{$userWithAccess?->user?->employee?->plantilla->position ?? $userWithAccess?->user?->employee?->position}}</td>
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

    </script>
@endsection