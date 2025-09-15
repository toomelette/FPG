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
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="well">
                    <x-adminkit.html.alert type="info" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Departure Details
                    </x-adminkit.html.alert>
                    <div class="well-body">
                        <p class="page-header-sm text-info text-strong mb-1" style="border-bottom: 1px solid #cedbe1">
                            Departure Details
                        </p>
                        <div class="row mb-2">
                            <x-forms.select label="Departure Airport" name="start_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Date" type="date" name="departure_date" cols="6"/>
                            <x-forms.input label="Time" type="time" name="departure_time" cols="6"/>
                        </div>
                        <div class="row">
                            <x-forms.input label="Flight No."  name="departure_flight_no" cols="6"/>
                            <div class="form-group  col-md-6  ">
                                <label for="">Layover:</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input with-layover" type="checkbox" name="with-layover">
                                    <label class="form-check-label" >With layover</label>
                                </div>
                            </div>
                        </div>

                        <div class="layover">
                            <fieldset>
                                <p class="page-header-sm text-info text-strong mt-3 mb-1" style="border-bottom: 1px solid #cedbe1">
                                    Layover Details
                                </p>
                                <div class="row mb-2">
                                    <x-forms.select label="Layover Airport" name="layover_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Date" type="date" name="layover_date" cols="6"/>
                                    <x-forms.input label="Time" type="time" name="layover_time" cols="6"/>
                                </div>
                                <div class="row mb-2">
                                    <x-forms.input label="Flight No."  name="layover_flight_no" cols="6"/>
                                </div>
                            </fieldset>
                        </div>

                        <p class="page-header-sm text-info text-strong mt-3 mb-1" style="border-bottom: 1px solid #cedbe1">
                            Destination Details
                        </p>
                        <div class="row">
                            <x-forms.select label="Destination Airport" name="end_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="well">
                    <x-adminkit.html.alert type="warning" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                        Return Trip Details
                    </x-adminkit.html.alert>
                    <div class="well-body">
                        <p class="page-header-sm text-info text-strong mb-1" style="border-bottom: 1px solid #cedbe1">
                            Departure Details
                        </p>
                        <div class="row mb-2">
                            <x-forms.select label="Departure Airport" name="return_start_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Date" type="date" name="return_departure_date" cols="6"/>
                            <x-forms.input label="Time" type="time" name="return_departure_time" cols="6"/>
                        </div>
                        <div class="row">
                            <x-forms.input label="Flight No."  name="return_departure_flight_no" cols="6"/>
                        </div>

                        <p class="page-header-sm text-info text-strong mt-3 mb-1" style="border-bottom: 1px solid #cedbe1">
                            Layover Details
                        </p>
                        <div class="row mb-2">
                            <x-forms.select label="Layover Airport" name="return_layover_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Date" type="date" name="return_layover_date" cols="6"/>
                            <x-forms.input label="Time" type="time" name="return_layover_time" cols="6"/>
                        </div>
                        <div class="row mb-2">
                            <x-forms.input label="Flight No."  name="return_layover_flight_no" cols="6"/>
                        </div>

                        <p class="page-header-sm text-info text-strong mt-3 mb-1" style="border-bottom: 1px solid #cedbe1">
                            Destination Details
                        </p>
                        <div class="row">
                            <x-forms.select label="Destination Airport" name="return_end_airport" :options="\App\Swep\Helpers\Arrays::airports()" class="select2" cols="12"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-8">
                <x-adminkit.html.alert type="success" :dismissible="false" :with-icon="false" body-class="p-1 text-center text-strong">
                    Passenger Information
                </x-adminkit.html.alert>

                <table class="table table-bordered table-sm" id="passengers-tbl">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width: 15%;">Birthday</th>
                        <th style="width: 15%;">Phone</th>
                        <th style="width: 22%;">Email</th>
                        <th style="width: 12%;">Seat</th>
                        <th style="width: 50px"></th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="6" class="text-center"><a href="#" id="add-passenger-btn"><i class="fa fa-plus"></i> Add passenger</a></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </x-adminkit.html.card>

    <table style="display:none;">
        <tbody id="passenger-row-template">
        <tr>
            <td>
                <x-forms.select label="" :options="[]" name="passenger[rand][]" class="select-employee-rand select-employee" cols="12" :select-only="true"/>
            </td>
            <td>
                <x-forms.input label="" name="passenger[rand][]" for="birthday" type="date" cols="12" :input-only="true"/>
            </td>
            <td>
                <x-forms.input label="" name="passenger[rand][]" for="phone" cols="12" :input-only="true"/>
            </td>
            <td>
                <x-forms.input label="" name="passenger[rand][]" for="email" cols="12" :input-only="true"/>
            </td>
            <td>
                <x-forms.select label="" name="passenger[rand][]"  cols="12" :options="\App\Swep\Helpers\Arrays::seats()" :select-only="true"/>
            </td>
            <td>
                <button type="button" class="btn btn-danger remove_row_btn"><i class="fa fa-times"></i></button>
            </td>
        </tr>
        </tbody>
    </table>

@endsection


@section('modals')

@endsection

@section('scripts')
    <script type="text/javascript">

        function addPassenger(){
            let template = $("#passenger-row-template").html();
            let rand = makeId(10);
            template = template.replaceAll('rand',rand);
            $("#passengers-tbl tbody").append(template).ready(function (){
                $(".select-employee-"+rand).select2({
                    data : {!! $employees !!},
                    tags: true
                });

                $('.select-employee-'+rand).on('select2:select', function (e) {
                    let data = e.params.data;
                    let row = $(this).parents('tr');
                    row.find('input[for="email"]').val(data.email);
                    row.find('input[for="phone"]').val(data.phone);
                    row.find('input[for="birthday"]').val(data.birthday);
                });
            });
        }
        addPassenger();


        $("#add-passenger-btn").click(function (e){
            e.preventDefault();
            addPassenger();
        })

        $(".with-layover").change(function (){
            if($(this).prop('checked')){

            }
        })
    </script>
@endsection