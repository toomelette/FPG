@php
    /** @var \App\Models\Employee $employee **/
 @endphp
@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>{{$employee->full['LFEMi']}}</x-slot:title>
        <x-slot:float-end>{{\App\Swep\Helpers\Arrays::leaveTypeCodes()[$leaveType] ?? ''}}</x-slot:float-end>
    </x-adminkit.html.page-title>
    <div class="row">
        <div class="col-md-4">
            <x-adminkit.html.card body-class="pt-0" style="min-height: 65vh">
                <x-slot:title class="pb-0">
                    Leave Credits
                    <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal" data-bs-target="#add-leave-credit-modal"><i class="fa fa-plus"></i> Add Credits</button>
                </x-slot:title>
                <div class="leave-credits-table-container">
                    <table class="table table-bordered table-sm" id="leave-credits-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Credits</th>
                            <th style="width: 80px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </x-adminkit.html.card>
        </div>

        <div class="col-md-4">
            <x-adminkit.html.card body-class="pt-1" style="min-height: 65vh">
                <x-slot:title class="pb-0">
                    Leave Applications
                </x-slot:title>
                <div class="leave-applications-table-container">
                    <table class="table table-bordered table-sm" id="leave-applications-table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Details</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </x-adminkit.html.card>
        </div>

        <div class="col-md-4">
            <x-adminkit.html.card>
                <x-slot:title>Balances</x-slot:title>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Details</th>
                        <th class="text-center">Add</th>
                        <th class="text-center">Less</th>
                        <th class="text-center">Bal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $begBal = 0;
                    @endphp
                    @forelse($balances as $balance)
                        <tr>
                            <td>{{Helper::dateFormat($balance->date)}}</td>
                            <td class="text-end">{{$balance->add}}</td>
                            <td class="text-end">{{$balance->less}}</td>
                            <td class="text-end">{{Helper::toNumber($begBal = $begBal + $balance->add - $balance->less,3)}}</td>
                        </tr>
                    @empty
                    @endforelse
                    <tr>
                        <td class="text-strong">ENDING BALANCE</td>
                        <td colspan="3" class="text-strong text-end">{{Helper::toNumber($begBal,3)}}</td>
                    </tr>
                    </tbody>
                </table>
            </x-adminkit.html.card>

        </div>
    </div>
@endsection


@section('modals')
    <x-adminkit.html.modal-template id="add-leave-credit-modal" size="sm" form-id="add-leave-credit-form">
        <x-slot:title>Add Credits - {{$leaveType}}</x-slot:title>
        <div class="row mb-2">
            <x-forms.input label="Date" name="date" cols="6" type="date"/>
            <x-forms.input label="Credits" name="credits" cols="6" type="number" step="0.001"/>
        </div>
        <div class="row mb-2">
            <x-forms.input label="Remarks" name="remarks" cols="12"/>
        </div>
        <x-slot:footer>
            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Save</button>
        </x-slot:footer>
    </x-adminkit.html.modal-template>
    <x-adminkit.html.modal id="edit-leave-credit-modal" size="sm"/>
@endsection

@section('scripts')
    <script type="text/javascript">
        let activeLeaveCredits = '';
        leaveCreditsTbl = $("#leave-credits-table").DataTable({
            dom : 'lBrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.leave_card.view_per_leave_type',[$employee->slug,$leaveType])}}?leaveCredits',
            columns: [
                { data : "date" },
                { data : "credits" },
                { data : "action" }
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[

            ],
            order:[[0,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        leaveCredits.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){
                if(activeLeaveCredits != ''){
                    $("#"+settings.sTableId+" #"+activeLeaveCredits).addClass('table-success');
                }
            }
        })

        $("#add-leave-credit-form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.leave_card.store",[$employee->slug, $leaveType])}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    activeLeaveCredits = res.slug;
                    leaveCreditsTbl.draw(false);
                    succeed(form,true,true);
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("body").on("click",".edit-leave-credit-btn",function () {
            let btn = $(this);
            load_modal2(btn);
            let uri = '{{route("dashboard.leave_card.edit","slug")}}';
            uri = uri.replace('slug',btn.attr('data'));
            $.ajax({
                url : uri,
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        leaveApplicationsTbl = $("#leave-applications-table").DataTable({
            dom : 'lBrtip',
            processing: true,
            serverSide: true,
            ajax : '{{route('dashboard.leave_card.view_per_leave_type',[$employee->slug,$leaveType])}}?leaveApplications',
            columns: [
                { data : "date" },
                { data : "leaveApplication" },
            ],
            buttons: [
                {!! __js::dt_buttons() !!}
            ],
            columnDefs:[

            ],
            order:[[0,'desc']],
            responsive: false,
            initComplete: function( settings, json ) {
                // style_datatable("#"+settings.sTableId);
                //Need to press enter to search
                $('#'+settings.sTableId+'_filter input').unbind();
                $('#'+settings.sTableId+'_filter input').bind('keyup', function (e) {
                    if (e.keyCode == 13) {
                        leaveApplicationsTbl.search(this.value).draw();
                    }
                });
            },
            drawCallback: function(settings){

            }
        })
    </script>
@endsection