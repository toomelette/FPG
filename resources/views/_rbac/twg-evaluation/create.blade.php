@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>TWG Evaluation</x-slot:title>
        <x-slot:float-end></x-slot:float-end>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card header-class="pb-1 pt-3">
        <form id="find-aq-form">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="lastname">AQ No.:</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="aq_no" placeholder="Enter AQ No." >
                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </x-adminkit.html.card>
@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">
        $("#find-aq-form").submit(function (e){
            e.preventDefault();
            $.ajax({
                url : '{{route("dashboard.rbac_evaluation.create")}}?getAq=true',
                data : $(this).serialize(),
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    slug = res.slug;
                    link = '{{route('dashboard.rbac_evaluation.edit','slug')}}';
                    link = link.replace('slug',slug);
                    window.location.href = link;
                },
                error: function (res) {
             
                }
            })
        })

    </script>
@endsection