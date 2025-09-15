@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>New Flight Booking Request</x-slot:title>
        <x-slot:subtitle></x-slot:subtitle>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pb-1 pt-3">
        <x-slot:title>
            <button type="submit" class="btn btn-primary btn-sm float-end"><i class="fa fa-check"></i> Save</button>
        </x-slot:title>
        <div class="row">
            <div class="col-md-3">
                <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                    Requester Information
                </x-adminkit.html.alert>

                <div class="row">
                    <x-forms.input label="Name" name="requested_by" cols="12"/>
                </div>
            </div>
        </div>

    </x-adminkit.html.card>


@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">


    </script>
@endsection