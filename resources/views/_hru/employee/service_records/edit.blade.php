@php
    /** @var \App\Models\EmployeeServiceRecord $sr **/
    $rand = Str::random(5);
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-sr-form-'.$rand,
    'slug' => $sr->slug,
])

@section('modal-header')
    {{$sr->position}}
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="Seq. #" name="sequence_no" cols="4" :value="$sr"/>
        <x-forms.input label="Date From" name="from_date" cols="4" type="date" :value="$sr"/>
        <div class="form-group col-md-4 to_date ">
            <label for="to_date">Date To *</label>
            @php
                $value = '';
            @endphp
            @if($sr->upto_date != 1)
                @if($sr->to_date != '')
                    @php
                        $value = \Illuminate\Support\Carbon::parse($sr->to_date)->format('Y-m-d');
                    @endphp
                @endif
            @endif
            <input class="form-control " id="e_to_date" name="to_date" type="date" value="{{$value}}" placeholder="Date To" {{($sr->upto_date == 1)? 'disabled="disabled"':''}}>
            <div class="checkbox no-margin">
                <label>
                    <input type="checkbox" name="upto_date" {{($sr->upto_date == 1)? 'checked':''}}> Upto present
                </label>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <x-forms.select label="Item No. (If applicable)" name="item_no" id="item_no_{{$rand}}" cols="12" :options="[]"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Position" name="position" cols="8"  :value="$sr"/>
        <x-forms.select label="Appointment Status" name="appointment_status" cols="4" :options="\App\Swep\Helpers\Arrays::appointmentStatus()" :value="$sr"/>

    </div>

    <div class="row mb-2">
        <x-forms.select label="Salary Type" name="salary_type" cols="4" :options="\App\Swep\Helpers\Arrays::salaryTypes()" :value="$sr ?? null"/>
        <x-forms.input label="SG/JG/PG" name="grade" cols="4" type="number" :value="$sr ?? null"/>
        <x-forms.select label="Step" name="step" cols="4" :options="\App\Swep\Helpers\Arrays::stepIncements()" :value="$sr ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Monthly Basic Salary" name="monthly_basic" cols="6" target="#annual-salary-{{$rand}}" class="autonum-{{$rand}} monthly_basic"  :value="$sr ?? null"/>
        <x-forms.select label="Due to" name="due_to" cols="6" target="#annual-salary-{{$rand}}" :options="\App\Swep\Helpers\Arrays::serviceRecordDueTo()" :value="$sr ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Salary (Annual)" name="salary" id="annual-salary-{{$rand}}" cols="6" class="autonum-{{$rand}}" :value="$sr"/>
        <x-forms.input label="Mode of Payment" name="mode_of_payment" cols="6" :value="$sr"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Station" name="station" cols="4" :value="$sr"/>
        <x-forms.input label="Government Serve" name="gov_serve" cols="4" :value="$sr"/>
        <x-forms.input label="PSC Serve" name="psc_serve" cols="4" :value="$sr"/>

    </div>

    <div class="row mb-2">
        <x-forms.input label="LWP" name="lwp" cols="4" :value="$sr"/>
        <x-forms.input label="SP Date" name="spdate" cols="4" :value="$sr"/>
        <x-forms.input label="Status" name="status" cols="4" :value="$sr"/>
    </div>

    <div class="row">
        <x-forms.input label="Remarks" name="remarks" cols="12" :value="$sr"/>
    </div>

@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(document).ready(function (){
            AutoNumeric.multiple('.autonum-{{$rand}}', {
                decimalPlaces: 2,
                digitGroupSeparator: ','
            });
        })
        $("#edit-sr-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.employee.service_record","slug")}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PUT',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    sr_active = res.slug;
                    service_records_tbl.draw(false);
                    toast('info','Data successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })

        })
        $("#item_no_{{$rand}}").select2({
            data: plantillas,
            dropdownParent: $("#edit-sr-modal")
        });

        $('#item_no_{{$rand}}').on('select2:select', function (e) {
            let data = e.params.data;
            let form = $(this).parents('form');
            form.find('input[name="position"]').val(data.position);
            form.find('input[name="grade"]').val(data.JG);
        });


        @if(!empty($sr->item_no))
            $('#item_no_{{$rand}}').val({{$sr->item_no}}).change();
        @endif


    </script>
@endsection

