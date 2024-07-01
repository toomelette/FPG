@php
$rand = Str::random();
@endphp
@extends('layouts.modal-content',['form_id' => 'edit_folder_form_'.$rand, 'slug' => $docFolder->slug])

@section('modal-header')
    {{$docFolder->folder_code}} <br>

@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input
                name="description"
                cols="12"
                label="Description"
                :value="$docFolder"
        />

        <x-forms.select
                name="retention_period"
                cols="12"
                label="Retention Period"
                :value="$docFolder"
                :options="[
                    '12' => '1 Year',
                    '24' => '2 Years',
                    '36' => '3 Years',
                    '48' => '4 Years',
                    '60' => '5 Years',
                ]"
        />
        <x-forms.checkbox
                name="is_permanent"
                cols="12"
                label="Temporary/Permanent"
                type="radio"
                class="temp_perm"
                each-class="6"
                :options="[
                    '0' => 'Temporary',
                    '1' => 'Permanent',
                ]"
                :value="[
                    $docFolder->is_permanent
                ]"
        />
    </div>

@endsection

@section('modal-footer')
        <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('.temp_perm').iCheck({
            checkboxClass: 'icheckbox_flat-blue checkbox-counter',
            radioClass   : 'iradio_flat-green'
        })
        
        $("#edit_folder_form_{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.document_folder.update","slug")}}';
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
                    df_tbl.draw(false);
                    toast('info','','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        
        })
    </script>
@endsection

