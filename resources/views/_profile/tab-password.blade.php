<div class="card">
    <div class="card-body">
        <h5 class="card-title">Password & Login</h5>
        <div class="row">
            <div class="col-md-3">
                <h4>Change Password</h4>
                <form id="change-pass-form">

                    <div class="row">
                        <x-forms.input label="Current Password" name="old_pass" cols="12 mb-3" type="password"/>
                        <x-forms.input label="New Password" name="new_pass" cols="12 mb-3" type="password"/>
                        <x-forms.input label="Verify New Password" name="new_pass2" cols="12 mb-3" type="password"/>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save changes</button>
                </form>
            </div>
            <div class="col-md-9">
                <h4>Currently Logged-in Devices</h4>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Browser</th>
                        <th>IP Address</th>
                        <th>Last Activity</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sessions as $session)
                        @php
                            $agent = new \Jenssegers\Agent\Agent();
                            $agent->setUserAgent($session->user_agent)
                         @endphp
                        <tr>
                            <td>
                                @if($agent->isMobile())
                                    <i class="align-middle me-2 fas fa-fw fa-mobile-alt"></i> -
                                @endif
                                @if($agent->isDesktop())
                                    <i class="align-middle me-2 fas fa-fw fa-desktop"></i> -
                                @endif
                                <i class="align-middle  fab fa-fw fa-{{strtolower($agent->platform())}}"></i> {{$agent->platform()}} | <i class="align-middle  fab fa-fw fa-{{strtolower($agent->browser())}}"></i> {{$agent->browser()}}
                                @if(request()->session()->getId() == $session->id)
                                    <span class="badge bg-success float-end">CURRENT</span>
                                @endif
                            </td>
                            <td>{{$session->ip_address}}</td>
                            <td>{{Carbon::createFromTimestamp($session->last_activity)->format('D, M. d, Y | h:i A')}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger sign-out-btn" data="{{$session->id}}"><i class="fa fa-sign-out"></i> Sign out </button>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>