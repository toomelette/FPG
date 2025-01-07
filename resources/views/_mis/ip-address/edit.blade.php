@php
$rand = Str::random();
 @endphp
@extends('adminkit.modal',[
    'id' => 'edit-ip-address-form-'.$rand,
    'slug' => $ip->slug,
])

@section('modal-header')
    Edit
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="User" name="user" :value="$ip ?? null" cols="8"/>
        <x-forms.input label="Employee No" name="employee_no" :value="$ip ?? null" cols="4"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Property No" name="property_no" :value="$ip ?? null" cols="6"/>
        <x-forms.select label="Location" name="location" :value="$ip ?? null" cols="6 col-xs-6" :options="\App\Swep\Helpers\Helper::populateOptionsFromObjectAsArray(\App\Models\SuOptions::ipAddressLocations(),'option','value')"/>
    </div>
    IP ADDRESS:
    <div class="row mb-2">
        <x-forms.input label="1st Octet" name="octet_1" :value="$ip ?? null" cols="3 col-sm-3 col-xs-3" type="number" :value="10"/>
        <x-forms.input label="2nd Octet" name="octet_2" :value="$ip ?? null" cols="3 col-sm-3 col-xs-3" type="number" :value="36"/>
        <x-forms.input label="3rd Octet" name="octet_3" :value="$ip ?? null" cols="3 col-sm-3 col-xs-3" type="number" />
        <x-forms.input label="4th Octet" name="octet_4" :value="$ip ?? null" cols="3 col-sm-3 col-xs-3" type="number" />
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-ip-address-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.ip_address.update","slug")}}';
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
                    ipAddressTbl.draw(false);
                    toast('info','Ip address successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection