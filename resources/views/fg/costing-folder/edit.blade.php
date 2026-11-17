@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-folder-form-'.$rand,
    'slug' => $folder->uuid,
])

@section('modal-header')
    Edit {{$folder->folder_code}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Folder Code" name="folder_code" cols="12" :value="$folder ?? null" />
    </div>

    <div class="row mt-2">
        <x-forms.input label="Description" name="description" cols="12" :value="$folder ?? null" />
    </div>

    @if(filled($folder->parent_folder_uuid))
        <div class="row mt-2">
            <x-forms.select label="Branch" name="project_id" cols="12" :options="\App\Swep\Helpers\Arrays::projectIds()" :value="$folder ?? null" />
        </div>
    @endif

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-folder-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("costing-folder.update","slug")}}';
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
                    active = res.uuid;
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