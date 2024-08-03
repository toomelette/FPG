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
        <x-forms.input label="Position" name="position" cols="6"  :value="$sr"/>
        <x-forms.select label="Appointment Status" name="appointment_status" cols="6" :options="\App\Swep\Helpers\Arrays::appointmentStatus()" :value="$sr"/>

    </div>

    <div class="row mb-2">
        <x-forms.input label="Salary" name="salary" cols="6" class="autonum" :value="$sr"/>
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
    </script>
@endsection

