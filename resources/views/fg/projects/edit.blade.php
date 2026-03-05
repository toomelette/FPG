@php
    $rand = randString();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-client-form-'.$rand,
    'slug' => $project->uuid,
])

@section('modal-header')
    Edit {{$project->name}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.select label="Client" name="client_uuid" id="select2-clients-{{$rand}}" cols="12" :options="[]" :value="$project ?? null" select2-preselected="{{$project->client->name}} - {{$project->client->account_no}}"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Project" name="project_name" cols="8" :value="$project ?? null"/>
        <x-forms.input label="Project Code" name="project_code" cols="4" :value="$project ?? null"/>
    </div>

    <div class="row mt-2">
        <x-forms.input label="Delivery Address" name="delivery_address" cols="8" :value="$project ?? null"/>
        <x-forms.input label="Delivery Date" name="delivery_date" cols="4" type="date" :value="$project ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.input label="Date Started" name="date_started" cols="4" type="date" :value="$project ?? null"/>
    </div>
    <div class="row mt-2">
        <x-forms.textarea label="Details" name="details" cols="12" :value="$project ?? null"/>
    </div>

    <div class="row mt-2">
        <x-forms.input label="Project Amount" name="project_amount" class="autonum-{{$rand}}"  cols="6" :value="$project ?? null"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        $("#edit-client-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("projects.update", $project->uuid)}}',
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('success','Project successfully updated.','Success');
                    active = res.uuid;
                    projectsTbl.draw(false);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })

        $("#select2-clients-{{$rand}}").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","clients")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            dropdownParent: $("#select2-clients-{{$rand}}").closest('.modal'),
        });

        initializeAutonumByClass('.autonum-{{$rand}}');

    </script>
@endsection