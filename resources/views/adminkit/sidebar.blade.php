<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">HRRS</span>
        </a>
        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    @if(!empty(Auth::user()->employee))
                        @if(file_exists(public_path('images/EmployeePics/1by1Low/'.Auth::user()->employee->employee_no.'.jpg')))
                            <img src="{{asset('images/EmployeePics/1by1Low/'.Auth::user()->employee->employee_no.'.jpg')}}" class="avatar img-fluid rounded me-1" alt="User Image">
                        @else
                            <img src="{{asset('images/avatar.jpeg')}}" class="avatar img-fluid rounded me-1" alt="User Image">
                        @endif
                    @else
                        <img src="{{asset('images/avatar.jpeg')}}" class="avatar img-fluid rounded me-1" alt="User Image">
                    @endif
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title" href="#"  aria-expanded="false">
                        {{ strtoupper(Auth::user()->employee->firstname ?? Auth::user()->firstname) }}
                    </a>


                    <div class="sidebar-user-subtitle"><small>{{ Auth::user()->employee->platilla->position ?? Auth::user()->employee->position ?? 'N/A' }}</small></div>
                </div>
            </div>
        </div>

        <ul class="sidebar-nav">

            @if(Auth::check())
                <li class="@if('dashboard.home' == Route::currentRouteName() ) sidebar-item active @endif" id="home-nav" >
                    <a class="sidebar-link" href="{{route('dashboard.home')}}">
                        <i class="align-middle fa fa-tachometer-alt" ></i> <span class="">Dashboard</span>
                    </a>
                </li>

                @if(count($tree) > 0)
                    @php($tree_copy = $tree)
                    @php(ksort($tree_copy))

                    @foreach($tree as $category=>$menus)

                        @if(count($menus) > 0)
                            @if($category != 'U')
                                <li class="sidebar-header">
                                    {!! __html::sidenav_labeler($category) !!}
                                </li>
                            @endif
                        @endif
                        @foreach($menus as $menu_id => $menu_content)

                            @if($menu_content['menu_obj']->is_menu == true)

                                @if($menu_content['menu_obj']->is_dropdown == false)

                                @else
                                    <li class="sidebar-item">
                                        <a data-bs-target="#{{str_replace(' ','',$menu_content['menu_obj']->name)}}" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
                                            <i class="fa {{$menu_content['menu_obj']->icon}} me-1 feather feather-layout align-middle"></i>
                                            <span class="">{{$menu_content['menu_obj']->name}}</span>
                                        </a>
                                        <ul id="{{str_replace(' ','',$menu_content['menu_obj']->name)}}" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="">
                                            @if(count($menu_content['submenus']) > 0)
                                                @foreach($menu_content['submenus'] as $submenu)
                                                    @if($submenu->is_nav == true)
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="{{ route($submenu->route) }}">{!!$submenu->nav_name!!}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                @endif
                            @endif
                        @endforeach


                    @endforeach
                @endif
            @endif





    </div>
</nav>