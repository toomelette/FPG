@php
    $rand = Str::random();
    /** @var \App\Models\Menu $menu **/
 @endphp
@extends('adminkit.modal',[
'id' => 'edit-menu-form-'.$rand,
'slug' => $menu->slug,
])

@section('modal-header')
    {{$menu->name}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Name" name="name" cols="12" :value="$menu ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Route" name="route" cols="12" :value="$menu ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Category" name="category" cols="12" :value="$menu ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.checkbox name="is_menu" cols="6" label="Is Menu" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
         :value="[$menu->is_menu ?? null]"/>
        <x-forms.checkbox name="is_dropdown" cols="6" label="Is Dropdown" type="checkbox"  each-class="6" :options="[
                    '1' => 'Yes',
                ]"
         :value="[$menu->is_dropdown ?? null]"/>
    </div>
    <div class="row mb-3">
        <x-forms.select label="Portal" name="portal" cols="12" :options="\App\Swep\Helpers\Arrays::portals()" :value="$menu ?? null"/>
    </div>

@endsection

@section('modal-footer')
<button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
<script type="text/javascript">
    $("#edit-menu-form-{{$rand}}").submit(function (e) {
        e.preventDefault();
        let form = $(this);
        let uri = '{{route("dashboard.menu.update","slug")}}';
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
                menusTbl.draw(false);
                toast('info','Menu successfully updated.','Updated');
            },
            error: function (res) {
                errored(form,res);
            }
        })
    
    })
</script>
@endsection