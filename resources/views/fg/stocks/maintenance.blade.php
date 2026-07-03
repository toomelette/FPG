@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Stocks Settings</x-slot:title>
    </x-adminkit.html.page-title>

    <form id="update-options-form">
        <x-adminkit.html.card header-class="pt-3 pb-1" body-class="pt-2">
            <x-slot:title>
                <button class="btn btn-sm btn-primary float-end" type="submit"><i class="fa fa-check"></i> Save</button>
            </x-slot:title>

            <div class="form-group  col-md-12 categories">
                <label for="lastname">Categories:</label>
                <input type="text" name="categories" value="{{implode(',',\App\Swep\Helpers\Arrays::productCategories())}}" data-role="tagsinput" id="categories" />
            </div>

            <div class="form-group  col-md-12 uoms mt-2">
                <label for="lastname">Unit of Measurements:</label>
                <input type="text" name="uoms" value="{{implode(',',\App\Swep\Helpers\Arrays::uoms())}}" data-role="tagsinput" id="uoms" />
            </div>
        </x-adminkit.html.card>
    </form>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#categories").tagsinput({
            trimValue: true
        });

        $('#categories').on('beforeItemAdd', function(event) {
            event.item = event.item.toUpperCase();
        });

        $("#uoms").tagsinput({
            trimValue: true
        });

        $('#uoms').on('beforeItemAdd', function(event) {
            event.item = event.item.toUpperCase();
        });

        $('.bootstrap-tagsinput input').on('input', function () {
            this.value = this.value.toUpperCase();
        });

        $('#update-options-form').on('submit', function(e) {
            let isTypingTag = $('.bootstrap-tagsinput input').is(':focus');

            if (isTypingTag) {
                e.preventDefault(); // stop form submit ONLY when typing tags
            }else{
                e.preventDefault();
                let form = $(this);
                let uri = '{{route("stocks.update","x")}}?maintenance';
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
                        succeed(form,false,false);
                        toast('info','Data successfully updated.','Updated');
                    },
                    error: function (res) {
                        errored(form,res);
                    }
                })
            }
        });

    </script>
@endsection