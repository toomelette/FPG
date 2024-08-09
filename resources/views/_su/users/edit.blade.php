@extends('adminkit.master')

@section('content2')
    <form id="edit-user-form">
        <x-adminkit.html.page-title>
            <x-slot:title>{{$user?->employee?->full['LFEMi']}}</x-slot:title>
            <x-slot:subtitle>Edit Access</x-slot:subtitle>
            <x-slot:float-end><button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-check"></i> Save</button></x-slot:float-end>
        </x-adminkit.html.page-title>


        <div class="row">
        <div class="col-md-3 col-xl-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">User Access</h5>
                </div>

                <div class="list-group list-group-flush" role="tablist">
                    <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#account" role="tab" aria-selected="true">
                        Access
                    </a>
                    @forelse($portals as $portal => $menus)
                        <a class="list-group-item list-group-item-action count-options" data-bs-toggle="list" href="#portal-{{$loop->iteration}}" role="tab" aria-selected="false" tabindex="-1">
                            {{$portal == '' ? 'SU' : $portal}} <span class="badge bg-success float-end"></span>
                        </a>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="tab-content">
                <div class="tab-pane fade active show" id="account" role="tabpanel">
                    <x-adminkit.html.card>
                        <div class="row">
                            <div class="col-4">
                                <x-adminkit.html.alert type="success mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                    Access to Employees
                                </x-adminkit.html.alert>
                                <div class="row">
                                    @foreach(\App\Swep\Helpers\Arrays::accessToEmployees() as $item)
                                        <div class="col-md-6">
                                            <div class="checkbox no-margin" >
                                                <label>
                                                    <input type="checkbox" name="accessToEmployees[]" value="{{$item}}" {{(in_array($item, $user->getAccessToEmployees())) ? 'checked' : ''}}> {{$item}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-8">
                                <x-adminkit.html.alert type="info mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                    Settings
                                </x-adminkit.html.alert>

                               <div class="row">
                                   <x-forms.select label="Project ID" name="project_id" cols="3" :options="[
                                           1 => 1,
                                           2 => 2,
                                       ]"
                                        :value="$user->project_id ?? null"
                                   />

                                   <x-forms.select label="PMS" name="pms_allowed" cols="3" :options="[
                                           1 => 1,
                                       ]"
                                       :value="$user->pms_allowed ?? null"
                                   />
                               </div>


                            </div>
                        </div>
                    </x-adminkit.html.card>
                </div>
                @forelse($portals as $portal => $menus)
                    @php
                        $groupedByCategory = $menus->sort()->groupBy('category');
                    @endphp
                    <div class="tab-pane fade" id="portal-{{$loop->iteration}}" role="tabpanel">
                        <div class="tab tab-vertical">
                            <ul class="nav nav-tabs" role="tablist">
                                @forelse($groupedByCategory as $category => $menusUnderCategory)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link tab-item {{$loop->first ? 'active' : ''}}" style="border: none;" href="#tab-{{$loop->parent->iteration}}-{{$loop->iteration}}" data-bs-toggle="tab" role="tab" aria-selected="true">
                                            {{$category}} <span class="badge bg-primary float-end ms-3"></span>
                                        </a>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                            <div class="tab-content" style="border: none">

                                @forelse($groupedByCategory as $category => $menusUnderCategory)
                                    @php
                                        $menusUnderCategory = $menusUnderCategory->sortBy('name');
                                    @endphp
                                    <div class="tab-pane {{$loop->first ? 'active' : ''}}" id="tab-{{$loop->parent->iteration}}-{{$loop->iteration}}" role="tabpanel">
                                        <h4 class="tab-title">{{$category}}</h4>
                                        <div class="row row-cols-3">
                                            @forelse($menusUnderCategory as $menu)
                                                @if($menu->route == 'dashboard.home')
                                                    <div class="col mb-4">
                                                        <x-adminkit.html.alert type="primary mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                                            {{$menu->name}}
                                                        </x-adminkit.html.alert>
                                                        <div class="row">
                                                            <x-forms.select label="Dashboard Type" name="dash_type" cols="12" :options="[
                                                                    'hru' => 'HRU Dashboard',
                                                                    'records' => 'RECORDS Dashboard',
                                                                ]"
                                                               :value="$user->dash"
                                                            />
                                                        </div>
                                                    </div>
                                                @else
                                                <div class="col mb-4">
                                                    <x-adminkit.html.alert type="primary mb-1" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                                                        {{$menu->name}}
                                                    </x-adminkit.html.alert>
                                                    <select multiple="" name="submenus[{{$menu->menu_id}}][]" class="form-control select_multiple" size="10">
                                                        @if($menu->submenu->count() > 0)
                                                            @foreach($menu->submenu as $submenu)
                                                                <option value="{{$submenu->submenu_id}}" @if(isset($user_submenus_arr[$submenu->submenu_id])) selected @endif>
                                                                    {{$submenu->name}}
                                                                </option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                </div>
                                                @endif
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                @empty
                                @endforelse







                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </div>

    </form>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        function updatePortalBadge(){
            $(".count-options").each(function (){
                let li = $(this);
                let targetCardId = li.attr('href');
                let len = $(targetCardId+" option:selected").length;
                li.find('.badge').html(len);
            })
        }
        function updateTabs(){
            $(".tab-item").each(function (){
                let navLink = $(this);
                let targetPane = navLink.attr('href');
                let len = $(targetPane+" option:selected").length;
                navLink.find('.badge').html(len);
            })
        }

        $('select[multiple]').select2('destroy');
        $("#edit-user-form").submit(function (e) {
            e.preventDefault();
            uri = "{{route('dashboard.user.update', $user->slug)}}";
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type : 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success : function (response) {
                    toast("info","Changes were saved successfully.", "Success");
                    succeed(form, false,false);
                    window.location = '{{route('dashboard.user.index')}}';
                },
                error: function (response) {
                    errored(form,res);
                }
            })
        })
        $("#edit-user-form select[multiple]").change(function (){
            updatePortalBadge();
            updateTabs();
        })
        updatePortalBadge();
        updateTabs();


    </script>
@endsection