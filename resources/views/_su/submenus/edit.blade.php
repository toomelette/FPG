@php
    $rand = Str::random();
    /** @var \App\Models\Submenu $submenu **/
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-submenu-form-'.$rand,
    'slug' => $submenu->slug,
])

@section('modal-header')
    {{$submenu->name}} | <small>{{$submenu->route}}</small>
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Name" name="name" cols="12" :value="$submenu ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Nav Name" name="nav_name" cols="12" :value="$submenu ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Route" name="route" cols="12" :value="$submenu ?? null"/>
    </div>
    <x-forms.checkbox name="is_nav" cols="12" label="Is Nav" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
     :value="[$submenu->is_nav ?? null]"/>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-submenu-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.submenu.update",$submenu->slug)}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    active = res.slug;
                    submenusTbl.draw(false);
                    toast('info','Submenu successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection