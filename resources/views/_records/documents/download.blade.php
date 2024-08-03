@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Download / Export Documents</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <form action="{{route('dashboard.document.download')}}" method="POST">
            @csrf

                <div class="row mb-2">
                    <x-forms.select label="Create folders by" name="type" cols="2" :options="[
                                'by_year' => 'Year',
                                'by_to' => 'Recipient',
                                'by_from' => 'Sender',
                                'by_folder_code' => 'Folder Code',
                                'by_document_type' => 'Document Type',
                            ]"/>
                    <x-forms.input label="Date from" name="date_from" cols="2" type="date"/>
                    <x-forms.input label="Date to" name="date_to" cols="2" type="date"/>
                    <x-forms.select label="Person from" name="person_from" class="select2_person_to_ajax" cols="2" />
                    <x-forms.select label="Person to" name="person_to" class="select2_person_to_ajax" cols="2" />
                    <x-forms.select label="Document Type" name="document_type" cols="2" :options="__static::document_types(true)"/>
                </div>
                <div class="clearfix">
                    <button type="submit" class="btn btn-sm btn-primary float-end"> <i class="fa fa-download"></i> Download </button>
                </div>

        </form>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $(".select2_person_to_ajax").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","document_person_to")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });

        $(".select2_person_from_ajax").select2({
            ajax: {
                url: '{{route("dashboard.ajax.get","document_person_from")}}',
                dataType: 'json',
                delay : 250,
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
        });

    </script>
@endsection