
<aside class="main-sidebar">
    <style>
        .front_face{
            max-height: 50px;
        }
        .front_face .content{
            padding-top: 0;
        }
        #awselect_sidenav_selector .icon{
            top: 10px;
        }
        .awselect_bg{
            z-index: 5;
        }
    </style>

  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
          @if(!empty(Auth::user()->employee))
              @if(file_exists(public_path('images/EmployeePics/1by1Low/'.Auth::user()->employee->employee_no.'.jpg')))
                    <img src="{{asset('images/EmployeePics/1by1Low/'.Auth::user()->employee->employee_no.'.jpg')}}" class="img-circle" alt="User Image">
              @else
                  <img src="{{asset('images/avatar.jpeg')}}" class="img-circle" alt="User Image">
              @endif
            @else
            <img src="{{asset('images/avatar.jpeg')}}" class="img-circle" alt="User Image">
          @endif
      </div>
      <div class="pull-left info">

        @if(Auth::check())
              <p>
                {!! strtoupper(Helper::getUserName()['firstname']) !!}
            </p>
        @endif
            @if(!empty(\Illuminate\Support\Facades\Auth::user()->employee))
                @if(Auth::user()->employee->biometric_user_id != 0 || Auth::user()->employee->biometric_user_id != '' || Auth::user()->employee->biometric_user_id != null)
                    @php
                        $last_dtr = \App\Models\DTR::query()->where('timestamp','like','%'.\Illuminate\Support\Carbon::now()->format('Y-m-d').'%')
                        ->where('user',Auth::user()->employee->biometric_user_id)
                        ->where('type',10)
                        ->first();
                    @endphp
                    @if(!empty($last_dtr))
                        <small>AM IN: </small><small class="label bg-green">{{\Illuminate\Support\Carbon::parse($last_dtr->timestamp)->format('h:i A')}}</small>
                    @endif
                @endif
            @endif
      </div>
    </div>
    <style>

    </style>
    <ul class="sidebar-menu" data-widget="tree" id="myMenu">
        <div class="sidebar-form">
            <div class="input-group">
                <input id="mySearch" type="text" onkeyup="searchSidenav()" class="form-control" placeholder="Search menu...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </div>


      @if(Auth::check())
            <li class="@if('dashboard.home' == Route::currentRouteName()) active @endif" id="home-nav" >
                <a href="{{route('dashboard.home')}}">
                    <i class="fa fa-home"></i>
                    <span>Home</span>
                </a>
            </li>
        @if(count($tree) > 0)
            @php($tree_copy = $tree)
            @php(ksort($tree_copy))
                <li class="header" id="sidenav_search_header" style="display: none; background-color: #024850; color: white"><i class="fa fa-search"></i> SEARCH:</li>
            @foreach($tree as $category=>$menus)

                @if(count($menus) > 0)
                    @if($category != 'U')
                        <li class="header header-group">{!! __html::sidenav_labeler($category) !!}</li>
                    @endif
                @endif
                @php($done = [])
                @foreach($menus as $menu_id => $menu_content)
                    @if($menu_content['menu_obj']->is_menu == true)
                        @if($menu_content['menu_obj']->is_dropdown == false)

                        @else



                                    <li class="treeview ">
                                        <a href="#" searchable="{{$menu_content['menu_obj']->name}} {{$menu_content['menu_obj']->tags}} {{$menu_content['menu_obj']->category}} {!! \App\Swep\ViewHelpers\__html::sidenav_labeler($menu_content['menu_obj']->category) !!}">
                                        <i class="fa {{$menu_content['menu_obj']->icon}}"></i> <span>{{$menu_content['menu_obj']->name}}</span>
                                        <span class="pull-right-container">
                                             <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                        </a>
                                        <ul class="treeview-menu">
                                            @if(count($menu_content['submenus']) > 0)
                                                @php(ksort($menu_content['submenus']))
                                                @foreach($menu_content['submenus'] as $submenu)
                                                    @if($submenu->is_nav == true)

                                                        <li class="{!! Route::currentRouteNamed($submenu->route) ? 'active tree_active' : '' !!}">
                                                            <a href="{{ route($submenu->route) }}"><i class="fa fa-caret-right"></i> {!!$submenu->nav_name!!}</a>
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
                <li class="header header-group">RELATED LINKS</li>
                <li class="">
                    <a href="http://ppbtms.sra.gov.ph/"  style="color:#9aefff" target="_blank" searchable="PROPERTY AND PROCUREMENT">
                        <i class="fa fa-external-link"></i>ppbtms.sra.gov.ph
                    </a>
                </li>

                <li class="">
                    <a href="http://budget.sra.gov.ph/" style="color:#9aefff" target="_blank" searchable="BUDGET">
                        <i class="fa fa-external-link"></i>budget.sra.gov.ph
                    </a>
                </li>

                @if(Auth::user()->project_id == 1)

                    <li class="">
                        <a href="http://acctg.sra.gov.ph/" style="color:#9aefff" target="_blank" searchable="ACCOUNTING">
                            <i class="fa fa-external-link"></i>acctg.sra.gov.ph
                        </a>
                    </li>

                    <li class="">
                        <a href="https://legal.sra.gov.ph/" style="color:#9aefff" target="_blank" searchable="LEGAL">
                            <i class="fa fa-external-link"></i>legal.sra.gov.ph
                        </a>
                    </li>

                    <li class="">
                        <a href="http://gfps.sra.gov.ph/" style="color:#9aefff" target="_blank" searchable="GFPS GAD">
                            <i class="fa fa-external-link"></i>gfps.sra.gov.ph
                        </a>
                    </li>
                @endif
        @endif
      @endif

    </ul>
  </section>
</aside>