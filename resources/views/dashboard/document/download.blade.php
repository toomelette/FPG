@extends('layouts.admin-master')

@section('content')

    <section class="content-header">
        <h1>Download / Export Documents</h1>
    </section>
@endsection
@section('content2')

    <section class="content">
        <div class="box box-solid">
            <form action="{{route('dashboard.document.download')}}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="row">
                        {!!
                            \App\Swep\FormHelpers\__select::make()
                                ->name('type')
                                ->label('Create folders by')
                                ->cols(2)
                                ->options([
                                    'by_year' => 'Year',
                                    'by_to' => 'Recipient',
                                    'by_from' => 'Sender',
                                    'by_folder_code' => 'Folder Code',
                                    'by_document_type' => 'Document Type',
                                ])
                                ->render()
                        !!}
                        {!!
                            \App\Swep\FormHelpers\__textbox::make()
                                ->name('date_from')
                                ->label('Date From')
                                ->type('date')
                                ->cols(2)
                                ->render()
                        !!}
                        {!!
                            \App\Swep\FormHelpers\__textbox::make()
                                ->name('date_to')
                                ->label('Date To')
                                ->type('date')
                                ->cols(2)
                                ->render()
                        !!}
                        {!!
                            \App\Swep\FormHelpers\__select::make()
                                ->name('person_from')
                                ->label('Person From')
                                ->cols(2)
                                ->options([])
                                ->class('select2_person_to_ajax')
                                ->render()
                        !!}
                        {!!
                            \App\Swep\FormHelpers\__select::make()
                                ->name('person_to')
                                ->label('Person To')
                                ->cols(2)
                                ->options([])
                                ->class('select2_person_to_ajax')
                                ->render()
                        !!}
                        {!!
                            \App\Swep\FormHelpers\__select::make()
                                ->name('document_type')
                                ->label('Document Type')
                                ->cols(2)
                                ->options(__static::document_types(true))
                                ->render()
                        !!}
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-md-offset-11">
                            <button type="submit" class="btn btn-sm btn-primary pull-right"> <i class="fa fa-download"></i> Download </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </section>

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