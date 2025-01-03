@php
    $rand = Str::random();
    /** @var \App\Models\DocumentFolder $folder  **/
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-folder-form-'.$rand,
    'slug' => $folder->slug,
])

@section('modal-header')

@endsection

@section('modal-body')
    @if(($folder->documents1_count + $folder->documents2_count) < 1)
    <div class="row mb-2">
        <x-forms.input name="folder_code" cols="12" label="Folder Code" :value="$folder"/>
    </div>
    @endif
    <div class="row mb-2">
        <x-forms.input name="description" cols="12" label="Description" :value="$folder"/>
    </div>
    <div class="row mb-2">
        <x-forms.select name="retention_period" cols="12" label="Retention Period" :value="$folder" :options="\App\Swep\Helpers\Arrays::retentionPeriods()"/>
    </div>
    <div class="row mb-2">
        <x-forms.checkbox name="is_permanent" cols="12" label="Temporary/Permanent" type="radio" class="temp_perm" each-class="6" :options="[
                    '0' => 'Temporary',
                    '1' => 'Permanent',
                ]"
                          :value="[
                $folder->is_permanent
            ]"
        />
    </div>
    <div class="row mb-2">
        <x-forms.input name="remarks" cols="12" label="Remarks" :value="$folder"/>
    </div>




@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-folder-form-{{$rand}}").submit(function (e) {
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
                    foldersTbl.draw(false);
                    toast('info','Folder successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
    </script>
@endsection